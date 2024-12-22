<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
     public function run(): void
     {
         $faker = Faker::create();
         foreach (range(1,200) as $index) {
             DB::table("orders")->insert([
                 'customer_id' => $faker->numberBetween(1, 200),
                 'order_date' => $faker->date('Y-m-d'),
                 'status' => $faker->randomElement(['Pending', 'Completed', 'Cancelled', 'Processing']),
             ]);
         }
     }
}
