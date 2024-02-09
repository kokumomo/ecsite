<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'アラビカコーヒー',
                'information' => '沼津市若葉町14-16',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => '葉山コーヒー',
                'information' => '沼津市大手町3丁目3-8',
                'filename' => '',
                'is_selling' => true
            ],
        ]);
    }
}
