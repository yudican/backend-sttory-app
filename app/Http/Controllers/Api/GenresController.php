<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    public function index()
    {
        $genre = Genre::all();
        return GenreResource::collection($genre);
    }
}
