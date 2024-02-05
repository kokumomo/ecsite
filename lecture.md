# 51. アプリ名、ロゴ設定

### アプリ名・ロゴ
アプリ名・・.envファイル  
APP_NAME=Kokumomo  

Config/app.php内で設定される  
```php
 'name' => env('APP_NAME', 'Laravel'),
```

ロゴ表示  
publicフォルダに直接置く・・初期ファイル  
storageフォルダ・・フォルダ内画像はgitHubにアップしない  
表側(public)から見れるようにリンク  
php artisan storage:link  
public/storage リンクが生成される  
asset() ヘルパ関数でpublic内のファイルを指定  
asset(“images/logo.png”) を  
components/application-logo.blade.php に記載  

resources/views/admin/auth/login.blade.php
```php
<x-guest-layout>
    管理者用
```

resources/views/layouts/guest.blade.php
```php
<div class="w-28">
    <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </a>
</div>
```

resources/views/components/application-logo.blade.php
```php
<img src="{{ asset("images/logo.png") }}">
```

<br>

# 52. リソースコントローラ

![img](public/img/resource_controller.png)

CRUDを1行のコードでコントローラに割り当てる  

### URL設計を見ながら
POSTの場合は画面不要(blade不要)  
オーナー登録画面・・GETオーナー登録・・POST  

URL/admin/owners  
action index  
名前付きルート route('admin.owners.index')  
Viewファイル(blade) view('admin.owners.index')  
コントローラ Admin/OwnersController@index  

生成コマンド  
php artisan make:controller Admin/OwnersController --resource  

### 目的：ナビゲーションタブ「オーナー管理」を追加したい
ルートとコントローラを作成後ddで確認  

routes/admin.php    
```php
use App\Http\Controllers\Admin\OwnersController;

Route::resource('owners', OwnersController::class)->middleware('auth:admin');
```


app/Http/Controllers/Admin/OwnersController.php
```php
class OwnersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        dd('ナビゲーションタブの「オーナー管理」をクリックすると表示');
    }
}
```

routes/admin.php
```php
use App\Http\Controllers\Admin\OwnersController;
```

resources/views/layouts/admin-navigation.blade.php
```php
<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.owners.index')" :active="request()->routeIs('admin.owners.index')">
        オーナー管理
    </x-nav-link>             
</div>
```



![img](public/img/service_container.png)
