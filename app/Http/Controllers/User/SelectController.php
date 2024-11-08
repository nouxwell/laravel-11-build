<?php

namespace App\Http\Controllers\User;

use App\Hexagon\Application\Requests\Select\SelectRequest;
use App\Hexagon\Application\Services\Select\SelectService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;
use App\Models\User;

class SelectController extends Controller
{
    private SelectService $service;
    public function __construct(SelectService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke(SelectRequest $request) {
        $dto = $request->buildDto();
        $dto->model = User::class;
        $dto->page = $dto->page ? : 1;
        $payload = $this->service->execute($dto);
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
