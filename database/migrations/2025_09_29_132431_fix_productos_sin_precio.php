<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar productos que no tienen precio de venta
        DB::table('productos')
            ->whereNull('precio_venta')
            ->orWhere('precio_venta', '<=', 0)
            ->update([
                'precio_venta' => DB::raw('COALESCE(precio_compra * 1.3, 10000)'), // 30% de ganancia o $10,000 por defecto
                'updated_at' => now()
            ]);
        
        // Hacer el campo precio_venta obligatorio
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio_venta', 10, 2)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el campo a nullable
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio_venta', 10, 2)->nullable()->change();
        });
    }
};