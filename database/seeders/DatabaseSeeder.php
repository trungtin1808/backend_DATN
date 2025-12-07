<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'User1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'job_seeker',
            'active' => true,
            'phone' => '1234567890',
            'street_address' => '123 Main St',
            'city' => 'Cityville',
            'state' => 'Stateville',
        ]);
    }
}
