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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // MANT-2024-001
            $table->string('slug')->unique();
            
            // Relaciones
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('venta_id')->nullable()->constrained('sales')->onDelete('set null');
            
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
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            
            // Estado
            $table->enum('estado', [
                'programado',
                'confirmado',
                'en_camino',
                'en_progreso',
                'completado',
                'cancelado',
                'reprogramado'
            ])->default('programado');
            
            // Datos del sistema
            $table->decimal('potencia_sistema_kw', 10, 2)->nullable();
            $table->integer('cantidad_paneles')->nullable();
            $table->string('marca_inversor')->nullable();
            $table->string('modelo_inversor')->nullable();
            
            // Checklist y resultados
            $table->json('checklist')->nullable(); // Items a revisar
            $table->json('resultados')->nullable(); // Resultados de la revisión
            
            // Mediciones
            $table->decimal('produccion_actual_kwh', 12, 2)->nullable();
            $table->decimal('produccion_esperada_kwh', 12, 2)->nullable();
            $table->decimal('eficiencia_porcentaje', 5, 2)->nullable();
            
            // Hallazgos
            $table->text('hallazgos')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->boolean('requiere_seguimiento')->default(false);
            $table->date('fecha_proximo_mantenimiento')->nullable();
            
            // Costos
            $table->boolean('es_gratuito')->default(false); // Si está incluido en el servicio
            $table->decimal('costo_mano_obra', 10, 2)->default(0);
            $table->decimal('costo_materiales', 10, 2)->default(0);
            $table->decimal('costo_transporte', 10, 2)->default(0);
            $table->decimal('costo_total', 10, 2)->default(0);
            $table->enum('estado_pago', ['pendiente', 'pagado', 'no_aplica'])->default('no_aplica');
            
            // Asignación
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            
            // Firmas y evidencias
            $table->string('firma_cliente')->nullable(); // Path a imagen de firma
            $table->string('firma_tecnico')->nullable();
            $table->json('fotos_antes')->nullable();
            $table->json('fotos_despues')->nullable();
            
            // Satisfacción
            $table->integer('calificacion')->nullable(); // 1-5
            $table->text('comentario_cliente')->nullable();
            
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
