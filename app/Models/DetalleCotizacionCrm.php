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
        'equipo' => ['nombre' => 'Equipo', 'icono' => 'bi-box', 'color' => 'primary'],
        'mano_obra' => ['nombre' => 'Mano de Obra', 'icono' => 'bi-tools', 'color' => 'warning'],
        'servicio' => ['nombre' => 'Servicio', 'icono' => 'bi-gear', 'color' => 'info'],
        'material' => ['nombre' => 'Material', 'icono' => 'bi-bricks', 'color' => 'secondary'],
        'tramite' => ['nombre' => 'Trámite', 'icono' => 'bi-file-earmark-text', 'color' => 'success'],
        'otro' => ['nombre' => 'Otro', 'icono' => 'bi-three-dots', 'color' => 'dark'],
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
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detalle) {
            // Calcular descuento en monto
            if ($detalle->descuento_porcentaje > 0) {
                $detalle->descuento_monto = ($detalle->cantidad * $detalle->precio_unitario) * ($detalle->descuento_porcentaje / 100);
            }
            
            // Calcular subtotal
            $detalle->subtotal = ($detalle->cantidad * $detalle->precio_unitario) - $detalle->descuento_monto;
        });
    }

    /**
     * Relación con cotización
     */
    public function cotizacion()
    {
        return $this->belongsTo(CotizacionCrm::class, 'cotizacion_id');
    }

    /**
     * Relación con producto (opcional)
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Obtener info de la categoría
     */
    public function getCategoriaInfoAttribute(): array
    {
        return self::CATEGORIAS[$this->categoria] ?? self::CATEGORIAS['otro'];
    }

    /**
     * Obtener nombre de unidad
     */
    public function getNombreUnidadAttribute(): string
    {
        return self::UNIDADES[$this->unidad] ?? $this->unidad;
    }
}
