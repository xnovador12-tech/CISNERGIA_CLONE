<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleingresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleingresos', function (Blueprint $table) {
            $table->id();
            $table->string('id_producto');
            $table->string('tipo_producto');
            $table->string('producto');
            $table->string('lote');
            $table->string('umedida');
            $table->string('cantidad');
            $table->string('precio');
            $table->foreignId('ingreso_id')->constrained('ingresos')->onDelete('cascade');
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
        Schema::dropIfExists('detalleingresos');
    }
}
