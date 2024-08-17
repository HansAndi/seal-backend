<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Traits\HasImage;

class ProfileController extends Controller
{
    use HasImage;

    public function edit(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();

        $validated = $request->validated();

        $validated['avatar'] = $this->uploadImage($request, 'avatar', 'avatars', true);

        $user->update($validated);

        return new UserResource($user);
    }
}
