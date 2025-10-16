<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Star Wars', 'description' => 'LEGO sets from the Star Wars universe'],
            ['name' => 'City', 'description' => 'Modern city life LEGO sets'],
            ['name' => 'Technic', 'description' => 'Advanced building sets with working functions'],
            ['name' => 'Creator', 'description' => '3-in-1 building sets'],
            ['name' => 'Harry Potter', 'description' => 'LEGO sets from the wizarding world'],
            ['name' => 'Marvel', 'description' => 'Super hero sets from the Marvel universe'],
            ['name' => 'Architecture', 'description' => 'Iconic buildings and landmarks'],
            ['name' => 'Friends', 'description' => 'Heartlake City adventures'],
            ['name' => 'Ninjago', 'description' => 'Ninja action and adventure sets'],
            ['name' => 'Classic', 'description' => 'Traditional LEGO brick sets'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
