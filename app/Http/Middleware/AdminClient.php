<?php

namespace App\Http\Middleware;

use Closure;

class AdminClient
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
        if($request->user()->isExecutive())
            return redirect()->route('front.manageraccess', compact('request'));
        
        return $next($request);
    }
}
