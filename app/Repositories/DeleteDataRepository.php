<?php

namespace App\Repositories;

use App\Interfaces\DeleteDataRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteDataRepository implements DeleteDataRepositoryInterface
{
    public function deleteDataUsers(): JsonResponse
    {
        DB::beginTransaction();

        try {
            DB::table('recipients')->delete();

            DB::table('notification__recipients')->delete();

            DB::table('notifications')->delete();

            DB::commit();

            return response()->json(['message' => 'Данные успешно удалены из всех таблиц'], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Произошла ошибка при удалении данных: '.$e->getMessage()], 500);
        }
    }
}
