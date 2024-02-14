# 96. Productの雛形作成
![img](public/images/owner_er.png)

### Product モデル,マイグレーション
php artisan make:model Product -m  

Shop.php ・・ hasMany(Product:class)  
Product.php ・・ belongsTo(Shop:class)  
Product.php ・・ belongsTo(Image:class)->後ほど  
Product.php ・・ belongsTo(SecondaryCategory:class)->後ほど  

### コントローラ
php artisan make:controller Owner/ProductController --resource  

routes/owner.php
```php
use App\Http\Controllers\Owner\ProductController;

Route::resource('products', ProductController::class)
->middleware('auth:owners')->except(['show']);
```

app/Models/Shop.php
```php
use App\Models\Product;

public function product()
{
return $this->hasMany(Product::class);
}
```

app/Models/Product.php
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;

class Product extends Model
{
    use HasFactory;

    public function shop()
    {
    return $this->belongsTo(Shop::class);
    }
}
```
<br>

# 97. Product マイグレーション・シーダー

### Product マイグレーション

外部キー制約  
親を削除するか, 親を削除したときに合わせて削除するか  
テーブル名(shops 複数形)とカラム名(shop_id 単数形_id)が一致するか  
Nullを許容するか  
```php
$table->foreignId(‘shop_id’) // cascadeあり  
$table->foreignId(‘secondary_category_id’) // cascadeなし  
$table->foreignId('image1')->nulable()->constrained('images');  
// null許可、カラム名と違うのでテーブル名を指定  
```

### Product シーダー
リレーションができているか確認したいので  
FKのダミーデータを先に作成  

php artisan make:seed ProductSeeder  
```php
DB:table('products')->insert([
[
'shop_id' => 1,
'secondary_category_id' => 1,
'image1' => 1,
],
[
'shop_id' => 1,
'secondary_category_id' => 2,
'image1' => 2,
] ]);
```

database/migrations/2024_02_14_070119_create_products_table.php  
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('secondary_category_id')
            ->constrained();
            $table->foreignId('image1')
            ->nullable()
            ->constrained('images');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

database/seeders/ProductSeeder.php
```php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'shop_id' => 1,
                'secondary_category_id' => 1,
                'image1' => 1,
            ],
            [
                'shop_id' => 1,
                'secondary_category_id' => 2,
                'image1' => 2,
            ],
        ]);
    }
}
```

database/seeders/DatabaseSeeder.php  
```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
        ]);
    }
}
```

<br>

# 98. Product リレーション

メソッド名をモデル名から変える場合は第２引数必要  
(カラム名と同じメソッドは指定できないので名称変更)  
第２引数で_id がつかない場合は 第３引数で指定必要  
Product.php  
```php
use App\Models\SecondaryCategory;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }
}
```
