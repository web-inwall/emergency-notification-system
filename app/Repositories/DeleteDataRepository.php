<?php

namespace App\Repositories;

use App\Interfaces\DeleteDataRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteDataRepository implements DeleteDataRepositoryInterface
{
    public function deleteDataUsers()
    {
        DB::beginTransaction();

        try {
            // Удаление данных из таблицы 'recipients'
            DB::table('recipients')->delete();

            // Удаление данных из таблицы 'notification__recipients'
            DB::table('notification__recipients')->delete();

            // Удаление данных из таблицы 'notifications'
            DB::table('notifications')->delete();

            DB::commit();

            return response()->json(['message' => 'Данные успешно удалены из всех таблиц'], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Произошла ошибка при удалении данных: '.$e->getMessage()], 500);
        }
    }
}
