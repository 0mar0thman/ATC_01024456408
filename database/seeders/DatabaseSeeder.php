<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
// use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // إنشاء 10 مستخدمين (بما في ذلك أدمن واحد)
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        User::factory(9)->create();

        // إنشاء 5 فئات
        Category::factory(5)->create();

        // إنشاء 20 فعالية
        Event::factory(20)->create();

        // إنشاء 50 حجز
        Booking::factory(50)->create();
    }
}
