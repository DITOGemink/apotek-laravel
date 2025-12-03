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
        // alias untuk route-middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
        ]);

        // kalau mau PreventBackHistory jalan di semua route 'web',
        // bisa juga tambahkan ke group web:
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
