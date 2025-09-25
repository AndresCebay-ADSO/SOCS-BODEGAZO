<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registro_actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->string('accion'); // Ej: 'login', 'create', 'update'
            $table->string('modelo')->nullable(); // Ej: 'Usuario', 'Producto'
            $table->unsignedBigInteger('modelo_id')->nullable(); // ID del modelo afectado
            $table->json('detalles')->nullable(); // Datos adicionales
            $table->string('ip');
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registro_actividades');
    }
};