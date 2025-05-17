<?php
// database/factories/BookingFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition()
    {
        $faker = \Faker\Factory::create('ar_EG');

        return [
            'user_id' => \App\Models\User::factory(),
            'event_id' => \App\Models\Event::factory(),
            'tickets' => $faker->numberBetween(1, 5),
            'status' => 'confirmed',
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
        ];
    }
}
