<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de roles compatible con Spatie Laravel Permission.
     *
     * Campos propios de Spatie:
     *   - name       → nombre del rol (ej: "Administrador")
     *   - guard_name → guard de autenticación (siempre "web" en este proyecto)
     *
     * Campos propios del proyecto:
     *   - slug        → para URLs amigables (ej: "administrador")
     *   - descripcion → descripción visible en el panel de configuraciones
     *   - estado      → Activo / Inactivo
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('guard_name')->default('web');
            $table->string('descripcion')->nullable();
            $table->string('estado')->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
