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
        Schema::create('actividades_crm', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();

            // Tipo de actividad
            $table->enum('tipo', [
                'llamada',
                'email',
                'reunion',
                'visita_tecnica',
                'whatsapp',
                'seguimiento',
            ]);

            // Relación polimórfica (puede ser de prospecto, oportunidad, cliente, etc.)
            $table->nullableMorphs('actividadable'); // actividadable_id, actividadable_type (nullable: actividad puede existir sin entidad)

            // Detalles de la actividad
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('resultado')->nullable();

            // Programación
            $table->datetime('fecha_programada');
            $table->datetime('fecha_realizada')->nullable();

            // Ubicación (para visitas)
            $table->string('ubicacion')->nullable();

            // Estado
            $table->enum('estado', [
                'programada',
                'en_evaluacion',   // Visita técnica iniciada, técnico en sitio evaluando
                'completada',
                'cancelada',
                'reprogramada',
                'no_realizada'
            ])->default('programada');
            $table->text('motivo_cancelacion')->nullable();

            // Prioridad
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');

            // Recordatorios
            $table->boolean('recordatorio_activo')->default(true);
            $table->integer('recordatorio_minutos_antes')->default(30);

            // Asignación
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['user_id', 'estado', 'fecha_programada']);
            $table->index(['tipo', 'estado']);
            $table->index('fecha_programada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_crm');
    }
};
