<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    // Handle mail transport exceptions gracefully
    $exceptions->renderable(function (TransportException $e, $request) {
        // Log the mail error with full details
        Log::error('Mail Transport Error', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'url' => $request->fullUrl(),
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
        ]);

        // Don't block the request - mail failure shouldn't stop user actions
        // The database notification was already saved, so users can see it in-app
        return null; // Continue with normal error handling (will be caught by outer try-catch)
    });

    // Handle general mail exceptions
    $exceptions->renderable(function (\Swift_TransportException $e, $request) {
        Log::error('Swift Mail Transport Error', [
            'message' => $e->getMessage(),
            'url' => $request->fullUrl(),
            'user_id' => auth()->id(),
        ]);

        return null;
    });
    })->create();
