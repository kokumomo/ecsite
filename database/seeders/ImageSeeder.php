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
                'filename' => 'nike_1.jpeg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_2_1.jpeg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_2_2.jpg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_2.jpeg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_5.jpeg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_9.jpeg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_10.jpeg',
                'title' => 'null',
            ],
            [
                'owner_id' => 1,
                'filename' => 'nike_11.jpeg',
                'title' => 'null',
            ],

            [
                'owner_id' => 2,
                'filename' => 'brazil_logo.jpg',
                'title' => 'null',
            ],
            
        ]);
    }
}
