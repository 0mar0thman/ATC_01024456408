<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition()
    {
        // نحدد اللغة العربية (مصر)
        $faker = \Faker\Factory::create('ar_EG');

        return [
            'title' => $faker->sentence(3),  // جملة من 3 كلمات
            'description' => $faker->realText(200), // فقرة وصفية قصيرة بالعربي
            'category_id' => \App\Models\Category::factory(),
            'date' => $faker->dateTimeBetween('+1 week', '+1 year'),
            'venue' => $faker->city, // مدينة مصرية
            'price' => $faker->numberBetween(50, 500),
            'capacity' => $faker->numberBetween(50, 200),
            'image' => 'https://picsum.photos/640/480?random=' . $faker->unique()->numberBetween(1, 1000),
        ];
    }
}
