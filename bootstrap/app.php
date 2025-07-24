<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add rate limiting for API routes
        $middleware->throttleApi();
        
        // Add middleware to handle POST size errors
        $middleware->web(prepend: \App\Http\Middleware\HandlePostSizeError::class);
        
        // Add rate limiting for auth routes
        $middleware->alias([
            'throttle.login' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':5,1',
            'throttle.api' => \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
