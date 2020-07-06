<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryFormRequest;
use App\Http\Resources\GenreResource;
use App\Http\Resources\HomeColectionResource;
use App\Http\Resources\PartResource;
use App\Http\Resources\PopularResource;
use App\Http\Resources\StoryGenreResource;
use App\Http\Resources\StoryResource;
use App\Models\Genre;
use App\Models\Library;
use App\Models\Part;
use App\Models\Story;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        $popular_data = Story::withCount('libraries')->orderBy('libraries_count', 'DESC')->limit(7)->get(['id', 'cover']);
        $data[] = [
            'id' => Uuid::uuid4()->toString(),
            'title' => 'Popular',
            'horizontal' => false,
            'order' => 1,
            'data' => PopularResource::collection($popular_data)
        ];
        foreach ($this->user->genres()->get() as $key => $genre) {
            $data[] = [
                'id' => $genre->id,
                'title' => $genre->name,
                'horizontal' => $key % 2 == 0 ? true : false,
                'order' => $key + 2,
                'data' => StoryGenreResource::collection($genre->stories()->inRandomOrder()->limit(10)->get())
            ];
        }


        return HomeColectionResource::collection($data);
    }

    /**
     * Display a listing of the resource.
     * @param uuid $id = genre_id
     * @return \Illuminate\Http\Response
     */

    public function getStoryByGenre($id)
    {
        $genre = Genre::with('stories')->find($id);

        return StoryGenreResource::collection($genre->stories()->get());
    }

    /**
     * Display a listing of the resource.
     * @param uuid $id
     * @return \Illuminate\Http\Response
     */

    public function getPopularStory()
    {
        $popular_data = Story::withCount('libraries')->orderBy('libraries_count', 'DESC')->limit(20)->get();

        return StoryGenreResource::collection($popular_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoryFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryFormRequest $request)
    {
        $cover = 'story/cover/default.png';
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store(
                'story/cover',
                'public'
            );
        }
        $story = $this->user->stories()->create([
            'title' => $request->title,
            'description' => $request->description,
            'language' => $request->language,
            'price' => $request->price,
            'genre_id' => $request->genre_id,
            'cover' => $cover,
            'licence_id' => $request->licence_id,
        ]);

        $story->libraries()->create([
            'access_type' => 'FULL',
            'user_id' => $this->user->id,
            'expired_at' => null
        ]);

        foreach (explode(',', $request->tags) as $value) {
            $story->tags()->create(['name' => $value]);
        }

        return response()->json([
            'message' => 'Successfuly created new story',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $story = Story::find($id);

        return new StoryResource($story);
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        $library = Library::where([
            'status' => 'ACTIVE',
            'user_id' => $this->user->id,
            'story_id' => $id
        ])->first();

        if ($library) {
            if ($library->access_type == 'RENT') {
                $date = Carbon::now();
                if (!$library->read_on) {
                    $date_expired = $library->expired_at;
                    $sum_date = $date->diffInDays($date_expired);

                    $new_date_expired = $date_expired;
                    if ($sum_date > 2) {
                        $new_date_expired = $date->addDay(2);
                    }

                    $library->update(['read_on' => Carbon::now(), 'expired_at' => $new_date_expired]);
                }
            }

            $part = Part::where('story_id', $id)->get();

            return PartResource::collection($part);
        }

        return response()->json([
            'status' => false,
            'message' => 'Please rent or buy first to access this page'
        ], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoryFormRequest $request, $id)
    {
        $story = Story::find($id);
        $cover = $story->cover;

        if ($request->hasFile('cover')) {
            if (!Storage::disk('public')->exists('story/cover/default.png')) {
                if (Storage::disk('public')->exists($story->cover)) {
                    Storage::disk('public')->delete($story->cover);
                }
            }


            $cover = $request->file('cover')->store(
                'story/cover',
                'public'
            );
        }

        $story->update([
            'title' => $request->title,
            'description' => $request->description,
            'language' => $request->language,
            'price' => $request->price,
            'genre_id' => $request->genre_id,
            'cover' => $cover,
            'licence_id' => $request->licence_id,
        ]);

        Tag::where('story_id', $id)->delete();

        foreach (explode(',', $request->tags) as $value) {
            $story->tags()->create(['name' => $value]);
        }

        return response()->json([
            'message' => 'Successfuly updated this story',
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
        $story = Story::find($id);
        if (!Storage::disk('public')->exists('story/cover/default.png')) {
            if (Storage::disk('public')->exists($story->cover)) {
                Storage::disk('public')->delete($story->cover);
            }
        }

        $story->delete();

        return response()->json([
            'message' => 'Successfuly deleted this story',
            'data' => null
        ]);
    }
}
