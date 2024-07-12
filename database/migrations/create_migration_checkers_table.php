<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('migration_checkers', function (Blueprint $table): void {
            $table->id()->comment('ID миграции');
            $table->string('migration')->unique()->comment('Название миграции');
            $table->integer('batch')->nullable()->comment('Партия миграции');
            $table->string('status')->nullable()->comment('Статус миграции');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migration_checkers');
    }
};
