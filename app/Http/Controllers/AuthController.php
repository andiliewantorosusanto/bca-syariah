<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Traits\responseTrait;

class AuthController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request) {
        $response = $this->service->login($request);
        return $this->response($response);
    }
}
