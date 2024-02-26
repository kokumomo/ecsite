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
                'name' => 'スターバックスコーヒー',
                'information' => 'スターバックスとは？ 「スターバックス」という名前は小説の『白鯨』に由来するもの。 それは、昔のコーヒー商人たちが大海原を航海してきたロマンを想い出させてくれる名前でした。 スターバックスの顔「サイレン」スターバックスのシンボルになっている二つの尾をもつ人魚は、ギリシャ神話に登場する「サイレン」。',
                'filename' => 'staba_logo.png',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'コメダ珈琲',
                'information' => '当時、家業と名前から「米屋の太郎」と呼ばれてたそうです。 それがいつしか「コメヤのタロウ→コメタ」と訛り、いつしか「コメダ」になりました。 ちなみに、人気定番メニュー「シロノワール」は1977年に誕生。 名古屋市瑞穂区に初のロードサイド店舗がオープンした際にできたメニューです。',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 3,
                'name' => 'タリーズコーヒー',
                'information' => 'タリーズコーヒー（Tullys Coffee Corporation）は、アメリカ・ワシントン州シアトルを本拠とする元コーヒーチェーン店。現在は市販コーヒーのブランド名としてのみ名前が残っている。',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => 'ドトールコーヒー',
                'information' => '「ドトール（doutor）」とはポルトガル語で、「医者」「博士」という意味で、英語でいう「doctor」とほぼ同じ意味になります。',
                'filename' => 'dotol_logo.png',
                'is_selling' => true
            ],
            [
                'owner_id' => 5,
                'name' => '上島珈琲',
                'information' => '1933年（昭和8年）、UCC上島珈琲株式会社の前身である「上島忠雄商店」が個人商店として神戸市にて創業したのがはじまりです。 その後、ジャマイカやハワイなどで自社の農園を開設し、当時はまだ生活に馴染みのなかったコーヒーの文化を日本に取り入れていきました。',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 6,
                'name' => 'サンマルクコーヒー',
                'information' => 'サンマルクは、古代東方教会で修道についての著作を残した修道士サンマルク（聖マルク）に由来します。 全国のお客様に美味しい料理 美味しいパンを召し上がって頂き「しあわせな気分にしたい」という思いで創業致しました。 お店から出ていく皆様の後ろ姿が「しあわせ」で輝いていることを私たちは心より願っています。',
                'filename' => '',
                'is_selling' => true
            ],
            
        ]);
    }
}
