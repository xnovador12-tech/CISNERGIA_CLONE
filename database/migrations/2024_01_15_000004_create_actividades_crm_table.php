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
                'videollamada',
                'whatsapp',
                'tarea',
                'nota',
                'otro'
            ]);
            
            // Relación polimórfica (puede ser de prospecto, oportunidad, cliente, etc.)
            $table->morphs('actividadable'); // actividadable_id, actividadable_type
            
            // Detalles de la actividad
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('resultado')->nullable(); // Qué se logró en la actividad
            
            // Programación
            $table->datetime('fecha_programada');
            $table->datetime('fecha_realizada')->nullable();
            $table->integer('duracion_minutos')->default(30);
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            
            // Ubicación (para visitas)
            $table->string('ubicacion')->nullable();
            $table->string('direccion_completa')->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            
            // Estado
            $table->enum('estado', [
                'programada',
                'en_progreso',
                'completada',
                'cancelada',
                'reprogramada',
                'no_realizada'
            ])->default('programada');
            $table->text('motivo_cancelacion')->nullable();
            
            // Prioridad
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
            
            // Recordatorios
            $table->boolean('recordatorio_activo')->default(true);
            $table->integer('recordatorio_minutos_antes')->default(30);
            $table->boolean('recordatorio_enviado')->default(false);
            
            // Para llamadas
            $table->string('telefono_contacto')->nullable();
            $table->enum('resultado_llamada', [
                'contestada',
                'no_contesta',
                'buzon',
                'numero_equivocado',
                'ocupado'
            ])->nullable();
            
            // Para emails
            $table->string('email_contacto')->nullable();
            $table->string('asunto_email')->nullable();
            
            // Seguimiento
            $table->boolean('requiere_seguimiento')->default(false);
            $table->date('fecha_seguimiento')->nullable();
            $table->text('notas_seguimiento')->nullable();
            
            // Asignación
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Responsable
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices (morphs ya crea índice para actividadable)
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
