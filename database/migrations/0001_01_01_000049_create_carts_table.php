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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // Para usuarios invitados
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Para usuarios registrados
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->decimal('descuento', 11, 2)->default(0);
            $table->decimal('igv', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->string('cupon_codigo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
