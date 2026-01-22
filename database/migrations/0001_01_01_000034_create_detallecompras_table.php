<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallecomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecompras', function (Blueprint $table) {
            $table->id();
            $table->string('producto');
            $table->string('producto_id');
            $table->string('tipo_producto');
            $table->string('umedida');
            $table->string('cantidad');
            $table->string('cantidadp_ingresar');
            $table->string('precio');
            $table->string('tipo_impuesto_value');
            $table->string('subtotal');
            $table->foreignId('ordencompra_id')->constrained('ordenescompras')->onDelete('cascade');
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
        Schema::dropIfExists('detallecompras');
    }
}
