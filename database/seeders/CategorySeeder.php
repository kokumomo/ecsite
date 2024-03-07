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
        DB::table('primary_categories')->insert([
            [
                'name' => 'シナモンロースト（浅煎り）',
                'sort_order' => '1',
            ],
            [
                'name' => 'ミディアムロースト（やや浅煎り）',
                'sort_order' => '2',
            ],
            [
                'name' => 'ハイロースト（中煎り）',
                'sort_order' => '3',
            ],
            [
                'name' => 'シティロースト（中煎り）',
                'sort_order' => '4',
            ],
            [
                'name' => 'フルシティロースト（やや深煎り）',
                'sort_order' => '5',
            ],
            [
                'name' => 'フレンチロースト（深煎り）',
                'sort_order' => '6',
            ],
            [
                'name' => 'イタリアンロースト（深煎り）',
                'sort_order' => '7',
            ],
        
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '強い酸味',
                'sort_order' => '1',
                'primary_category_id' => 1
            ],
            [
                'name' => '酸味強め・苦味ほぼ無し',
                'sort_order' => '2',
                'primary_category_id' => 1
            ],
            [
                'name' => '酸味ややあり。苦味も少し',
                'sort_order' => '3',
                'primary_category_id' => 1
            ],
            [
                'name' => 'バランス型',
                'sort_order' => '4',
                'primary_category_id' => 1
            ],
            [
                'name' => '苦味やや強め。酸味は僅か',
                'sort_order' => '5',
                'primary_category_id' => 1
            ],
            [
                'name' => '苦味強め。酸味ほぼ無し',
                'sort_order' => '6',
                'primary_category_id' => 1
            ],
            [
                'name' => '苦味、コク強め',
                'sort_order' => '7',
                'primary_category_id' => 1
            ],
        
        ]);
    }
}

