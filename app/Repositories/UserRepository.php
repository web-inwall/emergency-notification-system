<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function insertUsers(array $data): void
    {
        foreach ($data as $row) {
            User::create($row);
        }
    }
}