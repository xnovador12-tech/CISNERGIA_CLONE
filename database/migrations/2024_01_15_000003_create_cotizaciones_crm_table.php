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
        Schema::create('cotizaciones_crm', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // COT-2024-001
            $table->string('slug')->unique();
            $table->integer('version')->default(1); // Para versiones de la misma cotización
            
            // Relaciones
            $table->foreignId('oportunidad_id')->constrained('oportunidades')->onDelete('cascade');
            $table->foreignId('prospecto_id')->constrained('prospectos')->onDelete('cascade');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            
            // Datos del sistema solar cotizado
            $table->string('nombre_proyecto');
            $table->decimal('potencia_kw', 10, 2);
            $table->integer('cantidad_paneles');
            $table->string('modelo_panel')->nullable();
            $table->string('marca_panel')->nullable();
            $table->decimal('potencia_panel_w', 8, 2)->nullable(); // Watts por panel
            $table->string('modelo_inversor')->nullable();
            $table->string('marca_inversor')->nullable();
            $table->decimal('potencia_inversor_kw', 10, 2)->nullable();
            
            // Sistema de almacenamiento (opcional)
            $table->boolean('incluye_baterias')->default(false);
            $table->string('modelo_bateria')->nullable();
            $table->string('marca_bateria')->nullable();
            $table->decimal('capacidad_baterias_kwh', 10, 2)->nullable();
            
            // Producción y ahorro estimado
            $table->decimal('produccion_diaria_kwh', 10, 2)->nullable();
            $table->decimal('produccion_mensual_kwh', 12, 2)->nullable();
            $table->decimal('produccion_anual_kwh', 12, 2)->nullable();
            $table->decimal('ahorro_mensual_soles', 12, 2)->nullable();
            $table->decimal('ahorro_anual_soles', 12, 2)->nullable();
            $table->decimal('ahorro_25_anos_soles', 14, 2)->nullable();
            
            // Análisis financiero
            $table->decimal('retorno_inversion_anos', 5, 2)->nullable();
            $table->decimal('tir', 5, 2)->nullable(); // Tasa Interna de Retorno %
            $table->decimal('van', 14, 2)->nullable(); // Valor Actual Neto
            $table->decimal('reduccion_co2_toneladas', 10, 2)->nullable(); // Impacto ambiental
            
            // Precios
            $table->decimal('precio_equipos', 12, 2)->default(0);
            $table->decimal('precio_instalacion', 12, 2)->default(0);
            $table->decimal('precio_tramites', 12, 2)->default(0); // Trámites con distribuidora
            $table->decimal('precio_estructura', 12, 2)->default(0);
            $table->decimal('precio_otros', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 12, 2)->default(0);
            $table->decimal('igv', 12, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            
            // Financiamiento
            $table->boolean('incluye_financiamiento')->default(false);
            $table->string('entidad_financiera')->nullable();
            $table->decimal('cuota_mensual', 12, 2)->nullable();
            $table->integer('plazo_meses')->nullable();
            $table->decimal('tea', 5, 2)->nullable(); // Tasa Efectiva Anual
            
            // Garantías
            $table->integer('garantia_paneles_anos')->default(25);
            $table->integer('garantia_inversor_anos')->default(10);
            $table->integer('garantia_instalacion_anos')->default(5);
            $table->integer('garantia_baterias_anos')->nullable();
            
            // Plazos
            $table->integer('tiempo_instalacion_dias')->default(5);
            $table->date('fecha_emision');
            $table->date('fecha_vigencia'); // Hasta cuándo es válida
            
            // Estado
            $table->enum('estado', [
                'borrador',
                'enviada',
                'vista',
                'en_revision',
                'aceptada',
                'rechazada',
                'vencida',
                'cancelada'
            ])->default('borrador');
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_vista')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->text('motivo_rechazo')->nullable();
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            
            // Notas
            $table->text('condiciones_comerciales')->nullable();
            $table->text('notas_internas')->nullable();
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['oportunidad_id', 'version']);
            $table->index(['estado', 'fecha_vigencia']);
            $table->index('fecha_emision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones_crm');
    }
};
