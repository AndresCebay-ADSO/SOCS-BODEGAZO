<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Primero eliminamos la foreign key
            $table->dropForeign(['idProPed']);

            // Ahora sí eliminamos la columna
            $table->dropColumn('idProPed');
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('idProPed')->nullable();

            // Si quieres, restauras la foreign key
            $table->foreign('idProPed')->references('idPro')->on('productos')->onDelete('cascade');
        });
    }
};
