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
        app('router')->aliasMiddleware('debugger', \HesamRad\Debugger\Middleware\DebuggerMiddleware::class);

        //binding Debugger as a singleton
        $this->app->singleton(Debugger::class, function () {
            return new Debugger(config('debugger'));
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
            return app(Debugger::class)->debug($this);
        });
    }
}