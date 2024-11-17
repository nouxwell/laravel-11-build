<?php

namespace App\Hexagon\Infrastructure\Repository;

use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Hexagon\Domain\DTO\Request\User\DatatableFilterRequestDto;
use App\Hexagon\Domain\Exceptions\InvalidCredentialsException;
use App\Hexagon\Domain\Exceptions\InvalidVerificationCodeException;
use App\Hexagon\Domain\Exceptions\NotFoundException;
use App\Hexagon\Domain\Exceptions\TwoFactorAlreadyActiveException;
use App\Hexagon\Domain\Exceptions\TwoFactorInactiveException;
use App\Hexagon\Domain\Repository\UserInterface;
use App\Models\User;
use App\Services\Enums\Payload\PayloadExceptionMessage;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Enums\Payload\PayloadModule;
use App\Services\Traits\CodeGeneratorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

class UserRepository extends BaseRepository implements UserInterface
{
    use CodeGeneratorTrait;

    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    protected function getModel(): Model
    {
        return $this->user;
    }


    /**
     * @throws \Exception
     */
    public function register(RegisterRequestDto $dto): int
    {
        $dto->entry_code = $this->generateEntryCode('User');
        $dto->sort_order = $this->generateSort();
        $dto->password = bcrypt($dto->password);
        $user = $this->getModel()::create(array_merge(
            $dto->toArray(),
            ['two_factor_enabled' => 1]
        ));
        return $user->getKey();
    }



    /**
     * Fetch paged data for the datatable with sorting, search, and filter functionality.
     */
    public function fetchPagedDataForDatatable(DatatableRequestDto $option): array
    {
        $filters = $option->filters ? DatatableFilterRequestDto::from($option->filters) : null;
        $query = App::make($option->model)->newQuery();
        $query->select(['id', 'name', 'surname', 'email', 'username', 'entry_code']);

        $filterResponse = [];

        $this->applySorting($query, $option);

        if ($option->search) {
            $this->applySearchFilter($query, $option->search);
        }

        if ($filters) {
            $this->applyFilters($query, $filterResponse, $filters);
        }

        $paginator = $query->paginate($option->limit, ['*'], 'page', $option->page);
        $paginatorItems = $paginator->getCollection()->toArray();
        return [
            'records' => $paginatorItems,
            'filters' => $filterResponse,
            'recordsTotal' => $paginator->total(),
            'recordsFiltered' => $paginator->total(),
        ];
    }

    /**
     * Validate and sanitize the column name for sorting.
     */
    private function validateAndSanitizeColumn(&$column): void
    {
        $allowedColumns = [
            'id',
            'name',
            'surname',
            'username',
            'email',
            'entry_code'
        ];

        if (!in_array($column, $allowedColumns, true)) {
            $column = 'id';
        }
    }

    /**
     * Apply sorting to the query based on provided column and sort direction.
     */
    private function applySorting(Builder $query, DatatableRequestDto $option): void
    {
        if ($option->column) {
            $this->validateAndSanitizeColumn($option->column);
            $query->orderBy($option->column, $option->sort);
        } else {
            $query->orderBy('id', $option->sort);
        }
    }

    /**
     * Apply search filter to the query.
     */
    private function applySearchFilter(Builder $query, string $searchTerm): void
    {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%$searchTerm%")
                ->orWhere('surname', 'LIKE', "%$searchTerm%")
                ->orWhere('username', 'LIKE', "%$searchTerm%")
                ->orWhere('email', 'LIKE', "%$searchTerm%");
        });
    }

    /**
     * Apply additional filters to the query and update the filter response.
     */
    private function applyFilters(Builder $query, array &$filterResponse, ?DatatableFilterRequestDto $filters = null): void
    {
        if (!empty($filters->name)) {
            $query->where('name', 'LIKE', "%" . $filters->name . "%");
            $filterResponse['name'] = $filters->name;
        }

        if (!empty($filters->surname)) {
            $query->where('surname', 'LIKE', "%" . $filters->surname . "%");
            $filterResponse['surname'] = $filters->surname;
        }

        if (!empty($filters->username)) {
            $query->where('username', 'LIKE', "%" . $filters->username . "%");
            $filterResponse['username'] = $filters->username;
        }

        if (!empty($filters->email)) {
            $query->where('email', 'LIKE', "%" . $filters->email . "%");
            $filterResponse['email'] = $filters->email;
        }

        if ($filters->softDelete) {
            $query->where('soft_delete', $filters->softDelete);
            $filterResponse['softDelete'] = $filters->softDelete;
        }
    }

    public function fetchPagedDataForSelect(SelectRequestDto $option): array
    {
        $query = App::make($option->model)->newQuery();

        $query->selectRaw("CONCAT('', id) as value, name as label")
            ->where('soft_delete', false)
            ->orderBy('name', 'ASC');

        if ($option->value) {
            if (is_array($option->value)) {
                $query->whereIn('id', $option->value);
            } else {
                $query->where('id', $option->value);
            }
        }

        if ($option->search) {
            $query->where('name', 'LIKE', "%$option->search%")
                ->orWhere('surname', 'LIKE', "%$option->search%")
                ->orWhere('username', 'LIKE', "%$option->search%")
                ->orWhere('email', 'LIKE', "%$option->search%");
        }

        $paginator = $query->paginate($option->limit, ['*'], 'page', $option->page);
        $paginatorItems = $paginator->getCollection()->toArray();
        return [
            'records' => $paginatorItems,
            'recordsTotal' => $paginator->total(),
            'recordsFiltered' => $paginator->total(),
        ];
    }

    /**
     * @throws NotFoundException
     */
    public function find(int|string $id): ?User
    {
        $user = User::find($id);
        if (!$user)
            throw new NotFoundException(PayloadModule::USER);

        return $user;
    }


    /**
     * @throws NotFoundException
     */
    public function verify(int|string $id): array
    {
        $result = [];
        $result['status'] = true;
        $result['message'] = __(PayloadMessage::EMAIL_VERIFIED);

        $user = $this->find($id);

        if ($user->hasVerifiedEmail()) {
            $result['status'] = false;
            $result['message'] = __(PayloadExceptionMessage::USER_ALREADY_VERIFIED);
        }

        $user->markEmailAsVerified();
        return $result;
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     * @throws TwoFactorAlreadyActiveException
     */
    public function enableTwoFactor(): void
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->two_factor_enabled = true;
        $user->save();
    }


    public function disableTwoFactor(): void
    {
        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->save();
    }

    public function resetTwoFactor(): void
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->save();
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     * @throws TwoFactorInactiveException
     * @throws InvalidVerificationCodeException
     * @throws InvalidCredentialsException
     */
    public function verifyTwoFactor(LoginRequestDto $dto)
    {
        if (!auth()->attempt(['email' => $dto->email, 'password' => $dto->password])) {
            throw new InvalidCredentialsException();
        }

        $user = Auth::user();

        if (!$user->two_factor_enabled) {
            throw new TwoFactorInactiveException();
        }

        // Gelen 2FA kodunu doğrula
        $google2fa = new Google2FA();

        if (!$google2fa->verifyKey($user->two_factor_secret, $dto->verificationCode)) {
            throw new InvalidVerificationCodeException();
        }

    }

}
