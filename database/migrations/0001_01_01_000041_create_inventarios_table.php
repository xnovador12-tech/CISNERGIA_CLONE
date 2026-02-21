<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('id_producto');
            $table->string('tipo_producto');
            $table->string('producto');
            $table->string('lote');
            $table->string('umedida');
            $table->string('cantidad');
            $table->string('precio');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->foreignId('almacen_id')->constrained('almacenes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
