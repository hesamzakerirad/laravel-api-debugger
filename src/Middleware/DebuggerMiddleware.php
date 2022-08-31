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

        if (! ($request->wantsJson() && $request->isBeingDebugged() && $response->getContent())) {
            return $response;
        }

        $content = array_merge(
            json_decode($response->getContent(), true), 
            $request->report()
        );

        $response->setContent(json_encode($content));

        return $response;
    }
}
