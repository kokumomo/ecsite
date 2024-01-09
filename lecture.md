# 67. ページネーション
![img](public/images/restful.png)

database/seeders/OwnerSeeder.phpにデータ追加  
php artisan migrate:refresh --seed

App/Http/Controllers/Admin/OwnerController.php　　
```php
$owners = Owner::select('id', 'name', 'email', 'created_at')->paginate(3);
        return view('admin.owners.index', compact('owners'));
```

resources/views/admin/owners/index.blade.php
```php
{{ $owners->links() }}
```

### ページネーションの日本語化
vendorフォルダ内ファイルをコピー　　  
php artisan vendor:publish --tag=laravel-pagination　　

resources/views/vendor/pagination/tailwindcss.blade.php
```php
<p class="text-sm text-gray-700 leading-5">
    <span class="font-medium">{{ $paginator->total() }}</span>
    件中
    @if ($paginator->firstItem())
        <span class="font-medium">{{ $paginator->firstItem() }}</span>
        件〜
        <span class="font-medium">{{ $paginator->lastItem() }}</span>
    @else
        {{ $paginator->count() }}
    @endif
    件 を表示
</p>
```
<br>

# 68. その他

新規登録はしない、ようこそ画面不要  
->registration, welcome コメントアウト  

OwnerController::class,showは今回使わない  
```php
Route::resource('owners', OwnersController::class)
->middleware('auth:admin')->except(['show']);
```

### View側の編集
レスポンシブ対応  
x方向(横方向)のmargin,paddingにmd:をつける(768px以上、タブレット)  
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
    <x-nav-link :href="route('admin.expired-owners.index')" :active="request()->routeIs('admin.expired-owners.index')">
        期限切れオーナー一覧
    </x-nav-link>             
</div>
```

resources/views/admin/owners/index.blade.php