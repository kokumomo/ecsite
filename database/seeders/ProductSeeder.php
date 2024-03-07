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
        DB::table('products')->insert([
            [
                'shop_id' => 1,
                'secondary_category_id' => 1,
                'image1' => 1,
            ],
            [
                'shop_id' => 2,
                'secondary_category_id' => 1,
                'image1' => 2,
            ],
            [
                'shop_id' => 2,
                'secondary_category_id' => 2,
                'image1' => 2,
            ],
           
            
        ]);
    }
}