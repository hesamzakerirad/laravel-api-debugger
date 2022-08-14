<?php

namespace HesamRad\Debugger\Middleware;

use Closure;
use Illuminate\Http\Request;

class DebuggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $request->debug();

        $response = $next($request);

        if (! $request->wantsJson()) {
            return $response;
        }

        if (! $request->isBeingDebugged()) {
            return $response;
        }

        $responseData = json_decode($response->getContent(), true);
        $responseData = array_merge($responseData, $request->report());
        $response->setContent(json_encode($responseData));

        return $response;
    }
}
