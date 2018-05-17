<?php

namespace App\Http\Middleware;

use Closure;

class SetLocalization
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
        app()->setLocale(auth()->check() ? auth()->user()->language : config('app.locale'));
        
        return $next($request);
    }
}
