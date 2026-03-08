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

            // ── Relaciones principales ──
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // ── Clasificación (4 categorías operativas) ──
            $table->string('asunto');
            $table->text('descripcion');
            $table->enum('categoria', [
                'mantenimiento',    // Mantenimiento programado (preventivo/correctivo) → genera Mantenimiento automáticamente
                'soporte_tecnico',  // Falla técnica → puede derivar en Mantenimiento correctivo desde el show
                'garantia',         // Producto defectuoso dentro del período
                'facturacion',      // Cobros, facturas, comprobantes
                'consulta_reclamo', // Consultas generales y reclamos
            ]);

            // Campo libre: componente o detalle específico (solo soporte/garantía)
            $table->string('componente_afectado')->nullable(); // Ej: "Inversor Fronius 5kW", "Panel 400W"

            // ── Datos para categoría mantenimiento (se usan al crear el Mantenimiento automáticamente) ──
            $table->enum('tipo_mantenimiento', ['preventivo','correctivo','limpieza','inspeccion','predictivo'])->nullable();
            $table->date('fecha_mantenimiento')->nullable();
            $table->time('hora_mantenimiento')->nullable();

            // ── Prioridad y SLA ──
            $table->enum('prioridad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->integer('sla_horas')->default(48);
            $table->datetime('sla_vencimiento')->nullable();
            $table->boolean('sla_cumplido')->nullable();

            // ── Estado ──
            $table->enum('estado', [
                'abierto',
                'asignado',
                'en_progreso',
                'pendiente_cliente',
                'pendiente_proveedor',
                'resuelto',
                'reabierto',
            ])->default('abierto');

            // ── Fechas ──
            $table->datetime('fecha_primera_respuesta')->nullable();
            $table->datetime('fecha_resolucion')->nullable();
            $table->datetime('fecha_cierre')->nullable();

            // ── Resolución ──
            $table->text('solucion')->nullable();
            $table->enum('tipo_solucion', [
                'resuelto_remoto',
                'visita_tecnica',
                'cambio_equipo',
                'ajuste_configuracion',
                'garantia_aplicada',
                'derivado_proveedor',
                'otro',
            ])->nullable();

            // ── Referencias (sin FK para evitar conflicto de orden de migraciones) ──
            $table->unsignedBigInteger('pedido_id')->nullable(); // soporte_tecnico + garantia
            $table->unsignedBigInteger('venta_id')->nullable();  // facturacion

            // ── Canal de contacto ──
            $table->enum('canal', ['web', 'email', 'telefono', 'whatsapp', 'presencial'])->default('whatsapp');

            // ── Datos del sistema solar (soporte_tecnico + garantia) ──
            $table->string('direccion_sistema')->nullable();

            // ── Adjuntos ──
            $table->json('adjuntos')->nullable();

            // ── Notas internas ──
            $table->text('notas_internas')->nullable();

            // ── Asignación ──
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // ── Auditoría ──
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // ── Índices ──
            $table->index(['cliente_id', 'estado']);
            $table->index(['estado', 'prioridad']);
            $table->index(['user_id', 'estado']);
            $table->index('sla_vencimiento');
            $table->index('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
