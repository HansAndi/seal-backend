<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage($request, $model = null, $field, $folder, $update = false)
    {
        $image = null;

        if ($request->hasFile($field)) {
            if ($update) {
                if (!empty($model[$field]) && Storage::disk('public')->exists($model[$field])) {
                    Storage::disk('public')->delete($model[$field]);
                }
            }
            $image = $request->file($field)->store($folder, 'public');
        }

        return $image;
    }
}