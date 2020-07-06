<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistration;
use App\Http\Resources\User\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UserRegistration  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegistration $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);

        // $token = $user->createToken($user->fullname)->accessToken;
        return response()->json([
            'status' => true,
            'message' => 'Registrasi Berhasil',
            // 'token' => $token
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
