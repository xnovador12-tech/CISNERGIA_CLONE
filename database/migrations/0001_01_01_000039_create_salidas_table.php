<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('slug');
            $table->string('motivo');
            $table->date('fecha');
            $table->string('descripcion')->nullable();
            $table->string('codigo_venta')->nullable();
            $table->decimal('total_producto', 11,2);
            $table->string('registrado_por')->nullable();
            $table->string('precio')->nullable();
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
        Schema::dropIfExists('salidas');
    }
}
