<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function insertUsers(array $data): void
    {
        DB::beginTransaction(); // Начало транзакции

        try {
            DB::table('users')->insert($data);

            DB::commit(); // Фиксация транзакции при успешной вставке
        } catch (Exception $e) {
            DB::rollBack(); // Отмена транзакции при ошибке
            throw new Exception("Данные не записались в БД: " . $e->getMessage());
        }
    }

    public function getUserIdsByBatchId($batchId)
    {
        return DB::table('users')
            ->where('batch_id', $batchId)
            ->pluck('id')
            ->toArray();
    }
}
