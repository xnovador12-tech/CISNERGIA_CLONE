<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();

            // Relaciones
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // Clasificación
            $table->string('asunto');
            $table->text('descripcion');
            $table->enum('categoria', [
                'soporte_paneles',
                'soporte_inversores',
                'soporte_baterias',
                'soporte_monitoreo',
                'soporte_estructura',
                'mantenimiento',
                'instalacion',
                'garantia',
                'facturacion',
                'consulta',
                'reclamo',
                'otro'
            ]);

            // Prioridad y SLA
            $table->enum('prioridad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->integer('sla_horas')->default(48);
            $table->datetime('sla_vencimiento')->nullable();
            $table->boolean('sla_cumplido')->nullable();

            // Estado
            $table->enum('estado', [
                'abierto',
                'asignado',
                'en_progreso',
                'pendiente_cliente',
                'pendiente_proveedor',
                'resuelto',
                'cerrado',
                'reabierto'
            ])->default('abierto');

            // Fechas
            $table->datetime('fecha_primera_respuesta')->nullable();
            $table->datetime('fecha_resolucion')->nullable();
            $table->datetime('fecha_cierre')->nullable();

            // Resolución
            $table->text('solucion')->nullable();
            $table->enum('tipo_solucion', [
                'resuelto_remoto',
                'visita_tecnica',
                'cambio_equipo',
                'ajuste_configuracion',
                'capacitacion',
                'sin_solucion',
                'otro'
            ])->nullable();

            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Canal de entrada
            $table->enum('canal', ['web', 'email', 'telefono', 'whatsapp', 'presencial'])->default('web');

            // Notas internas
            $table->text('notas_internas')->nullable();

            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['cliente_id', 'estado']);
            $table->index(['estado', 'prioridad']);
            $table->index(['user_id', 'estado']);
            $table->index('sla_vencimiento');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
