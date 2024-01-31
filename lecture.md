# 81. Intervention Image
![img](public/images/owner_er.png)

### 目的：　画像リサイズしたい

PHP 画像ライブラリ  
http://image.intervention.io/  
(もし無効になっていたら有効化する php.ini)  
FileInfo Extension  
GD 画像ライブラリ  
バージョン2.7指定  
composer require intervention/image:2.7.*  


config/app.php
```php
$providers = [
Intervention\Image\ImageServiceProvider:class
];


// Imageだとバッティングするので変更
$alias = [
'InterventionImage' => Intervention\Image\Facades\Image:class
];
```
$request->image; でname属性を指定して画像ファイルを取得  
isValid() でアップロードができたか判定  

Storage:putFile はFileオブジェクト想定  
InterventionImageでリサイズすると画像
(型が変わる)  
今回は Storage:put で保存  
(フォルダは自動作成するが、ファイル名は自分で作成、指定)  
uniqid(rand().’_’); で一意のidをランダムに作成  
extension(); 拡張子をつけるメソッド  
$fileName. ‘.’ . $extension; でファイル名と拡張子を繋げる  
encode()とすると画像として扱いが可  

Storage::put(); で自動的にファイル名をつけてくれるメソッド  
第１引数で保存したいフォルダ名、第２引数は保存したいファイル名  

app/Http/Controllers/Owner/ShopController.php  
```php
public function update(UploadImageRequest $request, $id)
    {
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid() ){
            // Storage::putFile('public/shops', $imageFile); リサイズ無しの場合
            $fileName = uniqid(rand().'_');
            $extension = $imageFile->extension();
            $fileNameToStore = $fileName. '.' . $extension;
            $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
            // dd($imageFile, $resizedImage);

            Storage::put('public/shops/' . $fileNameToStore, $resizedImage );
                }

        return redirect()->route('owner.shops.index');
    }
```

