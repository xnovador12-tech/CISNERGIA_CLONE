<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones_crm_leidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Para actividades (recordatorio / proxima)
            $table->unsignedBigInteger('actividad_crm_id')->nullable();

            // Para prospectos (seguimiento)
            $table->unsignedBigInteger('prospecto_id')->nullable();

            $table->enum('tipo', ['recordatorio', 'proxima', 'seguimiento']);
            $table->timestamp('created_at')->useCurrent();

            // Un usuario solo puede descartar una vez cada tipo por registro
            $table->unique(['user_id', 'actividad_crm_id', 'prospecto_id', 'tipo'], 'notif_crm_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones_crm_leidas');
    }
};
