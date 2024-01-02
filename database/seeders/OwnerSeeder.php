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
                'name' => 'test1',
                'email' => 'test@test1.com.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'test2',
                'email' => 'test@test2.com.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'test3',
                'email' => 'test@test3.com.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
        ]);
    }
}
