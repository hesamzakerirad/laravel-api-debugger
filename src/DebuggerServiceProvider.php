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
        /**
         * Binding Debugger as a singleton.
         *
         */
        $this->app->singleton(Debugger::class, function () {
            return new Debugger();
        });

        /**
         * Registering the middleware with
         * the application.
         * 
         */
        app('router')->aliasMiddleware('debugger', \HesamRad\Debugger\Middleware\DebuggerMiddleware::class);
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
            return app(Debugger::class)->debug();
        });

        //registering a custom macro
        Request::macro('isBeingDebugged', function () {
            return app(Debugger::class)->isBeingDebugged();
        });

        //registering a custom macro
        Request::macro('report', function () {
            return app(Debugger::class)->report($this);
        });
    }
}
