<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfClientRole
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
         if (Auth::user()->hasRole('client')) {
            $company = Auth::user()->company();
            return redirect("{$company->slug}/noticias");
        }

        return $next($request);
    }
}
