<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function updateExpired($id)
    {
        $library = Library::find($id);
        $date = Carbon::now();
        if (!$library->read_on) {
            $date_expired = $library->expired_at;

            $sum_date = $date->diffInDays($date_expired);
            return $sum_date;
            $new_date_expired = $date_expired->subDays($sum_date)->addDay(2);
            $library->update(['read_on' => $date, 'expired_at' => $new_date_expired]);

            return true;
        }

        return false;
    }
}
