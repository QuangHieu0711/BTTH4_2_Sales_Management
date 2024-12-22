<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 200) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word, 
                'description' => $faker->sentence(10), 
                'price' => $faker->randomFloat(2, 10, 1000), 
                'quantity' => $faker->numberBetween(1, 100), 
            ]);
        }
    }
}
