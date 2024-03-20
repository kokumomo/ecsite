<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
           

            [
                'owner_id' => 1,
                'filename' => 'Brazil.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Colombia.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Ethiopia.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Guatemala.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Indonesia.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Jamaica.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Tanzania.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Yemen.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Kenya.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'Japan.png',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'United-States-of-America.png',
                'title' => 'null',
            ],
            
        ]);
    }
}
