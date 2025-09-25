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
        Schema::create('pagos_nequi', function (Blueprint $table) {
            $table->id();
            
            // Información del pago
            $table->unsignedBigInteger('id_factura')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->string('numero_celular', 15);
            $table->decimal('monto', 15, 2);
            $table->string('moneda', 3)->default('COP');
            
            // Información de la transacción Nequi
            $table->string('transaction_id', 100)->unique();
            $table->string('reference_id', 100)->unique();
            $table->string('status', 50); // PENDING, SUCCESS, FAILED, EXPIRED
            $table->string('message', 200)->nullable();
            
            // Información de la API
            $table->string('api_response_id', 100)->nullable();
            $table->text('api_request')->nullable();
            $table->text('api_response')->nullable();
            $table->integer('api_status_code')->nullable();
            
            // Información de validación
            $table->string('codigo_validacion', 10)->nullable();
            $table->timestamp('fecha_expiracion')->nullable();
            $table->timestamp('fecha_pago')->nullable();
            
            // Información adicional
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->text('notas')->nullable();
            
            // Auditoría
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('transaction_id');
            $table->index('reference_id');
            $table->index('status');
            $table->index('id_usuario');
            $table->index('id_factura');
            $table->index('numero_celular');
            
            // Foreign keys
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_factura')->references('id')->on('facturas_electronicas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_nequi');
    }
}; 