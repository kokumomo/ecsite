# 85. Shop Editの残り
![img](public/images/owner_er.png)

### 目的1：　Edit画面の作成

コンポーネントで切り分け  
resources/views/components/thumbnail.blade.php  
```php
<div>
    @if(empty($filename))
    <img src="{{ asset('images/no_image.jpg')}}">
    @else
    <img src="{{ asset('storage/shops/' . $filename)}}">
    @endif
</div>
```

resources/views/owner/shops/edit.blade.php  
```php
店名 <input type=“text”>{{ $shop->name}}
店舗情報 <textarea rows=“10”>{{ $shop->information}}</textarea>
画像のサムネイル
<div class=“w-32”>
  <x-shop-thumbnail />
</div>
販売中/停止中
<input type=“radio” name=“is_seling” value=“1” @if($shop->is_seling = true){ checked } @endif>販売中
<input type=“radio” name=“is_seling” value=“0” @if($shop->is_seling = false){ checked } @endif>停止中
```

<br>

# 86. Shop Updateの残り

### Uploadしたい

app/Http/Controllers/Owner/ShopController.php
```php
public function update(UploadImageRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);

        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid() ){
            
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
            }

            $shop = Shop::findOrFail($id);
            $shop->name = $request->name;
            $shop->information = $request->information;
            $shop->is_selling = $request->is_selling;
            if(!is_null($imageFile) && $imageFile->isValid()){
                $shop->filename = $fileNameToStore;
            }

            $shop->save();

            return redirect()
            ->route('owner.shops.index')
            ->with(['message' => '店舗情報を更新しました。',　// フラッシュメッセージ
            'status' => 'info']);
    }
```

resources/views/owner/shops/index.blade.php
```php
use App\Services\ImageService;

public function update(UploadImageRequest $request, $id)
    {
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid() ){
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
            }

        return redirect()->route('owner.shops.index');
    }
```