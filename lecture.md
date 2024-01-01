# 42. ガード設定 config/auth.php

### 4. ガード設定
Laravel標準の認証機能  

guards・・今回はsession  
Providers・・今回はEloquent(モデル)  
Passwordresetをそれぞれ設定  
```php
<?php
return [
    'defaults' => [
        'guard' => 'users',
        'passwords' => 'users',
    ],
    
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'users' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'owners' => [
            'driver' => 'session',
            'provider' => 'owners',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'owners' => [
            'driver' => 'eloquent',
            'model' => App\Models\Owner::class,
        ],

        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        
        'owners' => [
            'provider' => 'owners',
            'table' => 'owner_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admin' => [
            'provider' => 'admin',
            'table' => 'admin_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

    ],
    'password_timeout' => 10800,
];
```

<br>

# 43. Middleware/Authenticate

### 5. Middleware設定
ユーザが未認証時のリダイレクト処理  
```php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected $user_route = 'user.login';
    protected $owner_route = 'owner.login';
    protected $admin_route = 'admin.login';

    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');
        if (! $request->expectsJson()) {
            if(Route::is('owner.*')){
                return route($this->owner_route);
            } elseif(Route::is('admin.*')){
                return route($this->admin_route);
            } else {
                return route($this->user_route);
            }
        }
    }
}

```

<br>

# 44. Middleware/RedirectAuthenticated

ログイン済みユーザーがアクセスしてきたらRouteserviceProviderにリダイレクト処理  
ガード設定対象のユーザーか  
受信リクエストが名前付きルートに一致するか  
```php
namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    private const GUARD_USER = 'users';
    private const GUARD_OWNER = 'owners';
    private const GUARD_ADMIN = 'admin';

    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(Auth::guard(self::GUARD_USER)->check() && $request->routeIs('user.*')){
          return redirect(RouteServiceProvider::HOME);
        }

        if(Auth::guard(self::GUARD_OWNER)->check() && $request->routeIs('owner.*')){
          return redirect(RouteServiceProvider::OWNER_HOME);
        }

        if(Auth::guard(self::GUARD_ADMIN)->check() && $request->routeIs('admin.*')){
          return redirect(RouteServiceProvider::ADMIN_HOME);
        }

        return $next($request);
    }
}
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
