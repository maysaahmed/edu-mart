<?php

namespace App\Core\Interfaces\Services;

interface IImageService
{
    public function uploadImage($img, $path, $x, $y): string;
    public function removeImage($path, $img);
}
