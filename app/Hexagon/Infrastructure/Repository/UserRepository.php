<?php

namespace App\Hexagon\Infrastructure\Repository;

use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\Repository\UserInterface;
use App\Models\User;
use App\Services\Traits\CodeGeneratorTrait;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserInterface
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

}
