<?php

namespace App\Traits\Eloquent;

use Illuminate\Support\Facades\Storage;

trait Uploadable
{
    public function upload($file, $storage = 'public', $folder = 'uploads')
    {
        $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $path = Storage::disk($storage)->putFileAs($folder, $file, $filename);

        if (Storage::disk($storage)->exists($path)) {
            return $path;
        }

        return null;
    }
}
