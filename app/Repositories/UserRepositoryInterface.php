<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function insertUsers(array $data): void;
}