<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Millennium Falcon',
                'description' => 'Build the legendary Corellian freighter from Star Wars. Features detailed exterior, interior rooms, and iconic minifigures.',
                'price' => 849.99,
                'category_id' => 1, // Star Wars
                'condition' => 'new',
                'piece_count' => 7541,
                'stock' => 3,
                'release_date' => '2017-09-14',
                'tags' => [1, 4, 11, 14], // Rare, Sealed, Mini Figures Included, Popular
            ],
            [
                'name' => 'Hogwarts Castle',
                'description' => 'The ultimate LEGO Harry Potter set featuring the iconic castle with detailed rooms, towers, and magical creatures.',
                'price' => 469.99,
                'category_id' => 5, // Harry Potter
                'condition' => 'new',
                'piece_count' => 6020,
                'stock' => 2,
                'release_date' => '2018-08-15',
                'tags' => [4, 8, 11, 14], // Sealed, Collector Edition, Mini Figures Included, Popular
            ],
            [
                'name' => 'City Police Station',
                'description' => 'Multi-level police station with jail cells, offices, and garage. Includes police vehicles and minifigures.',
                'price' => 89.99,
                'category_id' => 2, // City
                'condition' => 'used',
                'piece_count' => 743,
                'stock' => 5,
                'release_date' => '2020-06-01',
                'tags' => [5, 6, 11], // Used, Complete, Mini Figures Included
            ],
            [
                'name' => 'Technic Bugatti Chiron',
                'description' => 'Replica of the iconic supercar with working 8-speed gearbox, W16 engine, and detailed interior.',
                'price' => 379.99,
                'category_id' => 3, // Technic
                'condition' => 'new',
                'piece_count' => 3599,
                'stock' => 1,
                'release_date' => '2018-08-01',
                'tags' => [1, 4, 8, 15], // Rare, Sealed, Collector Edition, Hard to Find
            ],
            [
                'name' => 'Creator Expert Taj Mahal',
                'description' => 'One of the largest LEGO sets ever. Detailed replica of the famous landmark.',
                'price' => 369.99,
                'category_id' => 7, // Architecture
                'condition' => 'new',
                'piece_count' => 5923,
                'stock' => 1,
                'release_date' => '2017-11-01',
                'tags' => [2, 4, 9, 15], // Retired, Sealed, Limited Edition, Hard to Find
            ],
            [
                'name' => 'Marvel Avengers Tower',
                'description' => 'Multi-story Avengers headquarters with various rooms and superhero minifigures.',
                'price' => 119.99,
                'category_id' => 6, // Marvel
                'condition' => 'used',
                'piece_count' => 1025,
                'stock' => 4,
                'release_date' => '2021-03-01',
                'tags' => [5, 6, 11], // Used, Complete, Mini Figures Included
            ],
            [
                'name' => 'Classic Creative Bricks Box',
                'description' => 'Large collection of classic LEGO bricks in various colors. Perfect for free building.',
                'price' => 49.99,
                'category_id' => 10, // Classic
                'condition' => 'new',
                'piece_count' => 1500,
                'stock' => 15,
                'release_date' => '2019-01-01',
                'tags' => [3, 4], // New, Sealed
            ],
            [
                'name' => 'Ninjago City Gardens',
                'description' => 'Massive multi-level Ninjago city build with detailed shops, rooms, and ninja minifigures.',
                'price' => 299.99,
                'category_id' => 9, // Ninjago
                'condition' => 'new',
                'piece_count' => 5685,
                'stock' => 2,
                'release_date' => '2021-02-01',
                'tags' => [4, 11, 14], // Sealed, Mini Figures Included, Popular
            ],
            [
                'name' => 'Star Wars AT-AT Walker',
                'description' => 'Iconic Imperial walker from The Empire Strikes Back. Features poseable legs and detailed interior.',
                'price' => 159.99,
                'category_id' => 1, // Star Wars
                'condition' => 'used',
                'piece_count' => 1267,
                'stock' => 3,
                'release_date' => '2020-10-01',
                'tags' => [5, 6, 7, 11], // Used, Complete, Missing Box, Mini Figures Included
            ],
            [
                'name' => 'Friends Heartlake City Shopping Mall',
                'description' => 'Three-story shopping mall with various stores, escalator, and Friends minifigures.',
                'price' => 129.99,
                'category_id' => 8, // Friends
                'condition' => 'new',
                'piece_count' => 1032,
                'stock' => 6,
                'release_date' => '2022-01-01',
                'tags' => [3, 4, 11], // New, Sealed, Mini Figures Included
            ],
            [
                'name' => 'Creator 3-in-1 Medieval Castle',
                'description' => 'Build a castle, tower, or marketplace. Three models in one set!',
                'price' => 99.99,
                'category_id' => 4, // Creator
                'condition' => 'new',
                'piece_count' => 1426,
                'stock' => 8,
                'release_date' => '2021-06-01',
                'tags' => [3, 4, 11], // New, Sealed, Mini Figures Included
            ],
            [
                'name' => 'Architecture Statue of Liberty',
                'description' => 'Detailed replica of the iconic New York landmark. Display model.',
                'price' => 119.99,
                'category_id' => 7, // Architecture
                'condition' => 'used',
                'piece_count' => 1685,
                'stock' => 2,
                'release_date' => '2018-06-01',
                'tags' => [5, 6, 12], // Used, Complete, No Instructions
            ],
        ];

        foreach ($products as $product) {
            $tags = $product['tags'];
            unset($product['tags']);

            // Insert product
            $productId = DB::table('products')->insertGetId([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $product['category_id'],
                'condition' => $product['condition'],
                'piece_count' => $product['piece_count'],
                'stock' => $product['stock'],
                'release_date' => $product['release_date'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach tags to product (many-to-many)
            foreach ($tags as $tagId) {
                DB::table('product_tag')->insert([
                    'product_id' => $productId,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
