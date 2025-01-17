<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function insertUsers(array $userData): void;
}