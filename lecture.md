# 38. モデルとマイグレーション

### マルチログイン手順
1. モデル・マイグレーション作成
2. ルート作成
3. ルートサービスプロバイダ設定
4. ガード設定
5. ミドルウェア設定
6. リクエストクラス設定
7. コントローラ＆ブレード作成

### 1. モデルとマイグレーション作成
php artisan make:model Owner -m  
php artisan make:model Admin -m  

-mでマイグレーションファイルも作成  

app/modelsフォルダ以下に生成される  
Authenticatableを継承

<br>

# 39. マイグレーション(パスワードリセット)

php artisan make:migration create_owner_password_resets  
php artisan make:migration create_admin_password_resets  
password_resetsの内容をそれぞれコピー  

<br>

# 40. ルート設定

### 2. ルート設定  
Userで使っているのはweb.phpとauth.php  

Owner用のroutes/owner.php  
Admin用のroutes/admin.phpをそれぞれ作成  

<br>

# 41. ルートサービスプロバイダ

### 3. ルートサービスプロバイダ設定
App/Providers/RouteServiceProvider.php  
Owner, AdminそれぞれホームURLを設定  

```php
public const OWNER_HOME = '/owner/dashboard'  
public const ADMIN_HOME = '/admin/dashboard'  
```

<br>

# 42. ガード設定 config/auth.php

### 4. ガード設定
Laravel標準の認証機能  
config/auth.php  
```php
'guards' => [今期はsession
    'guard-name' => [
        'driver' => 'session', 
        'provider' => 'users',
    ],
],

'Providers' => [今回はEloquent(モデル)]

'Passwordreset => []

ルートでauth:ガード名で認証されたユーザだけにアクセス許可
```

<br>

# 43. Middleware/Authenticate

### 5. Middleware設定
Middleware/Authenticate.php  
ユーザが未認証時のリダイレクト処理
```php
use Illuminate\Support\Facades\Route;

if (! $request->expectsJson()) {
            if(Route::is('owner.*')){
                return route($this->owner_route);
            } elseif(Route::is('admin.*')){
                return route($this->admin_route);
            } else {
                return route($this->user_route);
            }
        }
```

<br>

# 44. Middleware/RedirectAuthenticated

ログイン済みユーザーがアクセスしてきたらRouteserviceProviderにリダイレクト処理  
ガード設定対象のユーザーか  
受信リクエストが名前付きルートに一致するか  
```php
if(Auth::guard(self::GUARD_USER)->check() && $request->routeIs('user.*')){
          return redirect(RouteServiceProvider::HOME);
        }

return $next($request);
```

<br>

# 45. リクエストクラス

### 6. リクエストクラス
App/Http/Requests/Auth/LoginRequest.php  

ログインフォームに入力された値から  
パスワードを比較し、認証する。  

User, Owner, Admin 3つのフォームがあるので、  
routeIs() でルート確認しつつ Auth::guard() を追加
```php
if($this->routeIs('owner.*')){
            $guard = 'owners';
        } elseif($this->routeIs('admin.*')){
            $guard = 'admin';
        } else {
            $guard = 'users';
        }

Auth::guard($guard)->attempt(以下略)
```


<br>

# 46. コントローラ追加修正1

### 7. コントローラ＆ブレード作成
LaravelBreezeインストール時のファイルをコピー後修正  

App/Http/Controllers/Auth  

resources/views/auth  

2.ルート設定の残り (ガード設定)
middleware('auth')->middleware('auth:owners')  

### 7-1. コントローラ
コード編集(user, owner, adminの情報を追記)  

namespaceを合わせる  

view('login')->view('owner.login')  

RouteServiceProvider::HOME ->
RouteServiceProvider::OWNER_HOME  

Auth::logout() -> Auth::guard('owners') -> logout

![img](public/img/service_container.png)

