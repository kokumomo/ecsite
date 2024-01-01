# 40. ルート設定

### 2. ルート設定  
Userで使っているのはweb.phpとauth.php  

Owner用のroutes/owner.php  
Admin用のroutes/admin.phpをそれぞれ作成  

routes/owner.php  
```php
use App\Http\Controllers\Owner\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Owner\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Owner\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Owner\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Owner\Auth\NewPasswordController;
use App\Http\Controllers\Owner\Auth\PasswordResetLinkController;
use App\Http\Controllers\Owner\Auth\RegisteredUserController;
use App\Http\Controllers\Owner\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
```

<br>

# 41. ルートサービスプロバイダ

### 3. ルートサービスプロバイダ設定
App/Providers/RouteServiceProvider.php  
```php
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // Owner, AdminそれぞれホームURLを設定  
    // それぞれのダッシュボードにログインしたらリダイレクトがかかる  
    public const HOME = '/dashboard';
    public const OWNER_HOME = '/owner/dashboard';
    public const ADMIN_HOME = '/admin/dashboard';

    // サービスプロバイダが読み込まれたら実行される処理　　
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('admin')
                ->as('admin.')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));

            Route::prefix('owner')
                ->as('owner.')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/owner.php'));

            Route::prefix('/')
                ->as('user.')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

        });
    }
}
```
