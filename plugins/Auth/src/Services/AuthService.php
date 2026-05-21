<?php

namespace Plugins\Auth\src\Services;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Plugins\Auth\src\Repositories\UserRepository;

class AuthService
{
    public function __construct(
        protected UserRepository $users
    ) {
    }

    public function register(array $data): array
    {
        $data['password'] = Hash::make(
            $data['password'],
            ['rounds' => 12]
        );

        $user = $this->users->create($data);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $data): array
    {
        $token = auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if (!$token) {
            throw new \Exception('Invalid credentials');
        }

        return [
            'user' => auth()->user(),
            'token' => $token
        ];
    }
}
