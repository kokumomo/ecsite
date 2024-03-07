<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'nike',
                'information' => 'Catch em if you can. Giving you race-day speed to conquer any distance, the Vaporfly 3 is for the chasers, the racers and the elevated pacers who can not turn down the thrill of the pursuit. We reworked the leader of the super shoe pack and tuned the engine underneath to help you chase personal bests from a 10K to marathon. From elite runners to those new to racing, this versatile road-racing workhorse is for those who see speed as a gateway to more miles and more seemingly uncatchable highs.',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'コーヒー豆の選び方',
                'information' => 'コーヒーショップに行くと、色々と情報が多すぎて複雑です。この為、コーヒー豆選びって初心者の方は難しく感じてしまいがちです。そこでこの記事では、コーヒー豆の選び方を基礎から解説しています。',
                'filename' => 'coffee_main.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 3,
                'name' => 'Alphafly',
                'information' => 'Fine-tuned for marathon speed, the Alphafly 3 helps push you beyond what you thought possible. Three innovative technologies power your run: A double dose of Air Zoom units helps launch you into your next step; a full-length carbon fiber plate helps propel you forward with ease; and a heel-to-toe ZoomX foam midsole helps keep you fresh from start to 26.2. Time to leave your old personal records in the dust.',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => 'Pegasus',
                'information' => 'A springy ride for any run, the Pegs familiar, just-for-you feel returns to help you accomplish your goals. This version has the same responsiveness and neutral support you love, but with improved comfort in those sensitive areas of your foot, like the arch and toes. Whether you’re logging long marathon miles, squeezing in a speed session before the sun goes down or hopping into a spontaneous group jaunt, it is still the established road runner you can put your faith in, day after day, run after run.',
                'filename' => '',
                'is_selling' => true
            ],
        ]);
    }
}
