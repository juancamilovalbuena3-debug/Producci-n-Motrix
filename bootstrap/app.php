<?php

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
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->append(\App\Http\Middleware\EnsureUtf8Response::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\InvalidArgumentException $e, $request) {
            if ($request->is('livewire/update') && str_contains($e->getMessage(), 'UTF-8')) {
                return response()->json([
                    'components' => [],
                    'assets' => [],
                ]);
            }
        });
    })->create();