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
            $table->string('nombre'); // Ej: "Sistema Solar 5kW - Casa Mendoza"
            
            // Relaciones
            $table->foreignId('prospecto_id')->constrained('prospectos')->onDelete('cascade');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null'); // Cuando se convierte
            
            // Pipeline / Etapas
            $table->enum('etapa', [
                'calificacion',      // Evaluando si es viable
                'analisis_sitio',    // Visita técnica para evaluar ubicación
                'propuesta_tecnica', // Elaborando propuesta
                'negociacion',       // Negociando condiciones
                'contrato',          // Firmando contrato
                'ganada',            // Cerrada ganada
                'perdida'            // Cerrada perdida
            ])->default('calificacion');
            
            // Valores económicos
            $table->decimal('monto_estimado', 14, 2)->default(0);
            $table->decimal('monto_final', 14, 2)->nullable();
            $table->integer('probabilidad')->default(10); // 0-100%
            $table->decimal('valor_ponderado', 14, 2)->default(0); // monto * probabilidad
            
            // Especificaciones técnicas del proyecto solar
            $table->enum('tipo_proyecto', ['residencial', 'comercial', 'industrial', 'agricola', 'bombeo_solar'])->default('residencial');
            $table->decimal('potencia_kw', 10, 2)->nullable(); // Potencia del sistema
            $table->integer('cantidad_paneles')->nullable();
            $table->string('tipo_panel')->nullable(); // Monocristalino, Policristalino
            $table->string('marca_panel')->nullable();
            $table->string('tipo_inversor')->nullable(); // String, Microinversor, Híbrido
            $table->string('marca_inversor')->nullable();
            $table->boolean('incluye_baterias')->default(false);
            $table->decimal('capacidad_baterias_kwh', 10, 2)->nullable();
            
            // Producción estimada
            $table->decimal('produccion_mensual_kwh', 12, 2)->nullable();
            $table->decimal('produccion_anual_kwh', 12, 2)->nullable();
            $table->decimal('ahorro_mensual_soles', 12, 2)->nullable();
            $table->decimal('ahorro_anual_soles', 12, 2)->nullable();
            $table->decimal('retorno_inversion_anos', 5, 2)->nullable(); // ROI en años
            
            // Fechas
            $table->date('fecha_creacion');
            $table->date('fecha_cierre_estimada')->nullable();
            $table->date('fecha_cierre_real')->nullable();
            $table->date('fecha_instalacion_estimada')->nullable();
            
            // Motivo de pérdida (si aplica)
            $table->string('motivo_perdida')->nullable();
            $table->text('detalle_perdida')->nullable();
            $table->string('competidor_ganador')->nullable();
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Vendedor
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null'); // Técnico asignado
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            
            // Notas
            $table->text('observaciones')->nullable();
            $table->text('notas_tecnicas')->nullable();
            
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
