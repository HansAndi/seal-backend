<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage($request, $field, $folder, $update = false)
    {
        $image = null;

        if ($request->hasFile($field)) {
            if ($update) {
                if (Storage::disk('public')->exists($request->$field)) {
                    Storage::disk('public')->delete($request->$field);
                }
            }
            $image = $request->file($field)->store($folder, 'public');
        }

        return $image;
    }
}