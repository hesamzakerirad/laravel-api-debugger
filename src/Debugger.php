<?php 

namespace HesamRad\Debugger;

use Illuminate\Http\Request;

class Debugger
{
    /**
     * Creates a new Debugger object.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
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
        return $this->config('enabled') == true;
    }

    /**
     * Debug the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function debug(Request $request)
    {
        if (! $this->enabled()) {
            return;
        }

        return [
            'debugger' => [
                'app' => [
                    'environment' => app()->environment(),
                    'laravel_version' => app()->version(),
                    'php_version' => phpversion(),
                ],
                'request' => [
                    'path' => $request->getPathInfo(),
                    'ip' => $request->ip(),
                    'authenticated' => auth()->check(),
                ]
            ]
        ];
    }
}