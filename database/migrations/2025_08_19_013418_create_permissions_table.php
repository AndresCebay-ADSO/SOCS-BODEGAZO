<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: 'productos.view'
            $table->string('description'); // Ej: 'Ver listado de productos'
            $table->string('module'); // Ej: 'productos'
            $table->string('action'); // Ej: 'view', 'create', 'edit', 'delete'
            $table->timestamps();
            
            $table->unique(['module', 'action']); // Cada combinación módulo-acción debe ser única
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};