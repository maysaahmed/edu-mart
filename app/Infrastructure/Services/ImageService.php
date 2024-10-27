<?php

namespace App\Infrastructure\Services;
use  App\Core\Interfaces\Services\IImageService;
use Image;
use File;

class ImageService implements IImageService
{
    public function uploadImage($img, $path, $x, $y): string
    {

        $filename = str_random(12) . '_' . time() . '.' . strtolower($img->getClientOriginalExtension());

        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        Image::make($img)->resize($x, $y)->save($path  . $filename);  //resized

        return $filename;
    }


    public function removeImage($path, $img){

        if(file_exists($path . $img))
            File::delete($path . $img);

    }
}
