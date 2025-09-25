<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('notificaciones')) {
            Schema::create('notificaciones', function (Blueprint $table) {
                $table->increments('idNot');
                $table->unsignedBigInteger('idUsuNot')->nullable(); // ← Cambiado aquí
                $table->string('menNot', 225)->nullable();
                $table->dateTime('fechNot')->nullable();
                $table->enum('estNot', ['Activo', 'Inactivo'])->nullable();
                $table->timestamps();

                $table->foreign('idUsuNot')->references('id')->on('usuarios')->onDelete('cascade'); // ← Y aquí
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}

