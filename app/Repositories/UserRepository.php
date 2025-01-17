<?php

namespace App\Repositories;

use App\Models\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function insertUsers(array $data): void
    {
        try {
            foreach ($data as $row) {
                User::create($row);
            }
        } catch (Exception $e) {
            throw new Exception("Данные не записались в БД: " . $e->getMessage());
        }
    }
}