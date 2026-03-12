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
        Schema::create('apertura_cierres_caja', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('codigo');
            $blueprint->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias')->onDelete('cascade');
            $blueprint->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $blueprint->foreignId('moneda_id')->constrained('monedas')->onDelete('cascade');
            $blueprint->date('fecha_apertura');
            $blueprint->time('hora_apertura');
            $blueprint->decimal('saldo_inicial', 15, 2)->default(0);
            $blueprint->decimal('efectivo_inicial', 15, 2)->default(0);
            $blueprint->decimal('total_ingresos', 15, 2)->default(0);
            $blueprint->decimal('total_egresos', 15, 2)->default(0);
            $blueprint->decimal('efectivo_final', 15, 2)->default(0);
            $blueprint->decimal('saldo_cierre', 15, 2)->default(0);
            $blueprint->date('fecha_cierre')->nullable();
            $blueprint->time('hora_cierre')->nullable();
            $blueprint->string('estado')->default('Abierto');
            $blueprint->text('observacion')->nullable();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_cierres_caja');
    }
};
