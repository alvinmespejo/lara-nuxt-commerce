<?php

use App\Http\Middleware\Cart\EmptyResponse;
use App\Http\Middleware\Cart\Sync;
use App\Http\Middleware\JWTAuthGuardMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
        ->alias([
            'jwt' => JWTAuthGuardMiddleware::class,
            'cart.sync' => Sync::class,
            'cart.empty' => EmptyResponse::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
