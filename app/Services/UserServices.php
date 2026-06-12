<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserServices
{
    public function __construct(private readonly UserRepositoryInterface $userRepo) {}

    /**
     * @param array $data the payload pass during registration
     * @return \App\Models\User
     */
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepo->create($data);
    }

    /**
     * attemp or auth the user
     * @param array $credentials the email and password etc..
     * @throws ValidationException
     * @return string token of the auth user for every request
     */
    public function attemptLogin(array $credentials): string
    {
        /** @var \Illuminate\Contracts\Auth\StatefulGuard $auth*/
        $auth = auth('api');

        if(!$token = $auth->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password']
            ]);
        }

        return $token;
    }
}