<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReseñasTable extends Migration
{
    public function up()
    {
        Schema::create('reseñas', function (Blueprint $table) {
            $table->increments('idRes');
            $table->unsignedBigInteger('idUsuRes')->nullable();
            $table->integer('CalRes')->nullable();
            $table->string('ComRes', 225)->nullable();
            $table->dateTime('FechCreRes')->nullable();
            $table->timestamps();

            $table->foreign('idUsuRes')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reseñas');
    }
}
