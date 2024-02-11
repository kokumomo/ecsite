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
            [
                'owner_id' => 3,
                'name' => 'スターバックスコーヒー',
                'information' => '沼津市花園町10-15',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => 'コメダ珈琲',
                'information' => '沼津市鳥谷2-1',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 5,
                'name' => 'むさしの森コーヒー',
                'information' => '沼津市上香貫1375',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 6,
                'name' => 'ドトールコーヒー',
                'information' => '沼津市中沢田375-3',
                'filename' => '',
                'is_selling' => true
            ],
        ]);
    }
}
