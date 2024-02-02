# 85. Shop Editの残り
![img](public/images/owner_er.png)

### 目的1：　Edit画面の作成

Imageのモデルとマイグレーションを作成  
php artisan make:model Image -m  

モデル  
$filable = [‘owner_id’, ‘filename’];  

マイグレーション  
$table->foreignId(‘owner_id’)->constrained()  // 外部キー制約
->onUpdate('cascade')  // 親テーブルのデータが変更されたときに、同じキーを持つ子テーブルのデータも自動的に変更される
->onDelete('cascade');  // 親テーブルが削除されたときに、同じキーを持つ子テーブルのデータも自動的に削除
$table->string('filename');  
$table->string(‘title’)->nullable();  空でも登録できるようにnullable()

Imageのコントローラ
リソースコントローラを使ってCRUDのアクションやそのルーティングが自動的に
php artisan make:controller Owner/ImageController - ̶resource  

ルート  
Route:resource('images',  
ImageControler:class)  
->middleware('auth:owners')->except('show');  

```php

```

```php

```

