<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {

        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $middleName = $this->faker->firstName();

        $bio = $firstName.' '.$lastName.' '.$middleName;

        $link = $this->faker->randomElement(['telegram', 'sms', 'gmail']);

        $address = '';

        if ($link === 'telegram') {
            $address = '@'.$firstName;
        } elseif ($link === 'sms') {
            $address = $this->faker->phoneNumber;
        } elseif ($link === 'gmail') {
            $address = $this->faker->email;
        }

        return [
            'bio' => $bio,
            'link' => $link,
            'address' => $address,
        ];
    }

    public static function factory()
    {
        return new UserFactory;
    }
}
