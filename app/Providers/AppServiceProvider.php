<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register services for dependency injection
        $this->app->bind(\App\Services\InventoryService::class, function ($app) {
            return new \App\Services\InventoryService();
        });

        $this->app->bind(\App\Services\OrdersService::class, function ($app) {
            return new \App\Services\OrdersService();
        });

        $this->app->bind(\App\Services\PaymentsService::class, function ($app) {
            return new \App\Services\PaymentsService();
        });

        $this->app->bind(\App\Services\OrderOrchestrator::class, function ($app) {
            return new \App\Services\OrderOrchestrator(
                $app->make(\App\Services\InventoryService::class),
                $app->make(\App\Services\OrdersService::class),
                $app->make(\App\Services\PaymentsService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
