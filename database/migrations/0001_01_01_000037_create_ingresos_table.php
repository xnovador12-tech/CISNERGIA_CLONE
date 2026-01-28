<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('slug');
            $table->string('motivo');
            $table->string('fecha');
            $table->string('codigo_ocompra')->nullable();
            $table->string('codigo_venta')->nullable();
            $table->string('guia_remision')->nullable();
            $table->string('total_mat')->default(0);
            $table->string('total_act')->default(0);
            $table->string('total_pte')->default(0);
            $table->string('total')->default(0);
            $table->string('descripcion')->nullable();
            $table->string('registrado_por');
            $table->foreignId('almacen_id')->constrained('almacenes');
            $table->foreignId('sede_id')->constrained('sedes');
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
        Schema::dropIfExists('ingresos');
    }
}
