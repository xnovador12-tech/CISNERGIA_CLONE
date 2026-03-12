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
        Schema::create('comprobantes_ventas', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $blueprint->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $blueprint->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $blueprint->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');
            
            $blueprint->foreignId('tipo_comprobante_id')->constrained('tipos_comprobantes')->onDelete('cascade');
            $blueprint->foreignId('tipo_operacion_id')->constrained('tipos_operaciones')->onDelete('cascade');
            $blueprint->foreignId('serie_id')->constrained('series')->onDelete('cascade');
            
            $blueprint->foreignId('moneda_id')->constrained('monedas')->onDelete('cascade');
            $blueprint->foreignId('metodo_pago_id')->nullable()->constrained('mediopagos')->onDelete('set null');
            $blueprint->foreignId('cuenta_bancaria_id')->nullable()->constrained('cuentas_bancarias')->onDelete('set null');
            
            $blueprint->string('numero_comprobante');
            $blueprint->date('fecha_emision');
            $blueprint->date('fecha_vencimiento')->nullable();
            
            $blueprint->decimal('subtotal', 15, 2)->default(0);
            $blueprint->decimal('igv', 15, 2)->default(0);
            $blueprint->decimal('descuento_global', 15, 2)->default(0);
            $blueprint->decimal('total', 15, 2)->default(0);
            
            $blueprint->string('tipo_pago')->default('Contado'); // Contado, Crédito
            $blueprint->integer('numero_cuotas')->default(0);
            
            $blueprint->string('estado')->default('Emitido');
            $blueprint->foreignId('ingreso_financiero_id')->nullable()->constrained('ingresos_financieros')->onDelete('set null');
            $blueprint->text('observaciones')->nullable();
            
            // SUNAT Fields
            $blueprint->string('estado_sunat')->nullable();
            $blueprint->text('mensaje_sunat')->nullable();
            $blueprint->string('nombre_xml_sunat')->nullable();
            
            // Referencias (NC/ND)
            $blueprint->foreignId('venta_referencia_id')->nullable()->constrained('comprobantes_ventas')->onDelete('set null');
            $blueprint->foreignId('tipo_nota_credito_id')->nullable()->constrained('tipo_nota_credito')->onDelete('set null');
            $blueprint->foreignId('tipo_nota_debito_id')->nullable()->constrained('tipo_nota_debito')->onDelete('set null');
            
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes_ventas');
    }
};
