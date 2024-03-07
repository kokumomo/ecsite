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
                'name' => 'nike',
                'email' => 'nike@nikes.com',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => 'coffee',
                'email' => 'coffee@coffees.com',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => '大塚店',
                'email' => 'sm0497@shimamura.gr.jp',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => '学園通り店',
                'email' => 'sm0507@shimamura.gr.jp',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => '裾野店',
                'email' => 'sm0509@shimamura.gr.jp',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => '西友沼津店',
                'email' => 'sm0569@shimamura.gr.jp',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
            [
                'name' => '谷田店',
                'email' => 'sm0510@shimamura.gr.jp',
                'password' => Hash::make('Password123'),
                'created_at' => '2024/01/01 11:11:11'
            ],
        ]);
    }
}