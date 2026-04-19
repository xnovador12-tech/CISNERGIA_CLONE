<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // ═══════════════════════════════════════════════════════════════
        // Closure unificada para manejar respuestas 403 (sin permiso)
        // ═══════════════════════════════════════════════════════════════
        //
        // Política:
        //   1. Personal interno (ERP) → vuelve a una URL /admin* o al dashboard.
        //      Nunca lo mandamos a URLs del ecommerce (aunque sean "previous")
        //      para evitar que termine en /cart/count, /products u otras URLs
        //      que el layout del ecommerce pudo haber cacheado en sesión
        //      vía fetchs de JS (bug típico de carrito).
        //   2. Cliente (o anónimo) → vuelve a URL ecommerce o al home /.
        //   3. Si el request es AJAX/JSON → respuesta JSON 403 limpia.
        //
        // Importante: usamos $request->headers->get('referer') en lugar de
        // url()->previous() porque este último consulta también la key
        // '_previous.url' de sesión, que es actualizada por cualquier
        // request exitosa (incluyendo fetchs de JS a /cart/count).
        // ═══════════════════════════════════════════════════════════════
        $renderForbidden = function (Request $request) {
            $mensaje = 'No tienes permiso para realizar esta acción. Contacta a Gerencia si crees que es un error.';

            // ─── Respuesta JSON para AJAX/API ────────────────────────────
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error'   => 'Sin permiso',
                    'message' => $mensaje,
                ], 403);
            }

            // ─── Determinar si el usuario es personal interno ────────────
            $user      = auth()->user();
            $esInterno = $user && method_exists($user, 'esPersonalInterno') && $user->esPersonalInterno();

            // ─── URL de fallback según rol ───────────────────────────────
            $fallback = $esInterno ? url('/admin-dashboard') : url('/');

            // ─── Obtener referer real del browser (ignora sesión) ────────
            $referer    = $request->headers->get('referer');
            $currentUrl = $request->fullUrl();

            // ─── Anti-loop ROBUSTO (comparando PATHS, no URLs completas) ──
            // Si el fallback apunta a la misma ruta que está fallando,
            // hay loop potencial. Usamos $request->path() que devuelve
            // solo el path sin host/puerto/query/esquema — evita problemas
            // por diferencias entre APP_URL y la URL real del navegador
            // (localhost vs 127.0.0.1, http vs https, trailing slash, etc.).
            //
            // Cuando se detecta el loop, redirigimos al PERFIL del usuario
            // (admin-perfil no requiere permiso — cualquier autenticado
            // puede entrar). Así el usuario NO pierde su sesión y puede
            // al menos gestionar su perfil / cambiar contraseña / cerrar
            // sesión manualmente.
            $currentPath  = '/' . ltrim($request->path(), '/');
            $fallbackPath = $esInterno ? '/admin-dashboard' : '/';

            if ($currentPath === $fallbackPath && $esInterno) {
                return redirect()->route('admin-perfil.index')
                    ->with('sin_permiso', 'Aún no tienes permisos asignados en el sistema. Mientras tanto, puedes gestionar tu perfil. Contacta a Gerencia para configurar tus accesos.');
            }

            // ─── Caso 1: sin referer o mismo URL → ir al fallback ────────
            if (empty($referer) || $referer === $currentUrl) {
                return redirect($fallback)->with('sin_permiso', $mensaje);
            }

            // ─── Caso 2: personal interno solo puede volver a URL /admin* ─
            if ($esInterno) {
                $path = parse_url($referer, PHP_URL_PATH) ?? '/';

                // Aceptar rutas del panel admin:
                //   /admin-dashboard, /admin-pedidos, /admin/crm/*, etc.
                $esRutaAdmin = str_starts_with($path, '/admin-')
                    || str_starts_with($path, '/admin/')
                    || $path === '/admin';

                if (! $esRutaAdmin) {
                    return redirect($fallback)->with('sin_permiso', $mensaje);
                }
            }

            // ─── Caso 3: referer válido → volver ahí ─────────────────────
            return redirect($referer)->with('sin_permiso', $mensaje);
        };

        // ═══════════════════════════════════════════════════════════════
        // 401 — No autenticado
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error'   => 'No autenticado.',
                    'message' => 'Debes iniciar sesión para acceder a este recurso.',
                ], 401);
            }
            return redirect('/');
        });

        // ═══════════════════════════════════════════════════════════════
        // 403 — Sin permiso (Laravel: Gate::authorize, $this->authorize)
        // ═══════════════════════════════════════════════════════════════
        $exceptions->render(function (AuthorizationException $e, Request $request) use ($renderForbidden) {
            return $renderForbidden($request);
        });

        // ═══════════════════════════════════════════════════════════════
        // 403 — Sin permiso (Spatie: middleware role/permission)
        // ═══════════════════════════════════════════════════════════════
        // IMPORTANTE: Spatie lanza UnauthorizedException (no
        // AuthorizationException). Por eso necesitamos un handler
        // explícito para esta clase, sino el usuario vería la pantalla
        // 403 genérica de Laravel en lugar de la redirección suave.
        $exceptions->render(function (UnauthorizedException $e, Request $request) use ($renderForbidden) {
            return $renderForbidden($request);
        });

    })->create();
