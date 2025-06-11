<?php

namespace HesamRad\Debugger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Debugger
{
    /**
     * Checks if Debugger is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return config('app.debug') === true;
    }

    /**
     * Start the process of debugging.
     *
     * @return void
     */
    public function debug()
    {
        if (! $this->isEnabled()) {
            return;
        }

        DB::enableQueryLog();
    }

    /**
     * Report everything there is about the current request.
     *
     * @return array
     */
    public function report()
    {
        $request = request();

        return [
            'debugger' => [
                'server' => $this->getServerInformation(),
                'app' => $this->getApplicationInformation(),
                'request' => $this->getRequestInformation($request),
                'session' => $this->getSessionInformation($request),
                'queries' => $this->getQueriesInformation(),
            ]
        ];
    }

    /**
     * Get information about the server on which
     * the application is being served.
     *
     * @return array
     */
    protected function getServerInformation()
    {
        return [
            'web_server' => $_SERVER['SERVER_SOFTWARE'],
            'protocol' => $_SERVER['SERVER_PROTOCOL'],
            'remote_address' => $_SERVER['REMOTE_ADDR'],
            'remote_port' => $_SERVER['REMOTE_PORT'],
            'server_name' => $_SERVER['SERVER_NAME'],
            'server_port' => $_SERVER['SERVER_PORT'],
        ];
    }

    /**
     * Get information about the application itself.
     *
     * @return array
     */
    protected function getApplicationInformation()
    {
        return [
            'environment' => app()->environment(),
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'locale' => app()->getLocale(),
        ];
    }

    /**
     * Get information about the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getRequestInformation(Request $request)
    {
        return [
            'ip' => $request->ip(),
            'uri' => $request->getPathInfo(),
            'method' => $request->method(),
            'body' => $request->all(),
            'headers' => $request->header(),
        ];
    }

    /**
     * Get session information from the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getSessionInformation(Request $request)
    {
        return [
            'authenticated' => auth()->check(),
            'token' => $request->bearerToken(),
        ];
    }

    /**
     * Get executed query information.
     *
     * @return array
     */
    protected function getQueriesInformation()
    {
        $queries = DB::getQueryLog();

        return [
            'count' => count($queries),
            'data' => $queries
        ];
    }
}
