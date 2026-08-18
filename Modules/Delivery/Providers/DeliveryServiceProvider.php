<?php

namespace Modules\Delivery\Providers;

use Illuminate\Support\ServiceProvider;

class DeliveryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'delivery');
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
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'delivery');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'delivery');
    }
}
