<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tablas de permisos para Spatie Laravel Permission.
     *
     * Tablas creadas:
     *   - permissions            → catálogo de permisos del sistema
     *   - model_has_permissions  → pivot usuario ↔ permiso directo
     *   - model_has_roles        → pivot usuario ↔ rol (reemplaza role_id en users)
     *   - role_has_permissions   → pivot rol ↔ permiso
     *
     * Campos extra en permissions (para la UI del panel):
     *   - slug       → clave amigable igual al name (ej: crm.prospectos.index)
     *   - label      → nombre legible en español (ej: "Ver Prospectos")
     *   - modulo     → agrupación para los checkboxes (ej: "CRM - Prospectos")
     */
    public function up(): void
    {
        // Tabla de permisos
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');                          // slug técnico (crm.prospectos.index)
            $table->string('slug')->unique();                // mismo valor que name, para URLs
            $table->string('guard_name')->default('web');
            $table->string('label');                         // nombre legible en español
            $table->string('modulo');                        // agrupación para la UI
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // Pivot: modelo (User) ↔ permiso directo
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        });

        // Pivot: modelo (User) ↔ rol
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type'],
                'model_has_roles_role_model_type_primary');
        });

        // Pivot: rol ↔ permiso
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('permissions');
    }
};
