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
        Schema::create('facturas_electronicas', function (Blueprint $table) {
            $table->id();
            
            // Información básica de la factura
            $table->string('numero_factura')->unique();
            $table->string('prefijo', 10)->nullable();
            $table->string('resolucion_dian', 50)->nullable();
            $table->date('fecha_emision');
            $table->time('hora_emision');
            $table->date('fecha_vencimiento')->nullable();
            
            // Información del cliente
            $table->unsignedBigInteger('id_usuario');
            $table->string('tipo_documento_cliente', 10); // CC, NIT, CE, etc.
            $table->string('numero_documento_cliente', 20);
            $table->string('nombre_cliente', 100);
            $table->string('direccion_cliente', 200)->nullable();
            $table->string('telefono_cliente', 20)->nullable();
            $table->string('email_cliente', 100)->nullable();
            
            // Información de la empresa
            $table->string('nit_empresa', 20);
            $table->string('nombre_empresa', 100);
            $table->string('direccion_empresa', 200);
            $table->string('telefono_empresa', 20)->nullable();
            $table->string('email_empresa', 100)->nullable();
            
            // Totales
            $table->decimal('subtotal', 15, 2);
            $table->decimal('iva', 15, 2)->default(0);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->string('moneda', 3)->default('COP');
            
            // Estado de la factura
            $table->enum('estado', ['borrador', 'enviada', 'aceptada', 'rechazada', 'anulada'])->default('borrador');
            $table->string('cufe', 100)->nullable(); // Código Único de Factura Electrónica
            $table->string('qr_code', 500)->nullable();
            $table->text('xml_content')->nullable();
            $table->text('pdf_content')->nullable();
            
            // Información de pago
            $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'transferencia', 'nequi', 'daviplata'])->default('efectivo');
            $table->enum('estado_pago', ['pendiente', 'pagado', 'fallido'])->default('pendiente');
            $table->string('referencia_pago', 100)->nullable();
            
            // Campos adicionales DIAN
            $table->string('tipo_operacion', 10)->default('10'); // 10: Estándar, 09: AIU
            $table->string('tipo_documento', 10)->default('01'); // 01: Factura
            $table->string('ambiente', 10)->default('2'); // 1: Pruebas, 2: Producción
            $table->string('version_ubl', 10)->default('2.1');
            $table->string('version_dian', 10)->default('2.1');
            
            // Auditoría
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('numero_factura');
            $table->index('id_usuario');
            $table->index('estado');
            $table->index('fecha_emision');
            $table->index('cufe');
            
            // Foreign keys
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas_electronicas');
    }
};
