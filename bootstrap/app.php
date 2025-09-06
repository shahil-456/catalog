<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',

    using: function () {
        Route::middleware('web')
            ->group(base_path('routes/web.php')); 

        Route::middleware('web')
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));

        Route::middleware('web')
            ->prefix('user')
            ->group(base_path('routes/user.php'));

       Route::middleware('web')
            ->prefix('customer')
            ->group(base_path('routes/customer.php'));     
    },
)





    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
