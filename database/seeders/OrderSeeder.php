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
        $customerCount = DB::table('customers')->count();
        foreach (range(1, 200) as $index) {
            DB::table('orders')->insert([
                'customer_id' => $faker->numberBetween(1, $customerCount),
                'order_date' => $faker->date('Y-m-d'),
                'status' => $faker->randomElement(['pending', 'completed', 'cancelled', 'processing']),
            ]);
        }
     }
}
