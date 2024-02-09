# 64. ソフトデリート View側

論理削除(ソフトデリート)->復元できる(ゴミ箱)  
物理削除(デリート)->復元できない  
マイグレーション側  

論理削除(ソフトデリート)->復元できる(ゴミ箱)  
物理削除(デリート)->復元できない  
```php
マイグレーション側  
$table->softDeletes();  
モデル側  
use Iluminate\Database\Eloquent\SoftDeletes;  
モデルのクラス内  
use SoftDeletes;  
```

コントローラ側  
```php
Owner:findOrFail($id)->delete(); //ソフトデリート  
Owner:al(); // ソフトデリートしたものは表示されない  
Owner:onlyTrashed()->get(); //ゴミ箱のみ表示  
Owner:withTrashed()->get(); //ゴミ箱も含め表示  
Owner:onlyTrashed()->restore(); //復元  
Owner:onlyTrashed()->forceDelete(); //完全削除  
ソフトデリートされているかの確認  
$owner->trashed()  
```

### Delete アラート表示(JS)
```php
<form id="delete_{{$owner->id}}" method="post"
action="{{ route('admin.owners.destroy', ['owner' => $owner->id])}}">
@csrf @method(‘delete’)
<a href=“#” data-id="{{ $owner->id }}" onclick="deletePost(this)" >削除</a>
<script>
function deletePost(e) {
'use strict';
if (confirm('本当に削除してもいいですか?')) {
document.getElementById('delete_' + e.dataset.id).submit();
}
}
</script>
```

# 65. ソフトデリート 処理

![img](public/img/restful.png)

マイグレーション側  
database/migrations/create_owners_table.php  
```php
$table->softDeletes();
```

モデル側  
app/Models/Owner.php
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Authenticatable
{
    // SoftDeletes追加
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
```
JSとdeleteボタン追加  
resources/views/admin/owners/index.blade.php
```php
<form id="delete_{{$owner->id}}" method="post" action="{{ route('admin.owners.destroy', ['owner' => $owner->id ] )}}">
    @csrf
    @method('delete')
    <td class="px-4 py-3">
    <a href="#" data-id="{{ $owner->id }}" onclick="deletePost(this)" 
    class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded ">削除</a>                        
    </td>
</form>

<script>
  function deletePost(e) {
      'use strict';
      if (confirm('本当に削除してもいいですか?')) {
      document.getElementById('delete_' + e.dataset.id).submit();
      }
  }
  </script>
```

フラッシュメッセージをsessionに書き換え  
resources/views/components/flash-message.blade.php
```php
@props(['status' => 'info'])

@php
if(session('status') === 'info'){$bgColor = 'bg-blue-300';}
if(session('status') === 'alert'){$bgColor = 'bg-red-500';}
@endphp

@if(session('message'))
  <div class="{{ $bgColor }} w-1/2 mx-auto p-2 text-white">
    {{ session('message' )}}
  </div>
@endif
```

App/Controllers/Admin/OwnerController.php
```php

    return redirect()
    ->with(['message' => 'オーナー登録を実施しました。',
    'status' => 'info']);

    return redirect()
    ->route('admin.owners.index')
    ->with(['message' => 'オーナー情報を更新しました。',
    'status' => 'info']);
        
public function destroy(string $id)
{
    Owner::findOrFail($id)->delete(); //ソフトデリート

    return redirect()
    ->route('admin.owners.index')
    ->with(['message' => 'オーナー情報を削除しました。',
    'status' => 'alert']);
}
```

indexをsessionに書き換え  
resources/views/admin/owners/index.blade.php
```php
<x-flash-message status="session('status')" />
```


# 66. ソフトデリート利用例(期限切れオーナー)

### ソフトデリートを使って一削除データを一時的に保存
月額会員・年間会員で更新期限切れ  
->延滞料金を支払ったら戻せるなど  
->復旧できる手段を残しておく  

注意：データとしては残るので同じメールアドレスで新規登録できない。  
->復旧方法などの案内が別途必要  

ルート  
routes/admin.php
```php
Route::prefix('expired-owners')->
    middleware('auth:admin')->group(function(){
        Route::get('index', [OwnersController::class, 'expiredOwnerIndex'])->name('expired-owners.index');
        Route::post('destroy/{owner}', [OwnersController::class, 'expiredOwnerDestroy'])->name('expired-owners.destroy');
});
```
コントローラ-    
App/Controllers/Admin/OwnerController.php
```php

public function expiredOwnerIndex(){
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners', compact('expiredOwners'));
    }
    
    public function expiredOwnerDestroy($id){
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index'); 
    }
```

ビューの作成  
resources/views/admin/expired-owners.blade.php
```php
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          期限切れオーナー一覧
      </h2>
  </x-slot>

    <table class="table-auto w-full text-left whitespace-no-wrap">
    <thead>
        <tr>
        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">期限が切れた日</th>                            
        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th></thead>
    <tbody>
        @foreach ($expiredOwners as $owner)
        <tr>
        <td class="px-4 py-3">{{ $owner->name }}</td>
        <td class="px-4 py-3">{{ $owner->email }}</td>
        <td class="px-4 py-3">{{ $owner->deleted_at->diffForHumans() }}</td>
        
        <form id="delete_{{$owner->id}}" method="post" action="{{ route('admin.expired-owners.destroy', ['owner' => $owner->id ] )}}">
            @csrf
        //   @method('delete')
            <td class="px-4 py-3">
            <a href="#" data-id="{{ $owner->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded ">完全に削除</a>                        
            </td>
        </form>
        </tr>
        @endforeach
    </tbody>
    </table>
```

resources/views/layouts/admin-navigation.blade.php
```php
 <x-nav-link :href="route('admin.expired-owners.index')" :active="request()->routeIs('admin.owners.index')">
    期限切れオーナー一覧
</x-nav-link>
```
