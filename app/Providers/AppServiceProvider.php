<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Pedido;
use App\Observers\UserObserver;
use App\Observers\PedidoObserver;
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

        // paginacion
        Paginator::useBootstrapFive(); 
        app()->setLocale('es'); 
    }
}
