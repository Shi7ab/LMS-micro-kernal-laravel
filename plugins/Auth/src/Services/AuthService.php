<?php

namespace plugins\Auth\src\Services;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use plugins\Auth\src\Repositories\UserRepository;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        $user = $this->users->findByEmail($data['email']);

        if (!$user) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
