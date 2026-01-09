<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->string('marca')->nullable();
            $table->string('clasificacion')->nullable();
            $table->string('temperatura_conservacion')->nullable();
            $table->string('imagen')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('vida_util')->nullable();
            $table->string('depreciacion')->nullable();
            $table->string('tipo_adquisicion')->nullable();
            $table->string('costo')->nullable();
            $table->string('estado')->nullable();
            $table->decimal('precio',8,2)->nullable();
            $table->string('tipo_afectacion')->default('0');
            $table->string('registrado_por')->nullable();
            $table->string('sede_id')->nullable();
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipos');
            $table->unsignedBigInteger('medida_id')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->foreign('medida_id')->references('id')->on('medidas');
            $table->foreign('categorie_id')->references('id')->on('categories');
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
        Schema::dropIfExists('productos');
    }
}
