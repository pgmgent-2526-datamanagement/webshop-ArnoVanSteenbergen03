<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Rare',
            'Retired',
            'New',
            'Sealed',
            'Used',
            'Complete',
            'Missing Box',
            'Collector Edition',
            'Limited Edition',
            'Exclusive',
            'Mini Figures Included',
            'No Instructions',
            'Vintage',
            'Popular',
            'Hard to Find',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
