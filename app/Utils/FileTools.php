<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class FileTools
{
    public static function clearTempFiles()
    {
        $storage = Storage::disk('local');

        foreach ($storage->allFiles('livewire-tmp') as $filePathName) {
            $storage->delete($filePathName);
        }
    }

    public static function loadImage(string $path)
    {
        $storage = Storage::disk('local');

        foreach ($storage->allFiles('storage') as $filePathName) {
            if ($filePathName == $path) {
                return $storage->get($filePathName);
            }
        }
    }
}
