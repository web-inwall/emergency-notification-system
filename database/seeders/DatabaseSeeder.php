<?php

namespace Database\Seeders;

use App\Models\Notification;
use Database\Factories\Notification_RecipientFactory;
use Database\Factories\UserFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        $batchId = $faker->unique()->randomNumber(9);

        $users = UserFactory::factory()->count(7)->create(['batch_id' => $batchId]); // Создание 25 записей в таблице users

        $notification = Notification::factory()->create(); // Создание одной записи в таблице notifications
        $userIds = $users->pluck('id')->toArray(); // Получаем все id пользователей и преобразуем в массив
        $userIdsString = implode(',', $userIds); // Преобразуем массив recipient_id в строку

        Notification_RecipientFactory::factory()->create([
            'notification_id' => $notification->id,
            'recipient_id' => $userIdsString,
        ]);
    }
}
