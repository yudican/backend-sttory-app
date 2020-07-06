<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function selectGenre(Request $request)
    {
        $this->user->genres()->attach($request->genres);

        return response()->json([
            'message' => 'Successfuly selected favorite genre'
        ]);
    }
}
