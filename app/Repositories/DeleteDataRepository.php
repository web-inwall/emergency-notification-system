<?php
namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Interfaces\DeleteDataRepositoryInterface;

class DeleteDataRepository implements DeleteDataRepositoryInterface 
{
    public function deleteDataUsers() 
    {
        DB::beginTransaction();

        try {
            // Удаление данных из таблицы 'users'
            DB::table('users')->delete();

            // Удаление данных из таблицы 'notification__users'
            DB::table('notification__users')->delete();

            // Удаление данных из таблицы 'notifications'
            DB::table('notifications')->delete();

            DB::commit();

            return response()->json(['message' => 'Данные успешно удалены из всех таблиц'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Произошла ошибка при удалении данных: ' . $e->getMessage()], 500);
        }
    }
}