<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Story;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param uuid $id = story_id
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request, $id)
    {
        $story = Story::find($id);
        if ($story->price == 0) {
            $story->libraries()->create([
                'access_type' => $request->access_type,
                'user_id' => $this->user->id,
                'expired_at' => null
            ]);

            return response()->json([
                'message' => 'Story was added to library'
            ]);
        }
        $price = $request->access_type == 'RENT' ? $story->price * 0.25 : $story->price;
        if ($this->getBalance() < $price) {
            return response()->json([
                'message' => 'insufficient balance'
            ]);
        } else {
            $story->libraries()->create([
                'access_type' => $request->access_type,
                'user_id' => $request->user_id,
                'expired_at' => $request->access_type == 'RENT' ? Carbon::now()->add(30, 'day') : null
            ]);

            Wallet::create([
                'title' => "$request->access_type Story $story->title",
                'balance' => $request->access_type == 'RENT' ? -$story->price * 0.25 : -$story->price,
                'type' => 'out',
                'user_id' => $request->user_id,
            ]);

            $this->user->wallets()->create([
                'title' => $this->user->fullname . ' Was ' . $request->access_type . ' Your Story',
                'balance' => $request->access_type == 'RENT' ? $story->price * 0.25 : $story->price,
                'type' => 'in',
            ]);

            return response()->json([
                'message' => 'Succesfully checkout coins'
            ]);
        }
    }
}
