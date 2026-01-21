<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleoserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleoservicios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_servicio');
            $table->string('codigo_servicio');
            $table->string('servicio');
            $table->string('precio');
            $table->string('tiempo_meses');
            $table->string('vigencia');
            $table->string('estado')->default('Activo');
            $table->foreignId('ordenservicio_id')->constrained('ordenservicios')->onDelete('cascade');
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
        Schema::dropIfExists('detalleoservicios');
    }
}
