<?php

namespace App\Services;

use Image;

class ImageStorageService
{
    public function storeAvatar($image)
    {
        $imageName = md5($image->getClientOriginalName() . microtime()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->fit(300, 300, function ($constraint) {
            $constraint->upsize();
        })->save(storage_path('app/public/avatars/') . $imageName);

        return $imageName;
    }
}
