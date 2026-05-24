<?php

namespace plugins\Auth\src\Http\Controllers;

use Illuminate\Routing\Controller;
use Kernel\Support\ApiResponse;
use plugins\Auth\src\Services\AuthService;
use plugins\Auth\src\Http\Requests\LoginRequest;
use plugins\Auth\src\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    ) {
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->service->register(
            $request->validated()
        );

        return ApiResponse::success(
            $result,
            'User registered successfully',
            201
        );
    }

    public function login(LoginRequest $request)
    {
        try {

            $result = $this->service->login(
                $request->validated()
            );

            return ApiResponse::success(
                $result,
                'Login successful'
            );

        } catch (\Exception $e) {

            return ApiResponse::error(
                $e->getMessage(),
                401
            );
        }
    }
}
