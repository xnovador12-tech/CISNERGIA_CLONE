<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigReferido extends Model
{
    use HasFactory;

    protected $table = 'config_referidos';

    protected $fillable = [
        'nombre',
        'activo',
        'tipo_recompensa_referente',
        'valor_recompensa_referente',
        'tipo_recompensa_referido',
        'valor_recompensa_referido',
        'monto_minimo_venta',
        'terminos_condiciones',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'valor_recompensa_referente' => 'decimal:2',
        'valor_recompensa_referido' => 'decimal:2',
        'monto_minimo_venta' => 'decimal:2',
    ];

    /**
     * Obtener configuración activa
     */
    public static function getConfig(): ?self
    {
        return self::where('activo', true)->first();
    }

    /**
     * Alias para obtener configuración activa
     */
    public static function getActiva(): ?self
    {
        return self::getConfig();
    }

    /**
     * Calcular recompensa basada en monto de venta
     */
    public function calcularRecompensa(float $montoVenta): float
    {
        if ($montoVenta < $this->monto_minimo_venta) {
            return 0;
        }

        if ($this->tipo_recompensa_referente === 'porcentaje') {
            return $montoVenta * ($this->valor_recompensa_referente / 100);
        }

        return $this->valor_recompensa_referente;
    }
}
