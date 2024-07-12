<?php

namespace Carma\MigrationChecker\Providers;

use Illuminate\Support\ServiceProvider;

class MigrationCheckerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'migration-checker');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
