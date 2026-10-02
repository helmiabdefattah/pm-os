<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Tenant routes (routes/tenant.php) are mapped by
        // App\Providers\TenancyServiceProvider::mapRoutes().
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Custom middleware aliases used by the route files.
        // NOTE: the 'tenant' and 'central_admin' classes below are referenced
        // by routes/tenant.php and routes/web.php but do not exist yet — create
        // them (or adjust these targets) before those routes are requested.
        //
        // $middleware->alias([
        //     'tenant'        => \App\Http\Middleware\InitializeTenancy::class,
        //     'central_admin' => \App\Http\Middleware\EnsureCentralAdmin::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
