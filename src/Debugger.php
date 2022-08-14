<?php

namespace HesamRad\Debugger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Debugger
{
    /**
     * Creates a new Debugger object.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Returns Debugger configuration/s.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function config(string $key = null)
    {
        return isset($key) ? $this->config[$key] : $this->config;
    }

    /**
     * Modifies Debugger configurations.
     *
     * @param  array $config
     * @return void
     */
    public function setConfig($config = [])
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    /**
     * Checks to see if Debugger is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return env('app_debug') == true;
    }

    /**
     * Check to see if debugger is working
     * on a request.
     *
     * @return bool
     */
    public function isBeingDebugged()
    {
        return $this->enabled();
    }

    /**
     * Start the process of debugging.
     *
     * @return void
     */
    public function debug()
    {
        return ! $this->enabled() ?: DB::enableQueryLog();
    }

    /**
     * Report everything there is about 
     * the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function report(Request $request)
    {
        return [
            'debugger' => [
                'server' => $this->getServerInformation(),
                'app' => $this->getApplicationInformation(),
                'request' => $this->getRequestInformation($request),
                'session' => $this->getSessionInformation($request),
                'queries' => $this->getQueriesInformation()
            ]
        ];
    }

    /**
     * Get some information about the 
     * server which the application is 
     * run on.
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
     * Get some information about the 
     * application itself.
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
     * Get some information about the 
     * given request.
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
            'headers' => $request->header()
        ];
    }

    /**
     * Get some information about the 
     * session information from the 
     * given request.
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
     * Get some information about the 
     * executed queries.
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
