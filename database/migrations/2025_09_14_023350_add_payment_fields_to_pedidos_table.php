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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('referenceCode', 100)->nullable()->after('estPed');
            $table->string('signature', 100)->nullable()->after('referenceCode');
            $table->string('payment_method', 50)->nullable()->after('signature');
            $table->string('payment_state', 50)->nullable()->after('payment_method');
            $table->string('transaction_id', 100)->nullable()->after('payment_state');
            $table->timestamp('fecha_pago')->nullable()->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'referenceCode',
                'signature', 
                'payment_method',
                'payment_state',
                'transaction_id',
                'fecha_pago'
            ]);
        });
    }
};