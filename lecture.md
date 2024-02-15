# 99. Product Index
![img](public/images/owner_er.png)

コンストラクタを設定(ImageControlerなどを参考に)  
Product:findOrFail($id)->shop->owner->id;  
$products = Owner:findOrFail(Auth:id())->shop-  
>product; //後ほど修正します  
owner/images/index.blade.php を参考  
$images の箇所を $products に変更  

app/Http/Controllers/Owner/ProductController.php  
```php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Product;
use App\Models\SecondaryCategory;
use App\Models\Owner;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('product'); 
            if(!is_null($id)){ 
            $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
                $productId = (int)$productsOwnerId; 
                if($productId !== Auth::id()){ 
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        // EagerLoadingなし
        //$products = Owner::findOrFail(Auth::id())->shop->product;
        
        $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id', Auth::id())->get();

        // dd($ownerInfo);
        // foreach($ownerInfo as $owner){
        // //    dd($owner->shop->product);
        //     foreach($owner->shop->product as $product){
        //         dd($product->imageFirst->filename);
        //     }
        // }

        return view('owner.products.index',
        compact('ownerInfo'));
    }
}
```

resources/views/owner/products/index.blade.php  
```php
<div class="p-2 mt-4 flex justify-end w-full">
    <button onclick="location.href='{{ route('owner.products.create')}}'" class="mb-4 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</button>
</div>
<div class="flex flex-wrap">
    @foreach ($ownerInfo as $owner )
    @foreach($owner->shop->product as $product)
    <div class="w-1/4 p-2 md:p-4">
    <a href="{{ route('owner.products.edit', ['product' => $product->id ])}}">  
    <div class="border rounded-md p-2 md:p-4">
        <x-thumbnail :filename="$product->imageFirst->filename" type="products" />
        <div class="text-gray-700">{{ $product->name }}</div>
    </div>
    </a>
    </div>
    @endforeach
    @endforeach
    </div>
</div>
```

resources/views/layouts/owner-navigation.blade.php
```php
<x-nav-link :href="route('owner.products.index')" :active="request()->routeIs('owner.products.index')">
    商品管理
</x-nav-link>
```
<br>

# 100. Eager Loading

N + 1問題の対策  
リレーション先のリレーション情報を取得  
withメソッド、リレーションをドットでつなぐ  
```php
$ownerInfo = Owner:with(‘shop.product.imageFirst’)
->where(‘id’, Auth:id())->get();
foreach($ownerInfo as $owner)
foreach($owner->shop->product as $product)
{
dd($product->imageFirst->filename);
}
endforeach
```

```php

```

```php

```

```php

```

