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
        Schema::create('proveedor_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_cuenta_normal')->nullable();
            $table->string('entidad_bancaria_normal')->nullable();
            $table->string('nro_cuenta_normal')->nullable();
            $table->string('nro_cci_normal')->nullable();
            $table->foreignId('proveedor_id')->constrained('proveedors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_cuentas');
    }
};
