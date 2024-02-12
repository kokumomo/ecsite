<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('owners')->insert([
            [
                'name' => 'Starbucks Corporation',
                'email' => 'test@test1.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'コメダホールディングス',
                'email' => 'test@test2.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'Tullys Coffee Corporation',
                'email' => 'test@test3.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => '株式会社ドトール・日レスホールディングス',
                'email' => 'test@test4.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'UCC上島珈琲株式会社',
                'email' => 'test@test5.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'サンマルクホールディングス',
                'email' => 'test@test6.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
        ]);
    }
}
