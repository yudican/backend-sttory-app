<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function getBalance()
    {
        $balance = $this->user->wallets()->sum('balance');
        return $balance;
    }
}
