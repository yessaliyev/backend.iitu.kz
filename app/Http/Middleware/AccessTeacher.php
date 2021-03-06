<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AccessTeacher
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
        if (Auth::user()->hasRole('teacher')) return $next($request);
        return response(['msg' => 'u are not allowed']);
    }
}
