<?php

namespace App\Http\Controllers\User;

use App\Hexagon\Application\Requests\Datatable\DatatableRequest;
use App\Hexagon\Application\Services\Datatable\DatatableExportService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;
use App\Models\User;

class DatatableExportController extends Controller
{
    private DatatableExportService $service;
    public function __construct(DatatableExportService $service) {
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
        $locale = $request->getLocale();
        $email = auth()->user()->email;
        $fullName = auth()->user()->name . " " . auth()->user()->surname;
        $payload = $this->service->execute($dto, $locale, $email, $fullName);
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
