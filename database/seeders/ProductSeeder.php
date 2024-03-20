<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Brazil',
                'information' => '程よい苦味と爽やかな酸味、コクも感じられ癖がなくあっさりとした後味です。 焙煎度によっても変わってきますが、ブラジル産コーヒー豆の基本的な味わいは、酸味はやわらかめとナッツやチョコレートの様な甘い香りです。 味や香りのバランスが良い事から「スタンダード」とされています。',
                'price' => '950',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 4,
                'image1' => 1,
                'image2' => 1,
                'image3' => 1,
                'image4' => 1,
            ],
            [
                'name' => 'Colombia',
                'information' => '南米ではブラジルに次いで第2位の国別生産量を誇るのがコロンビアです。コーヒーの商業取引上の分類であるマイルドコーヒーの代名詞としても知られています。国土の大半が山岳高原地帯で、収穫したコーヒーの運搬にはラバが使われることもあります。そんなコロンビアで栽培されるコーヒー豆の全てがアラビカ種です。コロンビア産のコーヒー豆は、甘い香りとしっかりした酸味とコク、重厚な風味で、バランスが良い特徴があります。',
                'price' => '1026',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 3,
                'image1' => 2,
                'image2' => 2,
                'image3' => 2,
                'image4' => 2,
            ],
            [
                'name' => 'Ethiopia',
                'information' => 'エチオピアはコーヒー発祥の地として有名です。なんと人口の5分の1が生産に関わっていると言われています。生産量は世界5位で、アフリカ内では1位と、さすがコーヒー発祥の地ですね。そんなエチオピア産のコーヒー豆は、非水洗式アラビカの場合、フルーティーな甘い香りとやわらかな酸味とコクが特徴的です。水洗式アラビカの場合には、しっかりした酸味とコク、芳酵で重厚な風味が特徴的です。「モカコーヒー」という名前を聞いたことがある方も多いのではないでしょうか？実はモカコーヒーの95%はエチオピア産です。',
                'price' => '950',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 1,
                'image1' => 3,
                'image2' => 3,
                'image3' => 3,
                'image4' => 3,
            ],
            [
                'name' => 'Guatemala',
                'information' => '一般的には「グアテマラ（ガテマラ）」と呼ばれています。グアテマラのコーヒーは、その多くが山脈の斜面で栽培されています。また栽培している地域によって気候条件も様々で、バラエティに富んだ味わいのコーヒーを生産している国でもあります。世界遺産アンティグアではグアテマラで最初のコーヒー栽培が行われました。グアテマラのコーヒーは、甘い香りとすっきりした酸味、爽やかな後味が特徴的です。',
                'price' => '1026',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 4,
                'image1' => 4,
                'image2' => 4,
                'image3' => 4,
                'image4' => 4,
            ],
            [
                'name' => 'Indonesia',
                'information' => 'インドネシアは世界でも随一のコーヒー豆の産地としての評価を受けており、その品質とユニークな風味は多くのコーヒー愛好家を引きつけています。 独特の微気候と火山性の肥沃な土壌によって育てられた豆は、絶妙な甘みと苦みのバランスを持つ独特な風味を持っています。',
                'price' => '1026',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 6,
                'image1' => 5,
                'image2' => 5,
                'image3' => 5,
                'image4' => 5,
            ],
            [
                'name' => 'Jamaica',
                'information' => 'ジャマイカは「コーヒーの王様」というニックネームがつく「ブルーマウンテン」を栽培していることで有名です。もしかすると、ジャマイカにコーヒー産業のイメージが無い方もいるかもしれません。しかし、コーヒー好きの方は必ず知っているコーヒー産業の国なので覚えておきましょう。そんなブルーマウンテンを栽培しているジャマイカですが、全ての場所でブルーマウンテンの栽培が行われているわけではありません。限られたエリアでのみ栽培をされています。ブルーマウンテンはなんといっても繊細な味わいで、香り、酸味、コクのバランスがとれた軽やかな風味が特徴的です。コーヒーを飲んだときに感じる全ての感覚に置いて「絶妙」を感じることができるでしょう。',
                'price' => '2146',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 7,
                'image1' => 6,
                'image2' => 6,
                'image3' => 6,
                'image4' => 6,
            ],
            [
                'name' => 'Tanzania',
                'information' => 'タンザニア産のコーヒー豆と言われても、あまりピンとこない方も多いでしょう。地理的にもどこか分からないと思う方もいるはずです。しかし、「キリマンジャロ」というコーヒー豆の種類を知っている方はどのぐらいいるでしょうか。きっと多くの方がキリマンジャロの名前を知っていると思います。実は、この「キリマンジャロ」の豆を生産しているのがタンザニアです。これを知ると、一気に親近感が湧いてきますよね。そんなタンザニア産のコーヒー豆の特徴は、しっかりした酸味とコク、芳酵で重厚な風味です。そのため、タンザニア産のコーヒーは酸味が強いのですが、「すっぱい」と感じる酸味ではなく質の良い酸味で、スッキリとしていて人気です。',
                'price' => '1026',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 2,
                'image1' => 7,
                'image2' => 7,
                'image3' => 7,
                'image4' => 7,
            ],
            [
                'name' => 'Yemen',
                'information' => 'アラビア半島の西側に位置するイエメンは、エチオピアに次いで古くからコーヒーが栽培されている国です。イエメンとエチオピアで生産されるコーヒーは、かつてイエメンにあった積み出し港「モカ港」にちなんで「モカ」と呼ばれています。「モカマタリ」は、イエメンの代表的なコーヒーです。そんなイエメンで栽培されるコーヒー豆の特徴はなんといっても香りです。まるでお花のような香りは、イエメン産のコーヒー豆だからこそ嗅ぐことができる香りです。香りを楽しみながら飲むのが一番適しているため、基本的にはミルクなどをいれずブラックで飲むことがおすすめされています。',
                'price' => '950',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 1,
                'image1' => 8,
                'image2' => 8,
                'image3' => 8,
                'image4' => 8,
            ],
            [
                'name' => 'Kenya',
                'information' => 'ケニアのコーヒー産業の歴史はまだまだ浅いです。しかし、現在ケニア産コーヒー豆はヨーロッパでかなり高額で取引されるほど質が高いと有名です。近年注目を浴びている国で、最近では有名なコーヒーショップで豆の取り扱いも行われているため目にしたことがある方もいるのではないでしょうか？肉厚なコーヒー豆はケニア産の豆の特徴でもあります.そんなケニア産のコーヒー豆の特徴は、しっかりした酸味とコク、芳酵で重厚な風味です。上品な香りが人気で、コーヒーを淹れながら香りをかぐと心が落ち着くでしょう。',
                'price' => '1609',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 3,
                'image1' => 9,
                'image2' => 9,
                'image3' => 9,
                'image4' => 9,
            ],
            [
                'name' => 'Japan',
                'information' => 'いわゆるコンビニコーヒーで深煎りで苦味とコクが強い。',
                'price' => '110',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 7,
                'image1' => 10,
                'image2' => 10,
                'image3' => 10,
                'image4' => 10,
            ],
            [
                'name' => 'USA',
                'information' => 'やわらかな酸味と滑らかな口当たりが特長。 コーヒー本来の果実味を感じさせるフルーティな甘い香り、そして苦みの少ないまろやかな味わいから、飲みやすさやさっぱりしたアフターテイストを感じる人が多いようです。',
                'price' => '4752',
                'is_selling' => 1,
                'sort_order' => 1,
                'shop_id' => 1,
                'secondary_category_id' => 6,
                'image1' => 11,
                'image2' => 11,
                'image3' => 11,
                'image4' => 11,
            ],
        ]);
    }
}