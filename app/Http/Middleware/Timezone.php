<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Timezone
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
        $timezone = config('app.timezone');

        if (session()->has('system_details.time_zone')) {
            $timezone = $request->session()->get('system_details.time_zone');
        } else {
            $timezone = Auth::user()->system_details->time_zone;
        }

        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);

        return $next($request);
    }
}
