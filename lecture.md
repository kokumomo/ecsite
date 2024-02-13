# 94. Category モデル、マイグレーション
![img](public/images/owner_er.png)

Category モデル  
php artisan make:model PrimaryCategory -m  
php artisan make:model SecondaryCategory  
モデル 1対多のリレーション  
Primary  

```php
Public function secondary()  
{
return $this->hasMany(SecondaryCategory:class);
}
```

Secondaryからは belongsTo  

### Category マイグレーション
1つのファイルに2つ記載  
ファイル名を create_categories_table.phpに変更  
クラス名も CreateCategoriesTable  
Downメソッドは先にsecondaryを削除する  
(primaryを先に書くと migrate:refresh 時に外部キーエラー発生)  

モデル1  
app/Models/PrimaryCategory.php
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory;

class PrimaryCategory extends Model
{
    use HasFactory;

    public function secondary()
    {
        return $this->hasMany(SecondaryCategory::class);
    }
}

```

モデル2  
app/Models/SecondaryCategory.php
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PrimaryCategory;

class SecondaryCategory extends Model
{
    use HasFactory;

    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class);
    }
}
```
マイグレーション  
database/migrations/create_categories_table.php
```php
 use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('primary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            $table->timestamps();
        });

        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            $table->foreignId('primary_category_id')
            ->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secondary_categories');
        Schema::dropIfExists('primary_categories');
    }
};
```

<br>

# 95. Category ダミーデータ

php artisan make:seed CategorySeeder  

database/seeders/CategorySeeder.php  
```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'キッズファッション',
                'sort_order' => 1,
            ],
            ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '靴',
                'sort_order' => 1,
                'primary_category_id' => 1
            ],
            ]);
        }
}
```

