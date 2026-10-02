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
        // 'tenant' is a middleware GROUP (referenced by routes/tenant.php):
        // identify the tenant from the request domain and block tenant routes
        // from being served on the central (SaaS) domains.
        $middleware->appendToGroup('tenant', [
            \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
            \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
        ]);

        // 'central_admin' alias (referenced by routes/web.php admin routes).
        $middleware->alias([
            'central_admin' => \App\Http\Middleware\EnsureCentralAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
