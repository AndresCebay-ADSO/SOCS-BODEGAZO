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
        Schema::create('detalles_factura_electronica', function (Blueprint $table) {
            $table->id();
            
            // Relación con la factura
            $table->unsignedBigInteger('id_factura');
            $table->unsignedBigInteger('id_producto');
            
            // Información del producto
            $table->string('codigo_producto', 50);
            $table->string('nombre_producto', 200);
            $table->text('descripcion')->nullable();
            $table->string('unidad_medida', 10);
            
            // Cantidades y precios
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('porcentaje_iva', 5, 2)->default(19.00);
            $table->decimal('valor_iva', 15, 2);
            $table->decimal('porcentaje_descuento', 5, 2)->default(0);
            $table->decimal('valor_descuento', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            
            // Información adicional DIAN
            $table->string('codigo_impuesto', 10)->default('01'); // 01: IVA
            $table->string('base_imponible', 10)->default('01'); // 01: Base imponible
            $table->string('tipo_impuesto', 10)->default('01'); // 01: IVA
            
            // Auditoría
            $table->timestamps();
            
            // Índices
            $table->index('id_factura');
            $table->index('id_producto');
            
            // Foreign keys
            $table->foreign('id_factura')->references('id')->on('facturas_electronicas')->onDelete('cascade');
            $table->foreign('id_producto')->references('idPro')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_factura_electronica');
    }
};
