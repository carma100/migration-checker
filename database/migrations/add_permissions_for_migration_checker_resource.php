<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('moonshine-rbac:permissions', ['resourceName' => 'MigrationCheckerResource']);
        $adminRole = Role::findById(1, 'moonshine');
        $adminRole->givePermissionTo(Permission::query()->get()->pluck('name')->toArray());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
