<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Agrega action si no existe
            if (!Schema::hasColumn('permissions', 'action')) {
                $table->string('action')->after('module');
            }
            // Agrega deleted_at si no existe
            if (!Schema::hasColumn('permissions', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
            // Agrega el índice único si no existe (sin Doctrine)
            if (!Schema::hasTable('permissions') || !Schema::hasColumn('permissions', 'module') || !Schema::hasColumn('permissions', 'action')) {
                // Este chequeo es básico; asumimos que el índice no existe si las columnas no estaban
                $table->unique(['module', 'action']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('action');
            $table->dropSoftDeletes();
            $table->dropUnique(['module', 'action']);
        });
    }
};