<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallespedTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('detallesped')) {
            Schema::create('detallesped', function (Blueprint $table) {
                $table->increments('idDet');
                $table->integer('canDet')->nullable();

                // Claves foráneas 
                $table->unsignedBigInteger('preProDet')->nullable();
                $table->unsignedBigInteger('idPedDet')->nullable();

                $table->timestamps();

                // Foreign keys
                $table->foreign('preProDet')->references('idPro')->on('productos')->onDelete('cascade');
                $table->foreign('idPedDet')->references('idPed')->on('pedidos')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('detallesped');
    }
}
