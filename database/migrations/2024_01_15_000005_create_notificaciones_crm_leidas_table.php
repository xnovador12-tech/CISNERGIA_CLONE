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
        Schema::create('notificaciones_crm_leidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('actividad_crm_id')->constrained('actividades_crm')->onDelete('cascade');
            $table->enum('tipo', ['recordatorio', 'proxima']); // vencidas NO se descartan
            $table->timestamp('created_at')->useCurrent();

            // Un usuario solo puede descartar una vez cada tipo por actividad
            $table->unique(['user_id', 'actividad_crm_id', 'tipo'], 'notif_crm_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones_crm_leidas');
    }
};
