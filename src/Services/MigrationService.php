<?php

namespace Carma\MigrationChecker\Services;

use Carma\MigrationChecker\Models\MigrationChecker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

readonly class MigrationService
{
    public function __construct(
        private MigrationChecker $model,
    ) {}

    /**
     * Get all migrations
     */
    public function updateAllMigrations(): void
    {
        $migrations = $this->getAllMigrationsFromSystem();
        $existingMigrationNames = DB::table('migration_checkers')->pluck('migration')->toArray();
        $migrationsToDelete = array_diff($existingMigrationNames, array_column($migrations, 'migration'));

        if (! empty($migrationsToDelete)) {
            DB::table('migration_checkers')->whereIn('migration', $migrationsToDelete)->delete();
        }

        Cache::remember($this->model::CACHE_KEY.md5(serialize($migrations)), now()->addWeek(), function () use ($migrations) {
            DB::table('migration_checkers')->upsert($migrations, ['migration']);

            return $migrations;
        });
    }

    /**
     * Get all migrations from system
     */
    protected function getAllMigrationsFromSystem(): array
    {
        $migrationFiles = File::files(database_path('migrations'));
        $existingMigrations = DB::table('migrations')->pluck('batch', 'migration')->toArray();

        return array_map(function ($file) use ($existingMigrations) {
            $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);

            return [
                'migration' => $name,
                'batch' => $existingMigrations[$name] ?? null,
                'status' => isset($existingMigrations[$name]) ? 'Ran' : 'Pending',
            ];
        }, $migrationFiles);
    }
}
