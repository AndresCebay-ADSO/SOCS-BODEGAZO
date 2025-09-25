<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoriasTable extends Migration
{
    public function up()
    {
        // 1. Agregar softDeletes si no existe
        Schema::table('categorias', function (Blueprint $table) {
            if (!Schema::hasColumn('categorias', 'deleted_at')) {
                $table->softDeletes();
            }
            
            // 2. Cambiar campos nullable a not null
            $table->string('nomCat', 50)->nullable(false)->change();
            $table->enum('estCat', ['Activo', 'Inactivo'])->default('Activo')->nullable(false)->change();
            
            // 3. Agregar índices
            $table->index('nomCat');
            $table->index('estCat');
        });
    }

    public function down()
    {
        // Revertir los cambios si es necesario
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropIndex(['nomCat']);
            $table->dropIndex(['estCat']);
            $table->string('nomCat', 50)->nullable()->change();
            $table->enum('estCat', ['Activo', 'Inactivo'])->nullable()->change();
            
            if (Schema::hasColumn('categorias', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
}