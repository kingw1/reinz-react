<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadFileTrait
{
    private $path = '';

    public function upload($file, $folder = '', $width = null, $height = null)
    {
        $this->setUploadFolder($folder);

        $filename = time() . uniqid(rand()) . '.' . $file->extension();
        $uploadTo = $this->path . '/' . $filename;

        $image = Image::make($file);

        if ($width || $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $image->save($uploadTo);

        return $folder . '/' . $filename;
    }

    private function setUploadFolder($folder)
    {
        $this->path = storage_path('app/public');

        if ($folder) {
            $this->path .= '/' . $folder;

            if (!file_exists($this->path)) {
                Storage::disk('public')->makeDirectory($folder);
            }
        }
    }
}
