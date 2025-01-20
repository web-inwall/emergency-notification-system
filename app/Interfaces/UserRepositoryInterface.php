<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function insertUsers(array $userData): void;
    public function getUserIdsByBatchId($batchId);
}
