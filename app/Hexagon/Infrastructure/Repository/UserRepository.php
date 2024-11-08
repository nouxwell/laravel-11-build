<?php

namespace App\Hexagon\Infrastructure\Repository;

use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Hexagon\Domain\DTO\Request\User\DatatableFilterRequestDto;
use App\Hexagon\Domain\Repository\UserInterface;
use App\Models\User;
use App\Services\Traits\CodeGeneratorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

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
    public function register(RegisterRequestDto $dto): void
    {
        $dto->entry_code = $this->generateEntryCode('User');
        $dto->sort_order = $this->generateSort();
        $dto->password = bcrypt($dto->password);
        $this->getModel()::create($dto->toArray());
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


}
