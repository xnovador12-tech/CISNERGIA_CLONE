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
        Schema::create('cuentas_bancarias', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('banco_id')->constrained('bancos')->onDelete('cascade');
            $blueprint->string('numero_cuenta');
            $blueprint->foreignId('tipocuenta_id')->constrained('tipocuentas')->onDelete('cascade');
            $blueprint->foreignId('moneda_id')->constrained('monedas')->onDelete('cascade');
            $blueprint->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('cascade');
            $blueprint->string('titular');
            $blueprint->decimal('saldo_inicial', 15, 2)->default(0);
            $blueprint->decimal('saldo_actual', 15, 2)->default(0);
            $blueprint->string('cci')->nullable();
            $blueprint->string('descripcion')->nullable();
            $blueprint->boolean('estado')->default(true);
            $blueprint->boolean('cuenta_principal')->default(false);
            $blueprint->date('fecha_apertura');
            $blueprint->date('fecha_cierre')->nullable();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_bancarias');
    }
};
