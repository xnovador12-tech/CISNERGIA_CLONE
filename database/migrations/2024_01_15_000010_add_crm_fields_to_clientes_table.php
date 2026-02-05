<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Añade campos del CRM a la tabla clientes existente
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Campos básicos de persona si no existen
            if (!Schema::hasColumn('clientes', 'nombre')) {
                $table->string('nombre')->nullable()->after('id');
            }
            if (!Schema::hasColumn('clientes', 'apellidos')) {
                $table->string('apellidos')->nullable()->after('nombre');
            }
            if (!Schema::hasColumn('clientes', 'razon_social')) {
                $table->string('razon_social')->nullable()->after('apellidos');
            }
            if (!Schema::hasColumn('clientes', 'tipo_persona')) {
                $table->enum('tipo_persona', ['natural', 'juridica'])->default('natural')->after('razon_social');
            }
            if (!Schema::hasColumn('clientes', 'ruc')) {
                $table->string('ruc', 11)->nullable()->after('tipo_persona');
            }
            if (!Schema::hasColumn('clientes', 'dni')) {
                $table->string('dni', 8)->nullable()->after('ruc');
            }
            if (!Schema::hasColumn('clientes', 'email')) {
                $table->string('email')->nullable()->after('dni');
            }
            if (!Schema::hasColumn('clientes', 'telefono')) {
                $table->string('telefono', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('clientes', 'celular')) {
                $table->string('celular', 20)->nullable()->after('telefono');
            }
            if (!Schema::hasColumn('clientes', 'direccion')) {
                $table->string('direccion')->nullable()->after('celular');
            }
            
            // Campos CRM
            if (!Schema::hasColumn('clientes', 'codigo')) {
                $table->string('codigo')->nullable()->after('direccion');
            }
            if (!Schema::hasColumn('clientes', 'slug')) {
                $table->string('slug')->nullable()->after('codigo');
            }
            
            // Origen del cliente (si vino del CRM)
            if (!Schema::hasColumn('clientes', 'prospecto_id')) {
                $table->foreignId('prospecto_id')->nullable()->after('slug')->constrained('prospectos')->onDelete('set null');
            }
            
            // Segmentación
            if (!Schema::hasColumn('clientes', 'segmento')) {
                $table->enum('segmento', ['residencial', 'comercial', 'industrial', 'agricola'])->default('residencial')->after('prospecto_id');
            }
            
            // Clasificación
            if (!Schema::hasColumn('clientes', 'tipo_cliente')) {
                $table->enum('tipo_cliente', ['nuevo', 'recurrente', 'vip', 'corporativo'])->default('nuevo');
            }
            
            // Valor del cliente
            if (!Schema::hasColumn('clientes', 'total_compras')) {
                $table->decimal('total_compras', 14, 2)->default(0);
            }
            if (!Schema::hasColumn('clientes', 'cantidad_compras')) {
                $table->integer('cantidad_compras')->default(0);
            }
            if (!Schema::hasColumn('clientes', 'ticket_promedio')) {
                $table->decimal('ticket_promedio', 12, 2)->default(0);
            }
            
            // Datos del sistema solar instalado
            if (!Schema::hasColumn('clientes', 'potencia_instalada_kw')) {
                $table->decimal('potencia_instalada_kw', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('clientes', 'fecha_instalacion')) {
                $table->date('fecha_instalacion')->nullable();
            }
            if (!Schema::hasColumn('clientes', 'cantidad_proyectos')) {
                $table->integer('cantidad_proyectos')->default(0);
            }
            
            // Fechas importantes
            if (!Schema::hasColumn('clientes', 'fecha_primera_compra')) {
                $table->date('fecha_primera_compra')->nullable();
            }
            if (!Schema::hasColumn('clientes', 'fecha_ultima_compra')) {
                $table->date('fecha_ultima_compra')->nullable();
            }
            if (!Schema::hasColumn('clientes', 'fecha_ultimo_contacto')) {
                $table->date('fecha_ultimo_contacto')->nullable();
            }
            
            // Asignación
            if (!Schema::hasColumn('clientes', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            }
            
            // SoftDeletes
            if (!Schema::hasColumn('clientes', 'deleted_at')) {
                $table->softDeletes();
            }
            
            // Índices
            $table->index('segmento');
            $table->index('tipo_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Eliminar índices
            $table->dropIndex(['segmento']);
            $table->dropIndex(['tipo_cliente']);
            
            // Eliminar columnas añadidas
            $columns = [
                'codigo', 'slug', 'prospecto_id', 'segmento', 'tipo_cliente',
                'total_compras', 'cantidad_compras', 'ticket_promedio',
                'potencia_instalada_kw', 'fecha_instalacion', 'cantidad_proyectos',
                'fecha_primera_compra', 'fecha_ultima_compra', 'fecha_ultimo_contacto',
                'user_id'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('clientes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
