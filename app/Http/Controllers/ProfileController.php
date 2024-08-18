<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Traits\HasImage;

class ProfileController extends Controller
{
    use HasImage;

    public function edit(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $this->uploadImage($request, $user->avatar, 'avatar', 'users', true);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => new UserResource($user),
        ]);
    }
}
