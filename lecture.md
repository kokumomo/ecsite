# 89. Image Create
![img](public/images/owner_er.png)

### 画像複数アップロードとバリデーション

Shops/edit.blade.phpを参考  
画像の複数アップロード対応  
<input type=“file” name=“files[][image]” multiple 略>  
フォームリクエストのrulesに下記を追加  
App/Http/Requests/UploadImageRequest.php  
'files.*.image' => 'required|image|mimes:jpg,jpeg,png|max:2048',  

resources/views/owner/images/create.blade.php  
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
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                <form method="post" action="{{ route('owner.images.store', )}}" enctype="multipart/form-data">
                    @csrf
                    <div class="-m-2">
                      
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                            <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                            <input type="file" id="image" name="files[][image]" multiple accept=“image/png,image/jpeg,image/jpg” class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>
                        
                        <div class="p-2 w-full flex justify-around mt-4">
                        <button type="button" onclick="location.href='{{ route('owner.images.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                        <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>        
                    </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
```
app/Http/Controllers/Owner/ImageController.php
```php
use App\Http\Requests\UploadImageRequest;

 public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request)
    {
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
