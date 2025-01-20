<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use App\Models\Notification_User;
use Illuminate\Support\Facades\Hash;
use Database\Factories\AllDataFactory;
use Database\Factories\Notification_UserFactory;
use Database\Factories\NotificationFactory;
use Database\Factories\UserFactory;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = FakerFactory::create();

        $batchId = $faker->unique()->randomNumber(9);

        UserFactory::factory()->count(25)->create(['batch_id' => $batchId]); // Создание 25 записей в таблице users

        $notification = Notification::factory()->create(); // Создание одной записи в таблице notifications
        $userIds = User::pluck('id')->toArray(); // Получаем все id пользователей и преобразуем в массив
        $userIdsString = implode(',', $userIds); // Преобразуем массив user_id в строку

        Notification_UserFactory::factory()->create([
            'notification_id' => $notification->id,
            'user_id' => $userIdsString,
        ]);
    }
}
