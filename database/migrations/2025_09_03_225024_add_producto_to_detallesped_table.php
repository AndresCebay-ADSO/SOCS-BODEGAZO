<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detallesped', function (Blueprint $table) {
            // Si tus productos están en la tabla 'productos' con clave primaria 'idPro'
            $table->unsignedBigInteger('idProDet')->after('idPedDet');

            // Relación foránea con productos
            $table->foreign('idProDet')->references('idPro')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('detallesped', function (Blueprint $table) {
            $table->dropForeign(['idProDet']);
            $table->dropColumn('idProDet');
        });
    }
};
