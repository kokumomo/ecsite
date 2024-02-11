# 79. Shop Index画面
![img](public/images/owner_er.png)

### 目的：　Shop Index画面からEdit画面に遷移したい

resources/views/owner/shops/index.blade.php
```php
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  @foreach ($shops as $shop )
                    <div class="w-1/2 p-4">
                    <a href="{{ route('owner.shops.edit', ['shop' => $shop->id ])}}">  
                    <div class="border rounded-md p-4">
                      <div class="mb-4">
                      @if($shop->is_selling)
                        <span class="border p-2 rounded-md bg-blue-400 text-white">販売中</span>
                      @else
                      <span class="border p-2 rounded-md bg-red-400 text-white">停止中</span>
                      @endif  
                      </div>
                      <div class="text-xl">{{ $shop->name }}</div>
                      <div>
                          @if(empty($shop->filename))
                            <img src="{{ asset('images/no_image.jpg')}}">
                          @else
                            <img src="{{ asset('storage/shops/' . $shop->filename)}}">
                          @endif
                      </div>
                    </div>
                    </a>
                    </div>
                  @endforeach
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
```

resources/views/layouts/owner-navigation.blade.php  
```php
<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('owner.shops.index')" :active="request()->routeIs('owner.shops.index')">
        店舗情報
    </x-nav-link>
</div>

<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('owner.shops.index')" :active="request()->routeIs('owner.shops.index')">
            店舗情報
        </x-responsive-nav-link>
    </div>
```

resources/views/owner/shops/index.blade.php  
```php
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                @foreach ($shops as $shop )
                {{ $shop->name }}
                @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

```
<br>

# 80. Shop画像アップロード

### 画像アップロードしたい
バリデーション->後ほど  
画像サイズ(今回は1920px x 1080px (FulHD))  
比率は 16:9  
->ユーザ側でリサイズしてもらう  
->サーバー側でリサイズする  
-> Intervention Imageを使う  
同じファイルは重複しないファイル名に変更して保存  

app/Http/Controllers/Owner/ShopController.php
```php
use Illuminate\Support\Facades\Storage;

public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        // dd(Shop::findOrFail($id));
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid() ){
            Storage::putFile('public/shops', $imageFile);
        }

        return redirect()->route('owner.shops.index');
    }
```

resources/views/owner/shops/edit.blade.php
```php
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          オーナー登録
      </h2>
  </x-slot>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <section class="text-gray-600 body-font relative">
                  <div class="container px-5 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">オーナー登録</h1>
                    </div>
                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <form method="post" action="{{ route('admin.owners.store')}}">
                            @csrf
                            <div class="-m-2">
                                <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">オーナー名</label>
                                    <input type="text" id="name" name="name" value="{{ old('name')}}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                </div>
                                <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                    <input type="email" id="email" name="email" value="{{ old('email')}}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                </div>
                                <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                                    <input type="password" id="password" name="password" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                </div>
                                <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード確認</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                                </div>
                                <div class="p-2 w-full flex justify-around mt-4">
                                    <button type="button" onclick="location.href='{{ route('admin.owners.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                    <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button> 
                                </div>                       
                            </div>
                        </form>
                    </div>
                  </div>
                </section>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
```