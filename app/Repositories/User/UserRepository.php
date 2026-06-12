<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    // registers a user
    public function create(array $data): User
    {
        return User::create($data);
    }
}