<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Notification;
use App\Models\Notification_User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification_User>
 */
class Notification_UserFactory extends Factory
{
    protected $model = Notification_User::class;

    public function definition()
    {
        return [];
    }

    public static function factory()
    {
        return new Notification_UserFactory();
    }
}
