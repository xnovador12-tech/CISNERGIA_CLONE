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
        Schema::create('oportunidades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();
            $table->string('nombre');
            
            // Relaciones
            $table->foreignId('prospecto_id')->constrained('prospectos')->onDelete('cascade');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            
            // Pipeline / Etapas
            $table->enum('etapa', [
                'calificacion',       // Evaluando si es viable
                'evaluacion',         // Evaluación técnica / visita / análisis
                'propuesta_tecnica',  // Elaborando propuesta y cotización
                'negociacion',        // Negociando condiciones
                'ganada',
                'perdida'
            ])->default('calificacion');
            
            // Clasificación
            $table->enum('tipo_proyecto', ['residencial', 'comercial', 'industrial', 'agricola'])->default('residencial');
            $table->enum('tipo_oportunidad', ['producto', 'servicio', 'mixto'])->default('producto');
            
            // Servicio
            $table->enum('tipo_servicio', [
                'instalacion', 'mantenimiento_preventivo', 'mantenimiento_correctivo', 'ampliacion', 'otro'
            ])->nullable();
            $table->text('descripcion_servicio')->nullable();
            
            // Visita técnica
            $table->boolean('requiere_visita_tecnica')->default(false);
            $table->date('fecha_visita_programada')->nullable();
            $table->text('resultado_visita')->nullable();
            
            // Valores económicos
            $table->decimal('monto_estimado', 14, 2)->default(0);
            $table->decimal('monto_final', 14, 2)->nullable();
            $table->integer('probabilidad')->default(10);
            $table->decimal('valor_ponderado', 14, 2)->default(0);
            
            // Descripción libre del negocio
            $table->text('descripcion')->nullable();
            
            // Fechas
            $table->date('fecha_creacion');
            $table->date('fecha_cierre_estimada')->nullable();
            $table->date('fecha_cierre_real')->nullable();
            
            // Motivo de pérdida
            $table->string('motivo_perdida')->nullable();
            $table->text('detalle_perdida')->nullable();
            $table->string('competidor_ganador')->nullable();
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Notas
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['etapa', 'user_id']);
            $table->index(['prospecto_id', 'etapa']);
            $table->index('fecha_cierre_estimada');
            $table->index(['tipo_proyecto', 'etapa']);
            $table->index('tipo_oportunidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oportunidades');
    }
};
