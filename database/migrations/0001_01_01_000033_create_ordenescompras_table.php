<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenescomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenescompras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('slug');
            $table->string('fecha');
            $table->string('total');
            $table->string('total_pago');
            $table->string('tipo_moneda')->nullable();
            $table->string('forma_pago')->nullable();
            $table->string('plazo_pago')->nullable();
            $table->string('fecha_pago')->nullable();
            $table->string('estado')->default('Pendiente');
            $table->string('estado_pago')->default('Pendiente');
            $table->string('estado_proceso')->default('Pendiente');
            $table->string('observacion')->nullable();
            $table->string('validar_notify')->default('0');
            $table->string('registrado_por')->nullable();
            $table->foreignId('proveedor_id')->constrained('proveedors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenescompras');
    }
}
