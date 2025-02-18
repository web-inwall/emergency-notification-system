<?php

// СТАРЫЙ КОД

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function insertUsers(array $data): void
    {
        DB::beginTransaction(); // Начало транзакции

        try {
            DB::table('recipients')->insert($data);

            DB::commit(); // Фиксация транзакции при успешной вставке
        } catch (Exception $e) {
            DB::rollBack(); // Отмена транзакции при ошибке
            throw new Exception('Данные не записались в БД: '.$e->getMessage());
        }
    }

    public function getUserIdsByBatchId($batchId)
    {
        return DB::table('recipients')
            ->where('batch_id', $batchId)
            ->pluck('id')
            ->toArray();
    }
}

// НОВЫЙ КОД
