<?php

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/module.php', 'user');
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
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'user');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'user');
    }
}
