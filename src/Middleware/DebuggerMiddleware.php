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
        $debuggingData = [];

        /**
         * Checking to see if application 
         * is on debug mode.
         * 
         */
        $appIsOnDebugMode = env('app_debug') ?? false;

        /**
         * If on debugging mode, the debugger will
         * start to look into the request.
         * 
         */
        if ($appIsOnDebugMode) {
            $debuggingData = $request->debug();
        }

        /**
         * To keep the system running, I will 
         * hand over the request further into
         * the application.
         * 
         */
        $response = $next($request);


        if ($appIsOnDebugMode && (! is_null($debuggingData))) {
            $responseData = json_decode($response->getContent(), true);
            $responseData = array_merge($responseData, $debuggingData);
            $response->setContent(json_encode($responseData));
        }

        return $response;
    }
}