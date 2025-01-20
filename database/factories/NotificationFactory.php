<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        $word = "Шаблон №" . $this->faker->unique()->randomNumber();
        return [
            'template_name' => $word,
            'message' => $this->faker->sentence,
        ];
    }
    public static function factory()
    {
        return new NotificationFactory();
    }
}
