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
        
        // 1. Daftarkan TrustProxies secara Global di urutan paling atas
        $middleware->prepend(\App\Http\Middleware\TrustProxies::class);

        // 2. Kecualikan Callback Midtrans dari Validasi CSRF Token
        $middleware->validateCsrfTokens(except: [
            'midtrans/callback'
        ]);

        // 3. Daftarkan Alias Middleware untuk Route Akses Tingkat Pengguna
        $middleware->alias([
            'admin' => \App\Http\Middleware\admin::class,
            'reader' => \App\Http\Middleware\reader::class,
            'customer' => \App\Http\Middleware\customer::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();