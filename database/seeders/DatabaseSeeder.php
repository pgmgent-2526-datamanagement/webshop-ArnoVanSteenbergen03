<?php

namespace Database\Seeders;

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
        // Create test users
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);

        // Create an admin user for Filament
        $this->call([
            \Database\Seeders\AdminUserSeeder::class,
        ]);

        // Seed all tables in correct order
        $this->call([
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\TagSeeder::class,
            \Database\Seeders\ProductSeeder::class,
        ]);
    }
}
