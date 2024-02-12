# 87. Image 雛形作成
![img](public/images/owner_er.png)

### Imageのモデル, マイグレーション, コントローラ
php artisan make:model Image -m  

php artisan make:controller Owner/ImageController --resource

```php
モデル  
$filable = [‘owner_id’, ‘filename’];  

マイグレーション  
$table->foreignId(‘owner_id’)->constrained()
->onUpdate('cascade')
->onDelete('cascade');
$table->string('filename');
$table->string(‘title’)->nulable();

ルート
Route:resource('images', ImageControler:class)
->middleware('auth:owners')->except('show');
```

モデル  
app/Models/Image.php
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'filename'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

}
```

app/Models/Owner.php
```php
use App\Models\Image;

public function shop()
{
return $this->hasOne(Shop::class);
}

// hasManyで複数を持つ
public function image()
{
    return $this->hasMany(Image::class);
}
```

マイグレーション  
database/migrations/create_images_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('filename');
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
```

ルート  
routes/owner.php
```php
use App\Http\Controllers\Owner\ImageController;

Route::resource('images', ImageController::class)
->middleware('auth:owners')->except(['show']);
```
<br>

# 88. Image Index

コントローラ  
constructはShopControlerを参考に  
ログインしているオーナーのみ見ることができる設定  
```php
public function index()
{
$images = Image::where('owner_id', Auth::id())
->orderBy('updated_at', ‘desc') // 降順 (小さくなる)
->paginate(20);
以下略
}
```
ビュー  
shops/index.blade.phpを参考にコンポーネントをまとめるために変更  
<x-thumbnail 略 type=“products” />  

components/thumbnail.blade.php
```php
@php
if($type === 'shops'){
$path = 'storage/shops/';
}
if($type === 'products'){
$path = 'storage/products/';
}
@endphp
<div>
@if(empty($filename))
<img src="{{ asset('images/no_image.jpg')}}">
@else
<img src="{{ asset($path . $filename)}}">
@endif
</div>
```

コントローラ 
app/Http/Controllers/Owner/ImageController.php   
```php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('image'); 
            // null判定
            if(!is_null($id)){ 
              // エロクアントモデルはImage
            $imagesOwnerId = Image::findOrFail($id)->owner->id;
            // キャストで数字に変更
                $imageId = (int)$imagesOwnerId; 
                // 同じでなかったら
                if($imageId !== Auth::id()){ 
                    abort(404);
                }
            }
            return $next($request);
        });
    } 

    public function index()
    {
        $images = Image::where('owner_id', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

        return view('owner.images.index', 
        compact('images'));
    }
```

ビュー  
resources/views/owner/images/index.blade.php  
```php
<div class="flex justify-end mb-4">
  <button onclick="location.href='{{ route('owner.images.create')}}'" 
  class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none 
  hover:bg-indigo-600 rounded text-lg">新規登録する</button>                        
</div> 
<div class="flex flex-wrap">
@foreach ($images as $image )
  <div class="w-1/4 p-2 md:p-4">
    <a href="{{ route('owner.images.edit', ['image' => $image->id ])}}">  
      <div class="border rounded-md p-2 md:p-4">
        <x-thumbnail :filename="$image->filename" type="products" />
        <div class="text-gray-700">{{ $image->title }}</div>
      </div>
    </a>
  </div>
@endforeach
</div>
{{ $images->links() }}　// ページネーション
```

コンポーネント  
resources/views/components/thumbnail.blade.php  
```php
// 入ってくるtypeによって保存先を仕分けする
@php
if($type === 'shops'){
  $path = 'storage/shops/';
}
if($type === 'products'){
  $path = 'storage/products/';
}

@endphp

<div>
  @if(empty($filename))
    <img src="{{ asset('images/no_image.jpg')}}">
  @else
    <img src="{{ asset($path . $filename)}}">
  @endif
</div>
```

リンク作成  
resources/views/layouts/owner-navigation.blade.php
```php
<x-nav-link :href="route('owner.images.index')" :active="request()->routeIs('owner.images.index')">
    画像管理
</x-nav-link>
```
