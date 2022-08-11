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
                'app' => [
                    'environment' => app()->environment(),
                    'laravel_version' => app()->version(),
                    'php_version' => phpversion(),
                    'locale' => app()->getLocale(),
                ],
                'request' => [
                    'ip' => $request->ip(),
                    'route' => $request->getPathInfo(),
                    'method' => $request->method(),
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
