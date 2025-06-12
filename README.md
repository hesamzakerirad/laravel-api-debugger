![Api Debugger Cover](https://raw.githubusercontent.com/hesamzakerirad/laravel-api-debugger/master/media/Cover.PNG "Api Debugger Cover")

# Laravel Api Debugger

Laravel API Debuuger is a minimal package to help you debug your JSON API.

## How to install?

Take these steps to install Laravel API Debugger.

### Step #1

Install the package using Composer.

```php
composer require hesamrad/laravel-api-debugger --dev
```

### Step #2

Add the middleware to the routes you want to debug.

```php
Route::get('users', function () {
    return response()->json([
        'users' => User::get()
    ]);
})->middleware('debugger'); // <- I added the middleware to a single route for testing.
```

For every request that goes through the specified middleware, you will have additional information to help with your debugging process.

### Note 
1- You need to set `APP_DEBUG` key to `true` inside your `.env` file in order to enable debugger.

2- Since this debugger works with JSON APIs, you will need to send `Accept` request header with the value of `application/json`.

### Example

To demonstrate, I requested `/users` and provided the results shown below.

```json
{
  "data": [
    {
      "id": 1,
      "name": "Demo User Number 1",
      "email": "user-1@test.com"
    },
    {
      "id": 2,
      "name": "Demo User Number 2",
      "email": "user-2@test.com"
    }
  ],
  "debugger": {
    "server": {
      "web_server": "nginx/1.27.5",
      "protocol": "HTTP/1.1",
      "remote_address": "192.168.73.1",
      "remote_port": "52697",
      "server_name": "test.local",
      "server_port": "80"
    },
    "app": {
      "environment": "local",
      "laravel_version": "12.18.0",
      "php_version": "8.3.22",
      "locale": "en"
    },
    "request": {
      "ip": "192.168.65.1",
      "uri": "/api",
      "method": "GET",
      "body": [],
      "headers": {
        "connection": [
          "keep-alive"
        ],
        "accept-encoding": [
          "gzip, deflate, br"
        ],
        "host": [
          "test.local"
        ],
        "cache-control": [
          "no-cache"
        ],
        "user-agent": [
          "PostmanRuntime/7.44.0"
        ],
        "accept": [
          "application/json"
        ]
      }
    },
    "session": {
      "authenticated": false,
      "token": null
    },
    "queries": {
      "count": 1,
      "data": [
        {
          "query": "select * from \"users\"",
          "bindings": [],
          "time": 1.17
        }
      ]
    }
  }
}
```

I hope this package helps you with debugging your JSON APIs as it has helped me many times now.

Be sure to open an issue if you encounter anything out of the ordinary.

Feel free to add ideas to the package to improve its functionality for others.
