<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCotizacionCrm extends Model
{
    use HasFactory;

    protected $table = 'detalle_cotizaciones_crm';

    protected $fillable = [
        'cotizacion_id',
        'categoria',
        'codigo_item',
        'descripcion',
        'especificaciones',
        'cantidad',
        'unidad',
        'precio_unitario',
        'descuento_porcentaje',
        'descuento_monto',
        'subtotal',
        'orden',
        'producto_id',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Categorías disponibles
     */
    public const CATEGORIAS = [
        'producto'  => ['nombre' => 'Producto', 'icono' => 'bi-box', 'color' => 'primary'],
        'servicio'  => ['nombre' => 'Servicio', 'icono' => 'bi-gear', 'color' => 'info'],
        'otro'      => ['nombre' => 'Otro', 'icono' => 'bi-three-dots', 'color' => 'secondary'],
    ];

    /**
     * Unidades disponibles
     */
    public const UNIDADES = [
        'und' => 'Unidad',
        'glb' => 'Global',
        'kg' => 'Kilogramo',
        'm' => 'Metro',
        'm2' => 'Metro²',
        'ml' => 'Metro lineal',
        'hrs' => 'Horas',
        'dia' => 'Día',
        'jgo' => 'Juego',
        'par' => 'Par',
        'rollo' => 'Rollo',
    ];

    /**
     * Boot del modelo - Calcula subtotal automáticamente al guardar
     */
    protected static function booted(): void
    {
        static::saving(function ($detalle) {
            $cantidad = (float) ($detalle->cantidad ?? 0);
            $precioUnitario = (float) ($detalle->precio_unitario ?? 0);
            $descuentoPct = (float) ($detalle->descuento_porcentaje ?? 0);

            $bruto = $cantidad * $precioUnitario;

            if ($descuentoPct > 0) {
                $detalle->descuento_monto = round($bruto * ($descuentoPct / 100), 2);
            } else {
                $detalle->descuento_monto = 0;
            }

            $detalle->subtotal = round($bruto - $detalle->descuento_monto, 2);
        });
    }

    // ==================== RELACIONES ====================

    public function cotizacion()
    {
        return $this->belongsTo(CotizacionCrm::class, 'cotizacion_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // ==================== ACCESSORS ====================

    public function getCategoriaInfoAttribute(): array
    {
        return self::CATEGORIAS[$this->categoria] ?? self::CATEGORIAS['otro'];
    }

    public function getNombreUnidadAttribute(): string
    {
        return self::UNIDADES[$this->unidad] ?? $this->unidad;
    }
}
