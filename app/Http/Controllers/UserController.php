<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Traits\HasImage;

class UserController extends Controller
{
    use HasImage;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::filter(request(['name', 'role']))->paginate(10);

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['avatar'] = $this->uploadImage($request, null, 'avatar', 'users');

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => new UserResource($user)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $validated['avatar'] = $this->uploadImage($request, $user, 'avatar', 'users', true);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
