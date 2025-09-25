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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('idPed');
            $table->unsignedBigInteger('idUsuPed');
            $table->dateTime('fecPed')->default(now());
            $table->decimal('prePed', 10, 2);
            $table->string('estPed', 20);
            
            // RELACIÓN con productos
            $table->unsignedBigInteger('idProPed');
            $table->foreign('idProPed')->references('idPro')->on('productos')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
