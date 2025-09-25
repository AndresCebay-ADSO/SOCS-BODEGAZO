<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id('idInv');
            $table->integer('canInv')->default(0);
            $table->timestamp('ultactInv')->nullable();
            $table->unsignedBigInteger('idProInv');
            $table->timestamps();

            $table->foreign('idProInv')
                  ->references('idPro')
                  ->on('productos')
                  ->onDelete('cascade');
            
            $table->index(['idProInv', 'ultactInv']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
};