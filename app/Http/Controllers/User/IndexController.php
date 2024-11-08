<?php

namespace App\Http\Controllers\User;

use App\Hexagon\Application\Requests\Datatable\DatatableRequest;
use App\Hexagon\Application\Services\Datatable\DatatableService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;
use App\Models\User;

class IndexController extends Controller
{
    private DatatableService $service;
    public function __construct(DatatableService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke(DatatableRequest $request) {
        $dto = $request->buildDto();
        $dto->model = User::class;
        $dto->page = $dto->page ? : 1;
        $payload = $this->service->execute($dto);
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
