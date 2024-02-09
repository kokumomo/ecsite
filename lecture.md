# 70. オーナーの概要
![img](public/img/owner_er.png)

### オーナーでできること
オーナープロフィール編集 (管理側と同じ)  
店舗情報更新(1オーナー 1店舗)  
画像登録  
商品登録・・  
(画像(4枚)、カテゴリ選択(1つ)、在庫設定)   

<br>

#　71. Shop外部キー制約
### 目的：　Shopのテーブルを作成,owner_idに外部キー制約をつける

### 外部キー制約(FK)
データベースレベルで参照整合性を強制  

Shopモデルとマイグレーション作成    
php artisan make:model Shop -m  
//紐づくモデル名_id  

database/migrations/create_shops_table.php  
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained();
            $table->string('name');
            $table->text('information');
            $table->string('filename');
            $table->boolean('is_selling');
            $table->timestamps();
        });
    }
}
```

### ダミーデータ Seeder
php artisan make:seed ShopSeeder  

database/seeders/ShopSeeder.php  
```php
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
                'name' => 'ここに店名が入ります',
                'information' => 'ここにお店の情報が入ります',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'ここに店名が入ります',
                'information' => 'ここにお店の情報が入ります',
                'filename' => '',
                'is_selling' => true
            ],
        ]);
    }
}
```

database/seeders/DatabaseSeeder.php  
外部キー制約がある場合は、  
事前に必要なデータ(Owner)を設定する  
```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
            ShopSeeder::class,
        ]);
    }
}
```

<br>

# 72. Shop リレーション　１対１

### 目的：　Eloquentを使ったリレーション設定

app/Models/Owner.php　　
```php
use App\Models\Shop;

public function shop()
{
return $this->hasOne(Shop::class);
}
```

Shop
```php
use App\Models\Owner;

public function owner()
{
return $this->belongsTo(Owner::class);
}
```

### Laravel Tinkerで確認
php artisan tinker  

App\Models\Owner::find(1)->shop;  
App\Models\Owner::find(1)->shop->name;  
・・Ownerに紐づくShop情報を取得  
App\Models\Shop::find(1)->owner;  
App\Models\Shop::find(1)->owner->email;  
・・Shopに紐づくOwner情報を取得  
※public functionで設定していますが  
動的プロパティとして()が不要なので注意  