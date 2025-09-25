<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permission_role', function (Blueprint $table) {
            // Añadir timestamps si no existen
            if (!Schema::hasColumn('permission_role', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('permission_role', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('permission_role', function (Blueprint $table) {
            // Revertir cambios si es necesario
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};