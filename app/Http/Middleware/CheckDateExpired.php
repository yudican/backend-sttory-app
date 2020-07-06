<?php

namespace App\Http\Middleware;

use App\Models\Library;
use Carbon\Carbon;
use Closure;

class CheckDateExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $libraries = Library::where(['access_type' => 'RENT', 'status' => 'ACTIVE'])->get(['id', 'expired_at']);
        $current_date = Carbon::now();
        foreach ($libraries as $library) {
            if ($current_date->greaterThanOrEqualTo($library->expired_at)) {
                Library::find($library->id)->update([
                    'status' => 'EXPIRED',
                ]);
            }
        }
        return $next($request);
    }
}
