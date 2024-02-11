# 76. Shop Index(ルート、コントローラ、ビュー)
![img](public/img/owner_er.png)

### 目的：　Shop 表示までの設定がしたい
ルート  
Index, edit, updateを作成  
owner.shops.index など  

ビュー    
resources/views/owner/shops/index.blade.phpを作成    
resources/views/owner/shops/edit.blade.phpを作成  
ロゴサイズ調整, owner-navigation  

コントローラー・・ShopControler  

```php
認証をかけたいので  
__construct  
$this->middleware(‘auth:owners’):  

indexで一覧を表示する際に  
ログインしているownerのidを取得しつつ  
ownerが作成したshopを表示したい(Auth:id();)

use Iluminate\Support\Facades\Auth;  
$ownerId = Auth:id(); // 認証されているid  
$shops = Shop:where(‘owner_id’, $ownerId)->get();  
// whereは検索条件  
```

routes/owner.php
```php
use App\Http\Controllers\Owner\ShopController;

Route::prefix('shops')->
    middleware('auth:owners')->group(function(){
        Route::get('index', [ShopController::class, 'index'])->name('shops.index');
        Route::get('edit/{shop}', [ShopController::class, 'edit'])->name('shops.edit');
        Route::post('update/{shop}', [ShopController::class, 'update'])->name('shops.update');
});
```

php artisan make:controller Owner/ShopController  

app/Http/Controllers/Owner/ShopController.php  
```php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');
    } 

    public function index()
    {
        $ownerId = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();

        return view('owner.shops.index', 
        compact('shops'));
    }

    public function edit($id)
    {
        dd(Shop::findOrFail($id));
    }

    public function update(Request $request, $id)
    {

    }
}
```

resources/views/layouts/owner-navigation.blade.php  
```php
<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('owner.shops.index')" :active="request()->routeIs('owner.shops.index')">
        店舗情報
    </x-nav-link>
</div>

<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('owner.shops.index')" :active="request()->routeIs('owner.shops.index')">
            店舗情報
        </x-responsive-nav-link>
    </div>
```

resources/views/owner/shops/index.blade.php  
```php
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @foreach ($shops as $shop )
                {{ $shop->name }}
                @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```
<br>

# 77. Shop コントローラ　ミドルウェア

### Shop ルートパラメータの注意
/owner/shops/edit/2/  
edit, updateなど URLにパラメータを使う場合  
URLの数値を直接変更すると  
他のオーナーのShopが見れてしまう・・NG  

### 目的：ログイン済みオーナーのShop URLでなければ404表示

### Shop コントローラミドルウェア

database/seeders/ShopSeeder.php
```php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
            // dd($request);
            // dd($request->route()->parameter('shop')); //文字列
            // dd(Auth::id()); //数字

            $id = $request->route()->parameter('shop'); //shopのid取得
            if(!is_null($id)){ // null判定
            $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id(); //認証されているid
                $shops = Shop::where('owner_id', $ownerId)->get();

                if($shopId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }
            return $next($request);
        });
    } 
}
```
<br>

# 78. カスタムエラーページ

### 404画面をカスタマイズするなら

Vendorフォルダ内ファイルは  
更新がかかると上書きされてしまう可能性がある  
下記コマンドでresources/views/errorsに  
関連ファイル作成  
php artisan vendor:publish ̶tag=laravel-errors  