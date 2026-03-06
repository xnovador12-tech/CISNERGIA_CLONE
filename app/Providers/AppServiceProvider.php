<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Pedido;
use App\Observers\UserObserver;
use App\Observers\PedidoObserver;

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
        Schema::defaultStringLength(191);

        // Observer CRM ↔ E-commerce
        User::observe(UserObserver::class); // Registro → Prospecto automático

        // Observer Operaciones
        Pedido::observe(PedidoObserver::class);
    }
}
