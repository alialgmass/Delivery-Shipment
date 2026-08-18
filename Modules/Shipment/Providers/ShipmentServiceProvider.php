<?php

namespace Modules\Shipment\Providers;

use Illuminate\Support\ServiceProvider;

class ShipmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'shipment');
    }

    public function boot(): void
    {
        $this->registerMigration();
        $this->registerBladeView();
        $this->registerTranslations();
    }

    protected function registerMigration(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Databases/Migrations');
    }

    protected function registerBladeView(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'shipment');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'shipment');
    }
}
