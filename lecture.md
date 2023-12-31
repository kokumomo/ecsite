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
Authenticatable(認証機能)を継承  
```php
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```ー
マイグレーションの$tableをコピー  
```php
$table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
```

<br>

# 39. マイグレーション(パスワードリセット)

php artisan make:migration create_owner_password_resets  
php artisan make:migration create_admin_password_resets  
password_resetsの内容をそれぞれコピー  

```php
$table->string('email')->primary();
$table->string('token');
$table->timestamp('created_at')->nullable();
```
php artisan migrate
