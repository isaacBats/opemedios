<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Http\Request;

class VerifyFastApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = config('app.fast_api_key');

        $apiKeyIsValid = (
            filled($apiKey)
            && $request->header('x-api-key') === $apiKey
        );

        abort_if (! $apiKeyIsValid, 403, 'Access denied');

        return $next($request);
    }
}