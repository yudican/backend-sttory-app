<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = $this->user->with(['profile', 'wallets'])->first();

        return new UserProfileResource($profile, $this->getBalance());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'image',
            'phone' => 'required|numeric'
        ]);
        $avatar = 'users/avatar/default.png';
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store(
                'users/avatar',
                'public'
            );
        }

        $this->user->profile()->updateOrCreate([
            'user_id' => $this->user->id
        ], [
            'avatar' => $avatar,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Successfuly added profile',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);
        $avatar = $profile->avatar;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store(
                'users/avatar',
                'public'
            );
        }

        $profile->user()->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        $profile->update([
            'avatar' => $avatar,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Successfuly updated profile',
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = $this->user;
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'message' => 'successfuly updated password'
            ]);
        }

        return response()->json([
            'message' => 'Invalid old password'
        ]);
    }
}
