<?php

namespace Database\Factories;

use App\Models\Notification_Recipient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification_Recipient>
 */
class Notification_RecipientFactory extends Factory
{
    protected $model = Notification_Recipient::class;

    public function definition()
    {
        return [];
    }

    public static function factory()
    {
        return new Notification_RecipientFactory;
    }
}
