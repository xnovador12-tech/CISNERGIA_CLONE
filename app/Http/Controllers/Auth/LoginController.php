<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Ruta de fallback para redirectPath().
     * No se usa realmente — la lógica real está en authenticated().
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Hook ejecutado después de un login exitoso.
     *
     * IMPORTANTE: al retornar una respuesta desde aquí, Laravel
     * omite el fallback estándar "redirect()->intended()" que suele
     * recuperar una URL previa guardada en la sesión. Esto evita que
     * un usuario (ej. Administrador) termine en una URL del ecommerce
     * como /cart/count porque el layout del ecommerce hace fetch a esa
     * URL al cargar la landing antes del login.
     *
     * Política de redirección:
     *   - Rol "Cliente"                    → home ecommerce ('/')
     *   - Personal interno con dashboard    → /admin-dashboard
     *   - Personal interno SIN dashboard    → /admin-perfil (sigue logueado;
     *                                          puede gestionar perfil y
     *                                          esperar a que Gerencia le
     *                                          asigne permisos)
     */
    protected function authenticated(Request $request, $user)
    {
        // Limpiar cualquier URL intended previa para evitar que Laravel
        // la use y redirija al usuario fuera de su panel correspondiente.
        $request->session()->forget('url.intended');

        // Cliente (o usuario sin rol) → ecommerce
        if (! $user->esPersonalInterno()) {
            return redirect()->route('ecommerce.index');
        }

        // Personal interno CON permiso de dashboard → panel principal
        if ($user->can('dashboard.index')) {
            return redirect()->route('admin-dashboard.index');
        }

        // Personal interno SIN permiso de dashboard → al perfil
        // (admin-perfil no requiere permiso específico, lo entregué así
        //  en web.php: cualquier autenticado puede gestionar su perfil)
        //
        // El usuario queda logueado y ve un mensaje claro. NO lo
        // deslogueamos porque es agresivo y si le está configurando sus
        // permisos Gerencia, podría necesitar que siga activo.
        return redirect()->route('admin-perfil.index')->with(
            'sin_permiso',
            'Aún no tienes permisos asignados en el sistema. Mientras tanto, puedes gestionar tu perfil. Contacta a Gerencia para configurar tus accesos.'
        );
    }

    /**
     * Fallback que Laravel consulta si authenticated() no retorna respuesta.
     * Lo mantenemos por si en el futuro se elimina authenticated().
     */
    protected function redirectTo(): string
    {
        $user = Auth::user();

        if ($user && $user->esPersonalInterno()) {
            return '/admin-dashboard';
        }

        return '/';
    }
}
