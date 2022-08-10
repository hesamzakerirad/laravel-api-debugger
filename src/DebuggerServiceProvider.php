<?php

namespace HesamRad\Debugger;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class DebuggerServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //publish config file
        $this->publishes([
            __DIR__ . '/../config/debugger.php' => config_path('debugger.php')
        ], 'debugger-config');

        //register middleware
        app('router')->aliasMiddleware('debugger', config('debugger.middleware_class'));

        //binding Debugger as a singleton
        $this->app->singleton(config('debugger.debugger_class'), function () {
            return new (config('debugger.debugger_class'))(config('debugger'));
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        //registering a custom macro
        Request::macro('debug', function () {
            return app(config('debugger.debugger_class'))->debug($this);
        });
    }
}