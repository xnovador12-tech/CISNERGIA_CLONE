<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\WishList;
use App\Observers\UserObserver;
use App\Observers\WishListObserver;

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

        // Observers CRM ↔ E-commerce
        User::observe(UserObserver::class);           // Registro → Prospecto automático
        WishList::observe(WishListObserver::class);    // Favoritos → Oportunidad automática
    }
}
