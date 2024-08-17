<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage($request, $path = null, $field, $folder, $update = false)
    {
        $image = null;

        if ($update) {
            if (!empty($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        
        $image = $request->file($field)->store($folder, 'public');

        return $image;
    }
}