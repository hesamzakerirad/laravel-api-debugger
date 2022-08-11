![Api Debugger Cover](https://raw.githubusercontent.com/hesamzakerirad/laravel-api-debugger/master/media/Cover.PNG "Api Debugger Cover")

# Laravel Api Debugger
Laravel-Api-Debuuger is a minimal package to help you debug your json apis. 

It's very easy to setup; let me show you.

## How to install?
Take these steps to install Laravel API Debugger.

### Step #1
Install the package from Composer.

```php
composer require hesamrad/laravel-api-debugger
```

### Step #2
Add the middleware to the `App/Http/Kernel.php` of the applcation.

```php 
protected $middleware = [
    // \App\Http\Middleware\TrustHosts::class,
    \App\Http\Middleware\TrustProxies::class,
    \Illuminate\Http\Middleware\HandleCors::class,
    \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

    // Add Debugger middleware here...
    \HesamRad\Debugger\Middleware\DebuggerMiddleware::class
];
```

### Step #3
Register the same middleware in the same file inside `$routesMiddlewares` array.

```php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

    // Add Debugger middleware here...
    'debugger' => \HesamRad\Debugger\Middleware\DebuggerMiddleware::class
];
```

### Step #4
Add it to the routes you want to debug.

```php
Route::middleware('debugger')->group(function () {
    Route::get('/', [SomeController::class, 'index']);
});
```
And you're done.

Now every route that goes through `DebuggerMiddleware` will be investigated and reported back to you.

### Let's see an example

After setting `APP_DEBUG` key to `true` and requesting a route with debugger middleware on top of it, you'll be presented with this response.

```json
"data": {
    []
},
"debugger": {
    "app": {
        "environment": "local",
        "laravel_version": "8.83.18",
        "php_version": "8.0.13",
        "locale": "en"
    },
    "request": {
        "ip": "127.0.0.1",
        "route": "/",
        "method": "GET",
    },
    "queries": {
        "count": 0,
        "data": null
    }
}
```

I hope this package helps you with debugging your JSON APIs as it has helped me many times now.

Be sure to open an issue if you encounter anything out of the ordinary.

Feel free to add ideas to the package to improve its functionality.

