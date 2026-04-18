<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
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
        
        // EXCEPCIÓN CSRF PARA EL WEBHOOK DE META
        // Esto permite que Facebook/Instagram nos envíe datos por POST sin ser bloqueados
        $middleware->validateCsrfTokens(except: [
            '/webhook/meta',
        ]);

        $middleware->alias([
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 401 — No autenticado: redirige al ecommerce (modal de login)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if (! $request->expectsJson()) {
                return redirect('/');
            }
        });

        // 403 — Sin permiso: redirige a la ruta anterior con mensaje flash
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if (! $request->expectsJson()) {
                return redirect()->back()
                    ->with('sin_permiso', 'No tienes permiso para realizar esta acción.');
            }
        });
    })->create();