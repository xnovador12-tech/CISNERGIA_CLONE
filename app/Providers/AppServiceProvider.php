<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Pedido;
use App\Models\Sale;
use App\Models\InformacionEmpresa;
use App\Observers\UserObserver;
use App\Observers\PedidoObserver;
use App\Observers\SaleObserver;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Esto es lo nuevo que tienes que agregar:
        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        // Observer CRM ↔ E-commerce
        User::observe(UserObserver::class); 

        // Observer Operaciones
        Pedido::observe(PedidoObserver::class);

        // Observer Operaciones - Métricas de Campañas al pagar Venta
        Sale::observe(SaleObserver::class);

        // paginacion
        Paginator::useBootstrapFive(); 
        app()->setLocale('es');

        // ─────────────────────────────────────────────────────────────
        // View Composer: información de la empresa para el ecommerce
        // Inyecta la variable $infoEmpresa automáticamente en el layout
        // del ecommerce y en la página de contacto, evitando tener que
        // pasarla manualmente desde cada controlador.
        // ─────────────────────────────────────────────────────────────
        View::composer(['TEMPLATES.ecommerce', 'ECOMMERCE.contact'], function ($view) {
            try {
                if (Schema::hasTable('informacion_empresa')) {
                    $view->with('infoEmpresa', InformacionEmpresa::current() ?? new InformacionEmpresa());
                }
            } catch (\Throwable $e) {
                // En migraciones iniciales o entornos sin tabla aún,
                // no romper la vista. El layout usará valores por defecto.
            }
        }); 
    }
}
