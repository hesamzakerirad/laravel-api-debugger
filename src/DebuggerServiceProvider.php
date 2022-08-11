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

        //registering a custom macro
        Request::macro('listen', function () {
            return app(Debugger::class)->listen();
        });

        //registering a custom macro
        Request::macro('isBeingDebugged', function () {
            return app(Debugger::class)->isBeingDebugged();
        });
    }
}
