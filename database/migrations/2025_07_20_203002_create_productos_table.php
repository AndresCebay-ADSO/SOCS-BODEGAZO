<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            // Estructura básica (como la tienes actualmente)
            $table->bigIncrements('idPro');
            $table->string('nomPro', 100);
            $table->string('marPro', 50)->nullable();
            $table->string('codPro', 20)->unique();
            $table->string('colPro', 30)->nullable();
            $table->string('tallPro', 10)->nullable();
            $table->integer('canPro')->default(0);
            $table->unsignedBigInteger('idcatPro');
            $table->timestamps();

            // Mejoras adicionales (seguras para producción)
            $table->string('unidad_medida', 10)->default('UND')->comment('UN, KG, LT, etc');
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->softDeletes(); // Para eliminación lógica

            // Índices para optimización
            $table->index('idcatPro');
            $table->index('codPro');
            $table->index('nomPro');
            $table->index(['activo', 'canPro']);
        });

        // Si necesitas modificar columnas existentes (ejemplo)
        Schema::table('productos', function (Blueprint $table) {
            $table->string('nomPro')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};