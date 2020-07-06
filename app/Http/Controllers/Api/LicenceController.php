<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenceResource;
use App\Models\Licence;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    public function index()
    {
        $licences = Licence::all();

        return LicenceResource::collection($licences);
    }
}
