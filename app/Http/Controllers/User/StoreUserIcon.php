<?php


namespace App\Http\Controllers\User;


use Exception;
use Faker\Provider\Uuid;
use Intervention\Image\Facades\Image;

class StoreUserIcon
{
    public static function storeIcon($src_icon)
    {
        $width = 512;
        $height = 512;

        //jpeg以外も行けるようにする
        $image = Image::make($src_icon)
            ->encode('jpg')
            ->fit($width, $height);

        if ($image->width() < $width) throw new Exception('WidthSizeMismatchedError');
        if ($image->height() < $height) throw new Exception('HeightSizeMismatchedError');

        $image_path = 'storage/' . Uuid::uuid() . '.' . 'jpg';

        $image->save($image_path);

        return $image_path;
    }
}
