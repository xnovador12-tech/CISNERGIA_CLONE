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
        'subtotal',
        'descuento_porcentaje',
        'descuento_monto',
        'incluye_igv',
        'igv',
        'total',
        'tiempo_ejecucion_dias',
        'garantia_servicio',
        'fecha_emision',
        'fecha_vigencia',
        'estado',
        'fecha_envio',
        'fecha_respuesta',
        'motivo_rechazo',
        'user_id',
        'condiciones_comerciales',
        'notas_internas',
        'observaciones',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_emision' => 'date',
        'fecha_vigencia' => 'date',
        'fecha_envio' => 'datetime',
        'fecha_respuesta' => 'datetime',
        'incluye_igv' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function booted(): void
    {
        static::creating(function ($cotizacion) {
            if (empty($cotizacion->codigo)) {
                $cotizacion->codigo = self::generarCodigo();
            }
            if (empty($cotizacion->slug)) {
                $cotizacion->slug = self::generarSlug($cotizacion->codigo);
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
     * Generar código único (COT-2026-0001)
     */
    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::withTrashed()->whereYear('created_at', $year)->count();
        $numero = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        $codigo = "COT-{$year}-{$numero}";

        while (self::withTrashed()->where('codigo', $codigo)->exists()) {
            $ultimo++;
            $numero = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
            $codigo = "COT-{$year}-{$numero}";
        }

        return $codigo;
    }

    /**
     * Generar slug único
     */
    public static function generarSlug(string $codigo): string
    {
        $baseSlug = Str::slug($codigo . '-' . Str::random(5));
        $slug = $baseSlug;
        $counter = 1;

        while (self::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Usar slug para rutas
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
        return $this->fecha_vigencia >= now() && !in_array($this->estado, ['rechazada']);
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
                    ->whereNotIn('estado', ['rechazada']);
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
        return $query->where('estado', 'enviada');
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
     * Calcular totales desde los ítems de detalle
     */
    public function calcularTotales(): void
    {
        $subtotalItems = $this->detalles()->sum('subtotal');
        $this->subtotal = $subtotalItems;

        $this->descuento_monto = ($this->subtotal * ($this->descuento_porcentaje ?? 0)) / 100;
        $subtotalConDescuento = $this->subtotal - $this->descuento_monto;
        
        if ($this->incluye_igv) {
            $this->igv = $subtotalConDescuento * 0.18;
        } else {
            $this->igv = 0;
        }
        
        $this->total = $subtotalConDescuento + $this->igv;
        
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
     * Aceptar cotización
     */
    public function aceptar(): void
    {
        $this->estado = 'aceptada';
        $this->fecha_respuesta = now();
        $this->save();

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
        $nueva->slug = self::generarSlug($nueva->codigo);
        $nueva->estado = 'borrador';
        $nueva->fecha_emision = now();
        $nueva->fecha_vigencia = now()->addDays(15);
        $nueva->fecha_envio = null;
        $nueva->fecha_respuesta = null;
        $nueva->motivo_rechazo = null;
        $nueva->save();

        // Duplicar ítems
        foreach ($this->detalles as $detalle) {
            $nuevoDetalle = $detalle->replicate();
            $nuevoDetalle->cotizacion_id = $nueva->id;
            $nuevoDetalle->save();
        }

        return $nueva;
    }
}
