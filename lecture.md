# 91. Image Edit, Update
![img](public/images/owner_er.png)

ShopControler@edit, updateを参考に  
shop の箇所は image に変更  
リソースコントローラを使っているので  
updateがputメソッド  
-> @method(‘put’) をつける  

resources/views/owner/images/edit.blade.php
```php
<form method="post" action="{{ route('owner.images.update', ['image' => $image->id ] )}}" >
    @csrf
    @method('put')
    <div class="-m-2">
        <div class="p-2 w-1/2 mx-auto">
            <div class="relative">
            <label for="title" class="leading-7 text-sm text-gray-600">画像タイトル</label>
            <input type="text" id="title" name="title" value="{{$image->title}}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
        </div>
        <div class="p-2 w-1/2 mx-auto">
          <div class="relative">
            <div class="w-32">
              <x-thumbnail :filename="$image->filename" type="products" />
            </div>
          </div>
        </div>
        <div class="p-2 w-full flex justify-around mt-4">
        <button type="button" onclick="location.href='{{ route('owner.images.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
        <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>        
    </div>
  </form>
```


app/Http/Controllers/Owner/ImageController.php
```php
 public function edit(string $id)
    {
        $image = Image::findOrFail($id);
        return view('owner.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'string|max:50'
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像情報を更新しました。',
        'status' => 'info']);
    }
```

app/Http/Requests/UploadImageRequest.php
```php
public function rules()
    {
        return [
            'image'=>'image|mimes:jpeg,png,jpg|max:2048',
            'files.*.image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
```

<br>

# 90. Image Store

ShopControler@updateを参考  
```php
$imageFiles = $request->file(‘files'); //配列でファイルを取得
if(!is_nul($imageFiles)){
foreach($imageFiles as $imageFile){ // それぞれ処理
$fileNameToStore = ImageService:upload($imageFile, 'products');
Image::create([
'owner_id' => Auth::id(),
'filename' => $fileNameToStore
]);
}
}

if(is_array($imageFile)){
$file = $imageFile[‘image']; // 配列なので[‘key’] で取得
} else {
$file = $imageFile;
}
$fileName = uniqid(rand().'_');
$extension = $file->extension();
$fileNameToStore = $fileName. '.' . $extension;
$resizedImage = InterventionImage::make($file)->resize(1920,1080)->encode();
Storage:put('public/' . $folderName . '/' . $fileNameToStore,
$resizedImage );
```

コントローラー  
app/Http/Controllers/Owner/ImageController.php
```php
use App\Services\ImageService;

public function store(UploadImageRequest $request)
    {
        // dd($request);
        $imageFiles = $request->file('files');
        if(!is_null($imageFiles)){
            foreach($imageFiles as $imageFile){
                $fileNameToStore = ImageService::upload($imageFile, 'products');    
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore  
                ]);
            }
        }

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像登録を実施しました。',
        'status' => 'info']);
    }
```

app/Services/imageService.php
```php
if(is_array($imageFile))
    {
      $file = $imageFile['image'];
    } else {
      $file = $imageFile;
    }

    $fileName = uniqid(rand().'_');
    $extension = $file->extension();
    $fileNameToStore = $fileName. '.' . $extension;
    $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();
    Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage );
    
    return $fileNameToStore;
```
<br>

# 92. Image destroy

admin/OwnersControler@destroy と  
admin/owners/index.blade.php を参考に  
テーブル情報を削除する前に  
Storageフォルダ内画像ファイルを削除  
$image = Image:findOrFail($id);  
$filePath = 'public/products/'. $image->filename;  
if(Storage:exists($filePath)){  
Storage:delete($filePath);  
}  
削除・リダイレクトは省略  

app/Http/Controllers/Owner/ImageController.php  
```php
public function destroy(string $id)
    {
        $image = Image::findOrFail($id);
        $filePath = 'public/products/' . $image->filename;

        if(Storage::exists($filePath)){
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete(); 

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像を削除しました。',
        'status' => 'alert']);
    }
```

app/Http/Controllers/Owner/ImageController.php
```php
use Illuminate\Support\Facades\Storage;

public function destroy(string $id)
    {
        $image = Image::findOrFail($id);
        $filePath = 'public/products/' . $image->filename;

        if(Storage::exists($filePath)){
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete(); 

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像を削除しました。',
        'status' => 'alert']);
    }
```

<br>

# 93. Image ダミーデータ

php artisan make:seed ImageSeeder  
画像はリサイズ・リネーム後 storage/productsフォルダに保存  
いくつかのファイル名を書き換えつつダミーとして登録  
sample1.jpg ～ sample6.jpg  
Storage内ファイルはgitにアップすると消えるので  
public/images内に保存しつつ  
README.md に明記しておきます  
