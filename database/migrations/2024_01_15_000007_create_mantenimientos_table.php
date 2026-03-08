<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();

            // Relaciones
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->unsignedBigInteger('ticket_id')->nullable();

            // Tipo de mantenimiento
            $table->enum('tipo', [
                'preventivo',
                'correctivo',
                'predictivo',
                'limpieza',
                'inspeccion'
            ]);

            // Programación
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->date('fecha_programada');
            $table->time('hora_programada')->nullable();
            $table->date('fecha_realizada')->nullable();
            $table->integer('duracion_estimada_horas')->default(2);
            $table->integer('duracion_real_horas')->nullable();

            // Ubicación
            $table->string('direccion');

            // Estado
            $table->enum('estado', [
                'programado',
                'confirmado',
                'en_progreso',
                'completado',
                'cancelado',
            ])->default('programado');

            // Checklist y resultados
            $table->json('checklist')->nullable();
            $table->json('resultados')->nullable();

            // Hallazgos
            $table->text('hallazgos')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->boolean('requiere_seguimiento')->default(false);
            $table->date('fecha_proximo_mantenimiento')->nullable();

            // Costos (referencia interna operativa)
            $table->decimal('costo_mano_obra', 10, 2)->default(0);
            $table->decimal('costo_materiales', 10, 2)->default(0);
            $table->decimal('costo_transporte', 10, 2)->default(0);
            $table->decimal('costo_total', 10, 2)->default(0);

            // Asignación
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');

            // Evidencias
            $table->json('evidencias')->nullable();

            // Notas
            $table->text('observaciones')->nullable();
            $table->text('notas_internas')->nullable();

            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['cliente_id', 'estado']);
            $table->index(['tecnico_id', 'fecha_programada']);
            $table->index(['estado', 'fecha_programada']);
            $table->index('fecha_proximo_mantenimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
