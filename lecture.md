# 6. Laravelのインストール
composer create-project laravel/laravel umarche "8.*" --prefer-dist

cd umarche
php artisan serve
もしDB接続できなかったら
https://coinbaby8.com/access_denied.html
<br><br>

# 7. DB設定、マイグレート
初期設定  
Mysql DB作成   
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock を.envに追加  
php artisan migrate  
タイムゾーン、言語設定 config/app.php  
.env 設定(環境ファイル)  
バリデーションの言語ファイル  
デバッグバー  