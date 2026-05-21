<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('detail_discounts');
        Schema::dropIfExists('discounts');
    }

    public function down(): void
    {
        // No revertimos: código fuente eliminado en Bloque 4 del plan Opción C.
    }
};
