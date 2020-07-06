<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartFormRequest;
use App\Http\Resources\PartResource;
use App\Models\Part;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PartFormRequest  $request
     * @param uuid $id
     * @return \Illuminate\Http\Response
     */
    public function store(PartFormRequest $request, $id)
    {
        $story = Story::find($id);

        $cover = 'story/part/cover/default.png';
        if ($request->hasFile('part_cover')) {
            $cover = $request->file('part_cover')->store(
                'story/part/cover',
                'public'
            );
        }

        $story->parts()->create([
            'part_cover' => $cover,
            'part_title' => $request->part_title,
            'part_description' => $request->part_description,
        ]);

        return response()->json([
            'message' => 'Successfuly added new part',
            'data' => $story
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
        $part = Part::where('story_id', $id)->limit(5)->get();

        return PartResource::collection($part);
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
        $part = Part::find($id);

        $cover = $part->part_cover;
        if ($request->hasFile('part_cover')) {
            if (!Storage::disk('public')->exists('story/part/cover/default.png')) {
                if (Storage::disk('public')->exists($part->part_cover)) {
                    Storage::disk('public')->delete($part->part_cover);
                }
            }
            $cover = $request->file('part_cover')->store(
                'story/part/cover',
                'public'
            );
        }

        $part->update([
            'part_cover' => $cover,
            'part_title' => $request->part_title,
            'part_description' => $request->part_description,
        ]);

        return response()->json([
            'message' => 'Successfuly updated this part',
            'data' => $part
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $part = Part::find($id);

        if (!Storage::disk('public')->exists('story/part/cover/default.png')) {
            if (Storage::disk('public')->exists($part->part_cover)) {
                Storage::disk('public')->delete($part->part_cover);
            }
        }

        $part->delete();

        return response()->json([
            'message' => 'Successfuly deleted this part',
            'data' => null
        ]);
    }
}
