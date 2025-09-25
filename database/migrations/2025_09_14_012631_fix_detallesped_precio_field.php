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
        Schema::table('detallesped', function (Blueprint $table) {
            // Primero eliminamos la foreign key incorrecta
            $table->dropForeign(['preProDet']);
            
            // Eliminamos la columna
            $table->dropColumn('preProDet');
            
            // Agregamos la columna correcta como decimal
            $table->decimal('preProDet', 10, 2)->after('canDet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detallesped', function (Blueprint $table) {
            // Eliminamos la columna decimal
            $table->dropColumn('preProDet');
            
            // Restauramos la columna original (aunque esté mal)
            $table->unsignedBigInteger('preProDet')->nullable();
            $table->foreign('preProDet')->references('idPro')->on('productos')->onDelete('cascade');
        });
    }
};