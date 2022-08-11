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
        $request->listen();

        $response = $next($request);

        if ($request->isBeingDebugged()) {
            $debuggingData = $request->debug();
            $responseData = json_decode($response->getContent(), true);
            $responseData = array_merge($responseData, $debuggingData);
            $response->setContent(json_encode($responseData));
        }

        return $response;
    }
}
