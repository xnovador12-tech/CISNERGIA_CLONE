<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Oportunidad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'oportunidades';

    protected $fillable = [
        'codigo',
        'slug',
        'nombre',
        'prospecto_id',
        'cliente_id',
        'etapa',
        'tipo_proyecto',
        'tipo_oportunidad',
        'tipo_servicio',
        'descripcion_servicio',
        'requiere_visita_tecnica',
        'fecha_visita_programada',
        'resultado_visita',
        'monto_estimado',
        'monto_final',
        'probabilidad',
        'valor_ponderado',
        'descripcion',
        'observaciones',
        'fecha_creacion',
        'fecha_cierre_estimada',
        'fecha_cierre_real',
        'motivo_perdida',
        'detalle_perdida',
        'competidor_ganador',
        'user_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'monto_estimado' => 'decimal:2',
        'monto_final' => 'decimal:2',
        'valor_ponderado' => 'decimal:2',
        'fecha_creacion' => 'date',
        'fecha_cierre_estimada' => 'date',
        'fecha_cierre_real' => 'date',
        'fecha_visita_programada' => 'date',
        'requiere_visita_tecnica' => 'boolean',
    ];

    /**
     * Etapas del pipeline con sus probabilidades por defecto
     */
    public const ETAPAS = [
        'calificacion'      => ['nombre' => 'Calificación', 'probabilidad' => 10, 'color' => 'primary'],
        'evaluacion'        => ['nombre' => 'Evaluación', 'probabilidad' => 25, 'color' => 'info'],
        'propuesta_tecnica' => ['nombre' => 'Propuesta Técnica', 'probabilidad' => 50, 'color' => 'warning'],
        'negociacion'       => ['nombre' => 'Negociación', 'probabilidad' => 80, 'color' => 'secondary'],
        'ganada'            => ['nombre' => 'Ganada', 'probabilidad' => 100, 'color' => 'success'],
        'perdida'           => ['nombre' => 'Perdida', 'probabilidad' => 0, 'color' => 'danger'],
    ];

    /**
     * Boot del modelo (usa booted() de Laravel moderno)
     */
    protected static function booted(): void
    {
        static::creating(function ($oportunidad) {
            // Generar código único
            if (empty($oportunidad->codigo)) {
                $oportunidad->codigo = self::generarCodigo();
            }

            // Generar slug único
            if (empty($oportunidad->slug)) {
                $oportunidad->slug = self::generarSlug($oportunidad->nombre, $oportunidad->codigo);
            }

            // Fecha de creación
            if (empty($oportunidad->fecha_creacion)) {
                $oportunidad->fecha_creacion = now();
            }

            // Auditoría
            if (auth()->check()) {
                $oportunidad->created_by = auth()->id();
            }

            // Calcular valor ponderado
            $oportunidad->calcularValorPonderado();
        });

        static::updating(function ($oportunidad) {
            if (auth()->check()) {
                $oportunidad->updated_by = auth()->id();
            }
            $oportunidad->calcularValorPonderado();
        });
    }

    /**
     * Generar código único (OPO-2026-0001)
     */
    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::withTrashed()->whereYear('created_at', $year)->count();
        $numero = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        $codigo = "OPO-{$year}-{$numero}";

        while (self::withTrashed()->where('codigo', $codigo)->exists()) {
            $ultimo++;
            $numero = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
            $codigo = "OPO-{$year}-{$numero}";
        }

        return $codigo;
    }

    /**
     * Generar slug único
     */
    public static function generarSlug(string $nombre, string $codigo): string
    {
        $baseSlug = Str::slug($nombre . '-' . $codigo);
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
     * Calcular valor ponderado
     */
    public function calcularValorPonderado(): void
    {
        $this->valor_ponderado = ($this->monto_estimado * $this->probabilidad) / 100;
    }

    /**
     * Obtener nombre de la etapa
     */
    public function getNombreEtapaAttribute(): string
    {
        return self::ETAPAS[$this->etapa]['nombre'] ?? $this->etapa;
    }

    /**
     * Obtener color de la etapa
     */
    public function getColorEtapaAttribute(): string
    {
        return self::ETAPAS[$this->etapa]['color'] ?? 'secondary';
    }

    /**
     * Días en el pipeline
     */
    public function getDiasEnPipelineAttribute(): int
    {
        $fechaFin = $this->fecha_cierre_real ?? now();
        return $this->fecha_creacion ? $this->fecha_creacion->diffInDays($fechaFin) : 0;
    }

    // ==================== RELACIONES ====================

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

    public function cotizaciones()
    {
        return $this->hasMany(CotizacionCrm::class);
    }

    public function actividades()
    {
        return $this->morphMany(ActividadCrm::class, 'actividadable');
    }

    public function productosInteres()
    {
        return $this->belongsToMany(Producto::class, 'oportunidad_producto')
                    ->withPivot('cantidad', 'notas')
                    ->withTimestamps();
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==================== SCOPES ====================

    public function scopeActivas($query)
    {
        return $query->whereNotIn('etapa', ['ganada', 'perdida']);
    }

    public function scopeGanadas($query)
    {
        return $query->where('etapa', 'ganada');
    }

    public function scopePerdidas($query)
    {
        return $query->where('etapa', 'perdida');
    }

    public function scopePorEtapa($query, $etapa)
    {
        return $query->where('etapa', $etapa);
    }

    public function scopePorVendedor($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePorTipoProyecto($query, $tipo)
    {
        return $query->where('tipo_proyecto', $tipo);
    }

    public function scopeVencenEsteMes($query)
    {
        return $query->whereMonth('fecha_cierre_estimada', now()->month)
                    ->whereYear('fecha_cierre_estimada', now()->year)
                    ->activas();
    }

    public function scopeDelMes($query, $mes = null, $ano = null)
    {
        $mes = $mes ?? now()->month;
        $ano = $ano ?? now()->year;

        return $query->whereMonth('fecha_creacion', $mes)
                    ->whereYear('fecha_creacion', $ano);
    }

    // ==================== MÉTODOS ====================

    /**
     * Avanzar a la siguiente etapa
     */
    public function avanzarEtapa(): bool
    {
        $etapas = array_keys(self::ETAPAS);
        $indiceActual = array_search($this->etapa, $etapas);

        if ($indiceActual !== false && $indiceActual < count($etapas) - 2) {
            $nuevaEtapa = $etapas[$indiceActual + 1];
            $this->etapa = $nuevaEtapa;
            $this->probabilidad = self::ETAPAS[$nuevaEtapa]['probabilidad'];
            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Marcar como ganada
     */
    public function marcarGanada(?float $montoFinal = null): void
    {
        $this->etapa = 'ganada';
        $this->probabilidad = 100;
        $this->fecha_cierre_real = now();
        $this->monto_final = $montoFinal ?? $this->monto_estimado;
        $this->save();

        if ($this->prospecto && !$this->cliente_id) {
            $cliente = $this->prospecto->convertirACliente();
            $this->cliente_id = $cliente->id;
            $this->save();
        }
    }

    /**
     * Marcar como perdida
     */
    public function marcarPerdida(string $motivo, ?string $detalle = null, ?string $competidor = null): void
    {
        $this->etapa = 'perdida';
        $this->probabilidad = 0;
        $this->fecha_cierre_real = now();
        $this->motivo_perdida = $motivo;
        $this->detalle_perdida = $detalle;
        $this->competidor_ganador = $competidor;
        $this->save();
    }

    /**
     * Obtener valor del pipeline por etapa
     */
    public static function getValorPipeline(): array
    {
        $resultado = [];

        foreach (array_keys(self::ETAPAS) as $etapa) {
            if (!in_array($etapa, ['ganada', 'perdida'])) {
                $oportunidades = self::porEtapa($etapa)->get();
                $resultado[$etapa] = [
                    'cantidad' => $oportunidades->count(),
                    'valor' => $oportunidades->sum('monto_estimado'),
                    'valor_ponderado' => $oportunidades->sum('valor_ponderado'),
                ];
            }
        }

        return $resultado;
    }

    /**
     * Crear cotización desde oportunidad
     */
    public function crearCotizacion(array $datos = []): CotizacionCrm
    {
        $version = $this->cotizaciones()->max('version') ?? 0;

        return $this->cotizaciones()->create(array_merge([
            'prospecto_id' => $this->prospecto_id,
            'cliente_id' => $this->cliente_id,
            'nombre_proyecto' => $this->nombre,
            'version' => $version + 1,
            'fecha_emision' => now(),
            'fecha_vigencia' => now()->addDays(15),
        ], $datos));
    }
}
