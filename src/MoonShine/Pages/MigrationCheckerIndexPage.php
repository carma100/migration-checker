<?php

declare(strict_types=1);

namespace Carma\MigrationChecker\MoonShine\Pages;

use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\IndexPage;

class MigrationCheckerIndexPage extends IndexPage
{
    public function subtitle(): string
    {
        return trans('migration-checker::admin.subtitle');
    }

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(trans('migration-checker::admin.fields.migration_name'), 'migration'),
            Number::make(trans('migration-checker::admin.fields.batch'), 'batch')
                ->badge('blue'),
            Text::make(trans('migration-checker::admin.fields.status'), 'status')
                ->badge(fn ($value) => $value === 'Ran' ? 'green' : 'red'),
        ];
    }
}
