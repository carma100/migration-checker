<?php

namespace Carma\MigrationChecker\Models;

use Carma\MigrationChecker\Services\MigrationService;
use Illuminate\Database\Eloquent\Model;

class MigrationChecker extends Model
{
    public const string CACHE_KEY = 'migrations_cache_key_';

    protected $guarded = [
        'id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        app(MigrationService::class)->updateAllMigrations();
    }
}
