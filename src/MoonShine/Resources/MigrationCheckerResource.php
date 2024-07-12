<?php

declare(strict_types=1);

namespace Carma\MigrationChecker\MoonShine\Resources;

use Carma\MigrationChecker\Models\MigrationChecker;
use Carma\MigrationChecker\MoonShine\Pages\MigrationCheckerIndexPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Pages\Page;
use MoonShine\Resources\ModelResource;
use Throwable;

class MigrationCheckerResource extends ModelResource
{
    protected string $model = MigrationChecker::class;

    protected bool $isAsync = true;

    public function title(): string
    {
        return trans('migration-checker::admin.migrations');
    }

    /**
     * @return list<Page>
     */
    public function pages(): array
    {
        return [
            MigrationCheckerIndexPage::make($this->title()),
        ];
    }

    /**
     * @return array<string, string[]|string>
     */
    public function rules(Model $item): array
    {
        return [];
    }

    /**
     * @return list<ActionButton>
     *
     * @throws Throwable
     */
    public function buttons(): array
    {
        $migrationCheckerData = MigrationChecker::query()->select(['id', 'batch', 'status'])->get();

        return [
            ActionButton::make(trans('migration-checker::admin.action_buttons.execute'))->method('runMigration', events: ['table-updated-index-table'])->canSee(fn (Model $item) => $item->status === 'Pending')->primary(),
            ActionButton::make(trans('migration-checker::admin.action_buttons.rollback'))
                ->method('rollbackMigration', events: ['table-updated-index-table'])
                ->canSee(function (Model $item) use ($migrationCheckerData) {
                    $queryData = $migrationCheckerData->where('batch', $item->batch)->where('status', 'Ran');

                    return ! $queryData->isEmpty() && $item->id === $queryData->value('id');
                })
                ->primary(),
        ];
    }

    /**
     * @return array<string>
     */
    public function getActiveActions(): array
    {
        return [];
    }

    public function runMigration(): void
    {
        Artisan::call('migrate --path=database/migrations/'.$this->getItem()->getAttribute('migration').'.php');
    }

    public function rollbackMigration(): void
    {
        Artisan::call('migrate:rollback --batch='.$this->getItem()->getAttributeValue('batch'));
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }
}
