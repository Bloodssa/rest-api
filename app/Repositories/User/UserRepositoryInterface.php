<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param array $data the payload of the user passed
     * @return \App\Models\User
     */
    public function create(array $data): User;
}
