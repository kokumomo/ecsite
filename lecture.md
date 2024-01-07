# 57. 一覧画面(tailblocks利用)

```php
<table>
    <thead>
        <tr>
            <th >名前</th>
            <th>メールアドレス</th>
            <th>作成日</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($owners as $owner)
        <tr>
            <td>{{ $owner->name }}</td>
            <td>{{ $owner->email }}</td>
            <td>1{{ $owner->created_at->diffForHumans() }}</td>
            <td>
            <input name="plan" type="radio">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

<br>

# 5８. Create 新規作成

resources/views/admin/owners/create.blade.php

<br>

# 59. Store 保存の解説
# 60. 保存(簡易バリデーション)
```php
<form method="post" action="{{ route('admin.owners.store')}}">
    @csrf
    <div class="-m-2">
        <div class="p-2 w-1/2 mx-auto">
        <div class="relative">
            <label for="name">オーナー名</label>
            <input type="text" id="name" name="name" value="{{ old('name')}}">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
    </div>
    <div class="p-2 w-1/2 mx-auto">
        <div class="relative">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email')}}">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>
        <div class="p-2 w-1/2 mx-auto">
        <div class="relative">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
    </div>
    <div class="p-2 w-1/2 mx-auto">
        <div class="relative">
            <label for="password_confirmation">パスワード確認</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>
    <div class="p-2 w-full flex justify-around mt-4">
        <button type="button" onclick="location.href='{{ route('admin.owners.index')}}'">戻る</button>
        <button type="submit">登録する</button>                        
    </div>
</form>
```
App/Controllers/Admin/OwnerController.php
```php
use Illuminate\Support\Facades\Hash;

public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:owners',
            'password' => 'required|string|confirmed|min:8',
        ]);

        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.owners.index');
    }
```

<br>

# 61. フラッシュメッセージ
英語だとtoaster  
Sessionを使って一度だけ表示  

色々なやり方がある
Controller側  
1.session()->flash('message', '登録ができました。');  
2.Session::flash('message','');  
3.redirect()->with('message','');  
数秒後に消したい場合はJSも必要  

App/Controllers/Admin/OwnerController.php  
```php
public function store(Request $request)
    {
        return redirect()
        ->route('admin.owners.index')
        ->with('message', 'オーナー登録を実施しました。');
    }
```

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

resources/views/admin/owners/index.blade.php
```php
<x-flash-message status="info" />
```

![img](public/images/m54.png)

