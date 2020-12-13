<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class requestfromterminal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::debug($request->fullUrl());
        if($request->getContent())
          Log::debug($request->getContent());
        else {
          Log::debug('content not available..');
        }
        return $next($request);
    }
}
