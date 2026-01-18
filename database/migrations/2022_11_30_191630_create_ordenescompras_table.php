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
            $table->string('serie_compra')->nullable();
            $table->string('correlativo_compra')->nullable();
            $table->string('codigo');
            $table->string('slug');
            $table->string('fecha');
            $table->string('codigo_solicitud');
            $table->string('registrado_por_compra');
            $table->string('definicion');
            $table->string('motivo');
            $table->date('fecha_compra');
            $table->string('total');
            $table->string('total_pago');
            $table->string('comprobante')->nullable();
            $table->string('nro_comprobante')->nullable();
            $table->string('forma_pago')->nullable();
            $table->string('plazo_pago')->nullable();
            $table->string('fecha_pago')->nullable();
            $table->string('estado')->default('Pendiente');
            $table->string('estado_pago')->default('Pendiente');
            $table->string('observacion')->nullable();
            $table->string('validar_notify')->default('0');
            $table->unsignedBigInteger('sede_id');
            $table->string('registrado_por')->nullable();
            $table->foreign('sede_id')->references('id')->on('sedes');
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
