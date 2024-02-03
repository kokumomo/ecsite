# 46. コントローラ追加修正1

### 7. コントローラ＆ブレード作成
app/Http/Controllers/User/Auth  
app/Http/Controllers/Owner/Auth  
app/Http/Controllers/Admin/Auth  

resources/views/user  
resources/views/owner  
resources/views/admin  

2.ルート設定の残り (ガード設定)
middleware('auth')->middleware('auth:owners')  

### 7-1. コントローラ
コード編集(user, owner, adminの情報を追記)  

namespaceを合わせる  

view('login')->view('owner.login')  

RouteServiceProvider::HOME ->
RouteServiceProvider::OWNER_HOME  

Auth::logout() -> Auth::guard('owners') -> logout