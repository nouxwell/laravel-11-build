<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\VerifyService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    private VerifyService $service;
    public function __construct(VerifyService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke($id) {
        $result = $this->service->execute($id);
        return view('auth.verify',compact('result'));
    }
}
