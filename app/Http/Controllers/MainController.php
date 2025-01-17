<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            // Удаление данных из таблицы 'users'
            DB::table('users')->delete();

            // Удаление данных из таблицы 'notification_recipients'
            DB::table('notification__recipients')->delete();

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