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
        $this->app->singleton(Debugger::class, fn () => new Debugger());

        app('router')->aliasMiddleware(
            'debugger',
            \HesamRad\Debugger\Middleware\DebuggerMiddleware::class
        );
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        Request::macro('debug', function () {
            return app(Debugger::class)->debug();
        });

        Request::macro('isBeingDebugged', function () {
            return app(Debugger::class)->isEnabled();
        });

        Request::macro('report', function () {
            return app(Debugger::class)->report();
        });
    }
}
