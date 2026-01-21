<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenservicios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('slug');
            $table->string('motivo');
            $table->date('fecha');
            $table->string('cliente_id')->nullable();
            $table->string('cliente')->nullable();
            $table->string('codigo_venta')->nullable();
            $table->string('formapago');
            $table->string('plazo_pago');
            $table->string('total');
            $table->string('nota')->nullable();
            $table->string('estado')->default('Pendiente');
            $table->string('registrado_por');
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
        Schema::dropIfExists('ordenservicios');
    }
}
