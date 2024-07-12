<?php

declare(strict_types=1);

namespace Carma\MigrationChecker\Providers;

use Carma\MigrationChecker\MoonShine\Resources\MigrationCheckerResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Menu\MenuItem;

class MigrationCheckerMenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        moonshine()
            ->vendorsMenu([
                MenuItem::make(
                    static fn () => trans('migration-checker::admin.migrations'),
                    new MigrationCheckerResource(),
                )->canSee(fn () => auth()->user()?->hasRole('Super Admin')),
            ]);
    }
}
