<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'admin');
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
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'admin');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'admin');
    }
}
