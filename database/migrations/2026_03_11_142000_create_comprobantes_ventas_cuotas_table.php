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
        Schema::create('comprobantes_ventas_cuotas', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('comprobante_venta_id')->constrained('comprobantes_ventas')->onDelete('cascade');
            $blueprint->integer('numero_cuota');
            $blueprint->decimal('monto', 15, 2);
            $blueprint->date('fecha_vencimiento');
            $blueprint->date('fecha_pago')->nullable();
            $blueprint->string('estado')->default('Pendiente'); // Pendiente, Pagado, Anulado
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes_ventas_cuotas');
    }
};
