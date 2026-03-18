<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_caja', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->enum('tipo', ['ingreso', 'egreso']);
            $blueprint->decimal('monto', 15, 2);
            $blueprint->foreignId('apertura_caja_id')->constrained('apertura_cierres_caja')->onDelete('cascade');
            $blueprint->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $blueprint->date('fecha_movimiento');
            $blueprint->time('hora_movimiento');
            $blueprint->unsignedBigInteger('venta_id')->nullable();
            $blueprint->foreign('venta_id')->references('id')->on('sales')->onDelete('set null');
            $blueprint->unsignedBigInteger('ordencompra_id')->nullable();
            $blueprint->foreign('ordencompra_id')->references('id')->on('ordenescompras')->onDelete('set null');
            $blueprint->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            $blueprint->foreignId('proveedor_id')->nullable()->constrained('proveedors')->onDelete('set null');
            $blueprint->foreignId('metodo_pago_id')->nullable()->constrained('mediopagos')->onDelete('set null');
            $blueprint->foreignId('cuenta_bancaria_id')->nullable()->constrained('cuentas_bancarias')->onDelete('set null');
            $blueprint->string('numero_operacion')->nullable();
            $blueprint->text('descripcion')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_caja');
    }
};
