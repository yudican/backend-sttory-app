<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UserLogin  $request
     * @return \Illuminate\Http\Response
     */
    public function login(UserLogin $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken($user->fullname)->accessToken;

            return response()->json([
                'message' => 'Login Succesfully',
                'data' => [
                    'token' => $token,
                    // 'uid' => $user->id
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid Email Or Password',
            'data' => [
                'token' => null
            ]
        ], 401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        request()->user()->token()->revoke();
        return response()->json([
            'status' => true,
            'message' => 'You\'re Loged Out',
        ], 200);
    }
}
