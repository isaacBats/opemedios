<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->only('email', 'password');
        if($request->user()->isExecutive()){
            return redirect()->route('front.manageraccess', compact('credentials'));
        }
        
        return $next($request);
    }
}
