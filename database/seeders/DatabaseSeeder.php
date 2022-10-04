<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Vendor::factory(30)->create();
        \App\Models\User::factory(30)->create();
        \App\Models\CarName::factory(30)->create();
        \App\Models\Car::factory(30)->create();
        \App\Models\Image::factory(30)->create();
        \App\Models\Like::factory(30)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
