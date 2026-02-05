<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CotizacionCrm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cotizaciones_crm';

    protected $fillable = [
        'codigo',
        'slug',
        'version',
        'oportunidad_id',
        'prospecto_id',
        'cliente_id',
        'nombre_proyecto',
        'potencia_kw',
        'cantidad_paneles',
        'modelo_panel',
        'marca_panel',
        'potencia_panel_w',
        'modelo_inversor',
        'marca_inversor',
        'potencia_inversor_kw',
        'incluye_baterias',
        'modelo_bateria',
        'marca_bateria',
        'capacidad_baterias_kwh',
        'produccion_diaria_kwh',
        'produccion_mensual_kwh',
        'produccion_anual_kwh',
        'ahorro_mensual_soles',
        'ahorro_anual_soles',
        'ahorro_25_anos_soles',
        'retorno_inversion_anos',
        'tir',
        'van',
        'reduccion_co2_toneladas',
        'precio_equipos',
        'precio_instalacion',
        'precio_tramites',
        'precio_estructura',
        'precio_otros',
        'subtotal',
        'descuento_porcentaje',
        'descuento_monto',
        'igv',
        'total',
        'incluye_financiamiento',
        'entidad_financiera',
        'cuota_mensual',
        'plazo_meses',
        'tea',
        'garantia_paneles_anos',
        'garantia_inversor_anos',
        'garantia_instalacion_anos',
        'garantia_baterias_anos',
        'tiempo_instalacion_dias',
        'fecha_emision',
        'fecha_vigencia',
        'estado',
        'fecha_envio',
        'fecha_vista',
        'fecha_respuesta',
        'motivo_rechazo',
        'user_id',
        'sede_id',
        'condiciones_comerciales',
        'notas_internas',
        'observaciones',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'potencia_kw' => 'decimal:2',
        'potencia_panel_w' => 'decimal:2',
        'potencia_inversor_kw' => 'decimal:2',
        'capacidad_baterias_kwh' => 'decimal:2',
        'produccion_diaria_kwh' => 'decimal:2',
        'produccion_mensual_kwh' => 'decimal:2',
        'produccion_anual_kwh' => 'decimal:2',
        'ahorro_mensual_soles' => 'decimal:2',
        'ahorro_anual_soles' => 'decimal:2',
        'ahorro_25_anos_soles' => 'decimal:2',
        'retorno_inversion_anos' => 'decimal:2',
        'tir' => 'decimal:2',
        'van' => 'decimal:2',
        'reduccion_co2_toneladas' => 'decimal:2',
        'precio_equipos' => 'decimal:2',
        'precio_instalacion' => 'decimal:2',
        'precio_tramites' => 'decimal:2',
        'precio_estructura' => 'decimal:2',
        'precio_otros' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'cuota_mensual' => 'decimal:2',
        'tea' => 'decimal:2',
        'fecha_emision' => 'date',
        'fecha_vigencia' => 'date',
        'fecha_envio' => 'datetime',
        'fecha_vista' => 'datetime',
        'fecha_respuesta' => 'datetime',
        'incluye_baterias' => 'boolean',
        'incluye_financiamiento' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cotizacion) {
            if (empty($cotizacion->codigo)) {
                $cotizacion->codigo = self::generarCodigo();
            }
            if (empty($cotizacion->slug)) {
                $cotizacion->slug = Str::slug($cotizacion->codigo . '-' . Str::random(5));
            }
            if (auth()->check()) {
                $cotizacion->created_by = auth()->id();
            }
        });

        static::updating(function ($cotizacion) {
            if (auth()->check()) {
                $cotizacion->updated_by = auth()->id();
            }
        });
    }

    /**
     * Generar código único
     */
    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::whereYear('created_at', $year)->max('id') ?? 0;
        $numero = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        return "COT-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Verificar si está vigente
     */
    public function getEstaVigenteAttribute(): bool
    {
        return $this->fecha_vigencia >= now() && !in_array($this->estado, ['vencida', 'cancelada', 'rechazada']);
    }

    /**
     * Días para vencer
     */
    public function getDiasParaVencerAttribute(): int
    {
        return now()->diffInDays($this->fecha_vigencia, false);
    }

    // ==================== RELACIONES ====================

    public function oportunidad()
    {
        return $this->belongsTo(Oportunidad::class);
    }

    public function prospecto()
    {
        return $this->belongsTo(Prospecto::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCotizacionCrm::class, 'cotizacion_id')->orderBy('categoria')->orderBy('orden');
    }

    public function detallesPorCategoria()
    {
        return $this->detalles->groupBy('categoria');
    }

    // ==================== SCOPES ====================

    public function scopeVigentes($query)
    {
        return $query->where('fecha_vigencia', '>=', now())
                    ->whereNotIn('estado', ['vencida', 'cancelada', 'rechazada']);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeAceptadas($query)
    {
        return $query->where('estado', 'aceptada');
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['enviada', 'vista', 'en_revision']);
    }

    public function scopeDelMes($query, $mes = null, $ano = null)
    {
        $mes = $mes ?? now()->month;
        $ano = $ano ?? now()->year;
        
        return $query->whereMonth('fecha_emision', $mes)
                    ->whereYear('fecha_emision', $ano);
    }

    // ==================== MÉTODOS ====================

    /**
     * Calcular totales incluyendo detalles
     */
    public function calcularTotales(): void
    {
        // Si hay detalles, calcular desde ellos
        if ($this->detalles()->count() > 0) {
            $totalDetalles = $this->detalles()->sum('subtotal');
            
            // Actualizar precios por categoría
            $this->precio_equipos = $this->detalles()->where('categoria', 'equipo')->sum('subtotal') + 
                                    $this->detalles()->where('categoria', 'material')->sum('subtotal');
            $this->precio_instalacion = $this->detalles()->where('categoria', 'mano_obra')->sum('subtotal');
            $this->precio_tramites = $this->detalles()->where('categoria', 'tramite')->sum('subtotal');
            $this->precio_otros = $this->detalles()->where('categoria', 'servicio')->sum('subtotal') +
                                  $this->detalles()->where('categoria', 'otro')->sum('subtotal');
            
            $this->subtotal = $totalDetalles;
        } else {
            // Cálculo tradicional sin detalles
            $this->subtotal = ($this->precio_equipos ?? 0) + ($this->precio_instalacion ?? 0) + 
                             ($this->precio_tramites ?? 0) + ($this->precio_estructura ?? 0) + 
                             ($this->precio_otros ?? 0);
        }
        
        $this->descuento_monto = ($this->subtotal * ($this->descuento_porcentaje ?? 0)) / 100;
        $subtotalConDescuento = $this->subtotal - $this->descuento_monto;
        $this->igv = $subtotalConDescuento * 0.18;
        $this->total = $subtotalConDescuento + $this->igv;
        
        $this->save();
    }

    /**
     * Calcular producción estimada
     */
    public function calcularProduccion(float $horasSolPico = 5): void
    {
        // Producción diaria = Potencia (kW) x Horas sol pico x Factor de rendimiento (0.8)
        $this->produccion_diaria_kwh = $this->potencia_kw * $horasSolPico * 0.8;
        $this->produccion_mensual_kwh = $this->produccion_diaria_kwh * 30;
        $this->produccion_anual_kwh = $this->produccion_mensual_kwh * 12;
        
        $this->save();
    }

    /**
     * Calcular ahorro estimado
     */
    public function calcularAhorro(float $tarifaKwh = 0.50): void
    {
        $this->ahorro_mensual_soles = $this->produccion_mensual_kwh * $tarifaKwh;
        $this->ahorro_anual_soles = $this->ahorro_mensual_soles * 12;
        $this->ahorro_25_anos_soles = $this->ahorro_anual_soles * 25;
        
        // ROI simple
        if ($this->ahorro_anual_soles > 0) {
            $this->retorno_inversion_anos = $this->total / $this->ahorro_anual_soles;
        }
        
        // Reducción de CO2 (0.5 kg CO2 por kWh aproximadamente)
        $this->reduccion_co2_toneladas = ($this->produccion_anual_kwh * 0.5) / 1000;
        
        $this->save();
    }

    /**
     * Marcar como enviada
     */
    public function marcarEnviada(): void
    {
        $this->estado = 'enviada';
        $this->fecha_envio = now();
        $this->save();
    }

    /**
     * Marcar como vista
     */
    public function marcarVista(): void
    {
        if ($this->estado === 'enviada') {
            $this->estado = 'vista';
            $this->fecha_vista = now();
            $this->save();
        }
    }

    /**
     * Aceptar cotización
     */
    public function aceptar(): void
    {
        $this->estado = 'aceptada';
        $this->fecha_respuesta = now();
        $this->save();

        // Actualizar oportunidad
        if ($this->oportunidad) {
            $this->oportunidad->update([
                'monto_final' => $this->total,
            ]);
        }
    }

    /**
     * Rechazar cotización
     */
    public function rechazar(string $motivo): void
    {
        $this->estado = 'rechazada';
        $this->fecha_respuesta = now();
        $this->motivo_rechazo = $motivo;
        $this->save();
    }

    /**
     * Crear nueva versión
     */
    public function crearNuevaVersion(): self
    {
        $nueva = $this->replicate();
        $nueva->version = $this->version + 1;
        $nueva->codigo = self::generarCodigo();
        $nueva->slug = Str::slug($nueva->codigo . '-' . Str::random(5));
        $nueva->estado = 'borrador';
        $nueva->fecha_emision = now();
        $nueva->fecha_vigencia = now()->addDays(15);
        $nueva->fecha_envio = null;
        $nueva->fecha_vista = null;
        $nueva->fecha_respuesta = null;
        $nueva->motivo_rechazo = null;
        $nueva->save();

        return $nueva;
    }
}
