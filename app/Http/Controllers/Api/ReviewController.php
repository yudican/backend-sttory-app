<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Story;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param uuid $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $review = Review::with(['user'])->where('story_id', $id)->paginate(10);

        return ReviewResource::collection($review);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param uuid $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $story = Story::find($id);

        $story->reviews()->create([
            'description' => $request->description,
            'star' => $request->star,
            'user_id' => $this->user->id,
        ]);

        return response()->json([
            'message' => 'Successfully write this review',
        ], 201);
    }
}
