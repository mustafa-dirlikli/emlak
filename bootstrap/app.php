<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
        // Giriş yapılmamışsa admin sayfalarında giriş sayfasına yönlendir
        $middleware->redirectGuestsTo(fn (Request $request) => route('admin.login'));
        // Giriş yapmış kullanıcı /admin/giris'e gelirse panele yönlendir
        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->is('admin/giris')) {
                return route('admin.dashboard');
            }
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
