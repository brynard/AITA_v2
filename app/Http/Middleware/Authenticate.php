<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $response = parent::handle($request, $next, $guards);

        if ($request->session()->has('last_activity')) {
            $lastActivity = $request->session()->get('last_activity');
            $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $lastActivity)->addMinutes(config('session.lifetime'));

            if (Carbon::now()->gt($expiresAt)) {
                $request->session()->flush();
                return redirect('/login')->with('session_expired', 'Your session has expired. Please log in again.');
            }
        }

        $request->session()->put('last_activity', Carbon::now()->format('Y-m-d H:i:s'));

        return $response;
    }
}
