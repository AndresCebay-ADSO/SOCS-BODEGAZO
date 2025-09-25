<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_permission', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('usuarios', 'id')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions', 'id')->onDelete('cascade');
            $table->primary(['user_id', 'permission_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_permission');
    }
};