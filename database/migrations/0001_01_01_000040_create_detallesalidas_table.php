<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallesalidas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('producto');
            $table->string('producto_id');
            $table->string('categoria')->nullable();
            $table->string('vida_util')->nullable();
            $table->string('umedida');
            $table->string('cantidad');
            $table->string('tipo_id');
            $table->integer('lote');
            $table->string('areaalmacen_id')->nullable();
            // $table->decimal('stock_venta', 11,2);
            $table->decimal('precio', 11,2)->nullable();
            $table->string('fecha_vencimiento')->nullable();
            // $table->string('area_destino')->nullable();
            $table->unsignedBigInteger('salida_id');

            $table->foreign('salida_id')->references('id')->on('salidas')->onDelete('cascade');
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
        Schema::dropIfExists('detallesalidas');
    }
}
