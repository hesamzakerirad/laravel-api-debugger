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
Add it to the routes you want to debug.

```php
Route::middleware('debugger')->group(function () {
    Route::get('users/{email}', [UserController::class, 'show']);
});
```
And you're done! Told you it was easy :)

Now every route that goes through `DebuggerMiddleware` will be investigated and reported back to you.

### Let's see an example

After setting `APP_DEBUG` key to `true` and requesting a route with debugger middleware on top of it, you'll be presented with this response.

```json
{
    "data": {
		"id": 1,
		"name": "Demo User",
		"email": "user@test.com",
	},
    "debugger": {
        "app": {
            "environment": "local",
            "laravel_version": "8.83.18",
            "php_version": "8.0.13",
            "locale": "fa"
        },
        "request": {
			"ip": "127.0.0.1",
			"uri": "/users/user@test.com",
			"method": "GET",
			"body": {
				"test": "test"
			},
			"headers": {
				"accept": [
					"application/json"
				],
				"user-agent": [
					"PostmanRuntime/7.29.2"
				],
				"cache-control": [
					"no-cache"
				],
				"postman-token": [
					"33ba20a5-db9a-4035-a593-4f32774e0854"
				],
				"host": [
					"localhost:8000"
				],
				"accept-encoding": [
					"gzip, deflate, br"
				],
				"connection": [
					"keep-alive"
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
                    "query": "select * from `users` where `email` = ? limit 1",
                    "bindings": [
                        "user@test.com"
                    ],
                    "time": 0.83
                }
            ]
        }
    }
}
```

I hope this package helps you with debugging your JSON APIs as it has helped me many times now.

Be sure to open an issue if you encounter anything out of the ordinary.

Feel free to add ideas to the package to improve its functionality.

