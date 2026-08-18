<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'auth');
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
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'auth');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'auth');
    }
}
