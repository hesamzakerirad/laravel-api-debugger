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
     * Start listening to an incoming request.
     *
     * @return void
     */
    public function listen()
    {
        return ! $this->enabled() ?: DB::enableQueryLog();
    }

    /**
     * Debug the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function debug(Request $request)
    {
        $queries = DB::getQueryLog();

        return [
            'debugger' => [
                'server' => [
                    'web_server' => $_SERVER['SERVER_SOFTWARE'],
                    'protocol' => $_SERVER['SERVER_PROTOCOL'],
                    'remote_address' => $_SERVER['REMOTE_ADDR'],
                    'remote_port' => $_SERVER['REMOTE_PORT'],
                    'server_name' => $_SERVER['SERVER_NAME'],
                    'server_port' => $_SERVER['SERVER_PORT'],
                ],
                'app' => [
                    'environment' => app()->environment(),
                    'laravel_version' => app()->version(),
                    'php_version' => phpversion(),
                    'locale' => app()->getLocale(),
                ],
                'request' => [
                    'ip' => $request->ip(),
                    'uri' => $request->getPathInfo(),
                    'method' => $request->method(),
                    'body' => $request->all(),
                    'headers' => $request->header()
                ],
                'session' => [
                    'authenticated' => auth()->check(),
                    'token' => $request->bearerToken(),
                ],
                'queries' => [
                    'count' => count($queries),
                    'data' => $queries
                ]
            ]
        ];
    }
}
