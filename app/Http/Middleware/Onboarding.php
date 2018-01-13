<?php

namespace App\Http\Middleware;

use Closure;

class Onboarding
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
        if($request->user()->profile->total_login <= 0)
        {
            return redirect("intro/profile-setup");
        }
        return $next($request);
    }
}
