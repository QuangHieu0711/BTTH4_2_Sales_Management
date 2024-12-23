<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Faker instance
        $faker = Faker::create();

        // Chèn 200 khách hàng vào bảng customers
        foreach (range(1, 200) as $index) {
            DB::table('customers')->insert([
                'name' => $faker->name(),
                'address' => $faker->address(),
                'phone' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(), // Sử dụng unique() để đảm bảo email là duy nhất
            ]);
        }
    }
}