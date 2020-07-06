<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Succesfully get the balance',
            'balance' => $this->getBalance(),
            'format_balance' => number_format($this->getBalance())
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function topUp(Request $request)
    {
        Wallet::create([
            'title' => $request->title,
            'type' => 'in',
            'balance' => $request->balance,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Succesfully add coins'
        ]);
    }
}
