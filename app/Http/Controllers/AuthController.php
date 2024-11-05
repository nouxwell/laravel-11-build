<?php

namespace App\Http\Controllers;

use App\Hexagon\Application\Requests\Auth\RegisterRequest;
use App\Hexagon\Domain\Exceptions\InvalidClassException;

class AuthController extends Controller
{
    /**
     * @throws InvalidClassException
     */
    public function register(RegisterRequest $request) {
        $dto = $request->buildDto();
    }

    public function login() {

    }

    public function logout() {

    }

    public function refresh() {

    }

    public function profile() {

    }
}
