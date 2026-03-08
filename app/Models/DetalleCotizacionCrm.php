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
        'servicio_id',
        'tiempo_ejecucion_dias',
    ];

    // Guardamos 6 decimales en BD; se muestran 2 al usuario.
    // Los casts evitan que Eloquent corte decimales al asignar.
    protected $casts = [
        'cantidad'             => 'decimal:4',
        'precio_unitario'      => 'decimal:6',
        'descuento_porcentaje' => 'decimal:4',
        'descuento_monto'      => 'decimal:6',
        'subtotal'             => 'decimal:6',
    ];

    /**
     * Categorías disponibles
     */
    public const CATEGORIAS = [
        'producto'  => ['nombre' => 'Producto', 'icono' => 'bi-box',       'color' => 'primary'],
        'servicio'  => ['nombre' => 'Servicio', 'icono' => 'bi-gear',      'color' => 'info'],
        'otro'      => ['nombre' => 'Otro',     'icono' => 'bi-three-dots','color' => 'secondary'],
    ];

    /**
     * Unidades disponibles
     */
    public const UNIDADES = [
        'und'   => 'Unidad',
        'glb'   => 'Global',
        'kg'    => 'Kilogramo',
        'm'     => 'Metro',
        'm2'    => 'Metro²',
        'ml'    => 'Metro lineal',
        'hrs'   => 'Horas',
        'dia'   => 'Día',
        'jgo'   => 'Juego',
        'par'   => 'Par',
        'rollo' => 'Rollo',
    ];

    /**
     * Boot — calcula subtotal con bcmath para no perder céntimos.
     *
     * Escala de trabajo: 6 decimales en toda la cadena.
     * Se almacenan 6 decimales en BD; sólo se redondean a 2 al presentar en pantalla.
     */
    protected static function booted(): void
    {
        static::saving(function (self $detalle) {
            $scale = 6;

            $cantidad       = number_format((float)($detalle->cantidad       ?? 0), $scale, '.', '');
            $precioUnitario = number_format((float)($detalle->precio_unitario ?? 0), $scale, '.', '');
            $descuentoPct   = number_format((float)($detalle->descuento_porcentaje ?? 0), $scale, '.', '');

            // bruto = cantidad × precio_unitario
            $bruto = bcmul($cantidad, $precioUnitario, $scale);

            // descuento_monto = bruto × (pct / 100)
            if (bccomp($descuentoPct, '0', $scale) > 0) {
                $factorDto              = bcdiv($descuentoPct, '100', $scale);
                $detalle->descuento_monto = bcmul($bruto, $factorDto, $scale);
            } else {
                $detalle->descuento_monto = '0.000000';
            }

            // subtotal = bruto - descuento_monto
            $detalle->subtotal = bcsub($bruto, $detalle->descuento_monto, $scale);
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

    public function servicio()
    {
        return $this->belongsTo(\App\Models\Servicio::class);
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

    /**
     * Retorna subtotal formateado a 2 decimales para mostrar en pantalla.
     * NUNCA usar este valor en nuevos cálculos — usar $this->subtotal directamente.
     */
    public function getSubtotalDisplayAttribute(): string
    {
        return number_format((float)$this->subtotal, 2, '.', ',');
    }
}
