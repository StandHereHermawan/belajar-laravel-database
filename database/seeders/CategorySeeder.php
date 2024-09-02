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
        DB::table("categories")->insert([
            'id' => 'SMARTPHONE',
            'name' => 'Smartphone',
            'created_at' => '2024-09-01 11:12:13'
        ]);

        DB::table("categories")->insert([
            'id' => 'FOOD',
            'name' => 'Food',
            'created_at' => '2024-09-01 11:12:13'
        ]);

        DB::table("categories")->insert([
            'id' => 'LAPTOP',
            'name' => 'Laptop',
            'created_at' => '2024-09-01 11:12:13'
        ]);

        DB::table("categories")->insert([
            'id' => 'FASHION',
            'name' => 'Fashion',
            'created_at' => '2024-09-01 11:12:13'
        ]);

        DB::table("categories")->insert([
            'id' => 'VOUCHER',
            'name' => 'Voucher',
            'created_at' => '2024-09-01 11:12:13'
        ]);
    }
}
