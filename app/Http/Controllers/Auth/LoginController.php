<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Ruta de fallback (no se usa realmente, la sobreescribe redirectTo()).
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirección post-login según el rol del usuario.
     *
     * - Personal interno (Gerencia, Admin, Ventas, etc.) → panel admin
     * - Cliente → ecommerce
     *
     * Usa el helper esPersonalInterno() del modelo User, que internamente
     * llama a $user->hasRole('Cliente') de Spatie.
     */
    protected function redirectTo(): string
    {
        $user = Auth::user();

        if ($user->esPersonalInterno()) {
            return '/admin-dashboard';
        }

        return '/';
    }
}
