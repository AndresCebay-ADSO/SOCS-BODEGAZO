<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
{
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id(); 
        $table->string('nomUsu', 100);
        $table->string('apeUsu', 70);
        $table->string('dirUsu', 50)->nullable();
        $table->string('telUsu', 10)->nullable();
        $table->enum('TipdocUsu', ['Cedula de Ciudadania', 'Tarjeta de Identidad']);
        $table->string('numdocUsu', 11)->unique()->nullable();
        $table->string('emaUsu', 100)->unique();
        $table->string('passUsu', 255);
        $table->unsignedBigInteger('idRolUsu')->nullable(); 
        $table->string('estadoUsu')->default('activo');
        $table->rememberToken();
        $table->timestamps();

        $table->foreign('idRolUsu')->references('idRol')->on('roles')->onDelete('set null');
    });

}

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}

