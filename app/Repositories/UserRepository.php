<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function insertUsers(array $csvData): void
    {
        try {
            DB::beginTransaction();

            if (! empty($csvData)) {
                DB::table('recipients')->insert($csvData);
            } else {
                throw new Exception('There is no data to insert.');
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error when inserting data into the database: '.$e->getMessage());
        }
    }

    public function getUserIdsByBatchId(string $batchId): array
    {
        $userIds = DB::table('recipients')
            ->where('batch_id', $batchId)
            ->pluck('id')
            ->toArray();

        return $userIds;
    }
}
