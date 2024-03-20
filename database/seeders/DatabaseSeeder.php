<?php

namespace Database\Seeders;
use App\Models\Product;
use App\Models\Stock;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
            ShopSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            StockSeeder::class,
        ]);
        // Product::factory(100)->create();
        // Stock::factory(100)->create();
    }
}