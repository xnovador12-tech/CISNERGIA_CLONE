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
            $table->string('peso')->nullable();
            $table->string('imagen')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('vida_util')->nullable();
            $table->string('depreciacion')->nullable();
            $table->string('tipo_adquisicion')->nullable();
            $table->string('costo')->nullable();
            $table->string('estado')->nullable();
            $table->decimal('precio',8,2)->nullable();
            $table->decimal('precio_descuento',8,2)->nullable();
            $table->integer('porcentaje')->default(0);
            $table->string('tipo_afectacion')->default('0');
            $table->string('registrado_por')->nullable();
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->foreignId('medida_id')->constrained('medidas');
            $table->foreignId('marca_id')->constrained('marcas');
            $table->foreignId('categorie_id')->constrained('categories');
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
        Schema::dropIfExists('productos');
    }
}
