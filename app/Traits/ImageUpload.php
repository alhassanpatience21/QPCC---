<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ImageUpload
{
    public function upload($image, $path)
    {
        if ($image) {
            $extention = $image->getClientOriginalExtension();

            $fileNameToStore = $path . '/' . Str::random(15) . '.' . $extention;

            $image->move(public_path() . '/' . $path, $fileNameToStore);

            return $fileNameToStore;
        }
        return '';
    }
}
