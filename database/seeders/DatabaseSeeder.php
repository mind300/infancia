<?php

namespace Database\Seeders;

use App\Models\Nursery;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        Nursery::factory()->create([
            'name' => 'Nursery 1',
            'email' => 'nursery1@gmail.com',
            'phone' => '01000111222',
            'city_id' => 1,
            'country_id' => 1,
            'address' => 'Nasr City',
            'about' => 'About test for nursery 1',
            'branches_number' => 20,
        ]);

        Nursery::factory()->create([
            'name' => 'Nursery 2',
            'email' => 'nursery2@gmail.com',
            'phone' => '01000111222',
            'city_id' => 1,
            'country_id' => 1,
            'address' => 'Helioplis',
            'about' => 'About test for nursery 2',
            'branches_number' => 20,
        ]);

        User::factory()->create([
            'name' => 'Nursery 1',
            'email' => 'nursery1@gmail.com',
            'phone' => '01000111222',
            'password' => '12345test',
            'nursery_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Nursery 1',
            'email' => 'nursery1@gmail.com',
            'phone' => '01000111222',
            'password' => '12345test',
            'nursery_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'nursery@gmail.com',
            'phone' => '01000111333',
            'password' => '12345test',
            'nursery_id' => 2,
        ]);
    }
}
