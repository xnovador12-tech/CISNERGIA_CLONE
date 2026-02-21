<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'codigo',
        'slug',
        'nombre',
        'apellidos',
        'razon_social',
        'ruc',
        'dni',
        'email',
        'telefono',
        'celular',
        'direccion',
        'tipo_persona',
        // Campos CRM
        'user_id',
        'prospecto_id',
        'segmento',
        'scoring',
        'valor_tiempo_vida',
        'total_compras',
        'cantidad_compras',
        'ticket_promedio',
        'fecha_primera_compra',
        'fecha_ultima_compra',
        'dias_sin_comprar',
        'estado_rfm',
        'preferencias_comunicacion',
        'horario_contacto_preferido',
        'acepta_marketing',
        'nps_score',
        'fecha_ultimo_nps',
        'vendedor_id',
        'sede_id',
        'distrito_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_primera_compra' => 'date',
        'fecha_ultima_compra' => 'date',
        'fecha_ultimo_nps' => 'date',
        'valor_tiempo_vida' => 'decimal:2',
        'total_compras' => 'decimal:2',
        'ticket_promedio' => 'decimal:2',
        'preferencias_comunicacion' => 'array',
        'acepta_marketing' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cliente) {
            if (empty($cliente->codigo)) {
                $cliente->codigo = self::generarCodigo();
            }
            if (empty($cliente->slug)) {
                $cliente->slug = Str::slug($cliente->nombre . '-' . $cliente->codigo);
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
        $numero = str_pad($ultimo + 1, 5, '0', STR_PAD_LEFT);
        return "CLI-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Nombre completo del cliente
     */
    public function getNombreCompletoAttribute(): string
    {
        if ($this->tipo_persona === 'juridica') {
            return $this->razon_social ?? $this->nombre;
        }
        return trim("{$this->nombre} {$this->apellidos}");
    }

    /**
     * Documento de identidad
     */
    public function getDocumentoAttribute(): string
    {
        return $this->ruc ?? $this->dni ?? '-';
    }

    /**
     * Nombre compatible con vistas (name)
     */
    public function getNameAttribute(): string
    {
        if (!empty($this->nombre) || !empty($this->razon_social)) {
            return $this->nombre_completo;
        }
        
        if ($this->user && $this->user->persona) {
            return $this->user->name;
        }

        return $this->razon_social ?? $this->email ?? 'Cliente #' . $this->id;
    }

    /**
     * Correo compatible con vistas (correo)
     */
    public function getCorreoAttribute(): string
    {
        return $this->email ?? $this->user->email ?? '-';
    }

    // ==================== RELACIONES ====================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function prospecto()
    {
        return $this->belongsTo(Prospecto::class);
    }

    // Relaciones CRM
    public function oportunidades()
    {
        return $this->hasMany(Oportunidad::class);
    }

    public function cotizaciones()
    {
        return $this->hasMany(CotizacionCrm::class);
    }

    public function actividades()
    {
        return $this->morphMany(ActividadCrm::class, 'actividadable');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class);
    }

    public function ventas()
    {
        return $this->hasMany(Sale::class);
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

    public function scopeActivos($query)
    {
        return $query->whereNotNull('fecha_ultima_compra');
    }

    public function scopePorSegmento($query, $segmento)
    {
        return $query->where('segmento', $segmento);
    }

    public function scopeConComprasRecientes($query, $dias = 90)
    {
        return $query->where('fecha_ultima_compra', '>=', now()->subDays($dias));
    }

    public function scopeSinCompras($query, $dias = 180)
    {
        return $query->where('fecha_ultima_compra', '<', now()->subDays($dias));
    }

    public function scopeTopClientes($query, $limite = 10)
    {
        return $query->orderByDesc('valor_tiempo_vida')->limit($limite);
    }

    // ==================== MÉTODOS CRM ====================

    /**
     * Obtener puntos disponibles
     */
    public function getPuntosDisponiblesAttribute(): int
    {
        return $this->puntosFidelizacion?->puntos_disponibles ?? 0;
    }

    /**
     * Obtener nivel de membresía
     */
    public function getNivelMembresiaAttribute(): ?NivelMembresia
    {
        return $this->puntosFidelizacion?->nivel;
    }

    /**
     * Calcular métricas de compra
     */
    public function actualizarMetricasCompra(): void
    {
        $ventas = $this->ventas;
        
        $this->cantidad_compras = $ventas->count();
        $this->total_compras = $ventas->sum('total');
        $this->ticket_promedio = $this->cantidad_compras > 0 
            ? $this->total_compras / $this->cantidad_compras 
            : 0;
        
        $primeraVenta = $ventas->sortBy('created_at')->first();
        $ultimaVenta = $ventas->sortByDesc('created_at')->first();
        
        $this->fecha_primera_compra = $primeraVenta?->created_at?->toDateString();
        $this->fecha_ultima_compra = $ultimaVenta?->created_at?->toDateString();
        
        if ($this->fecha_ultima_compra) {
            $this->dias_sin_comprar = now()->diffInDays($this->fecha_ultima_compra);
        }

        // Calcular estado RFM
        $this->calcularEstadoRfm();
        
        $this->save();
    }

    /**
     * Calcular estado RFM (Recency, Frequency, Monetary)
     */
    protected function calcularEstadoRfm(): void
    {
        // Recencia: días desde última compra
        $recencia = $this->dias_sin_comprar ?? 9999;
        
        // Frecuencia: cantidad de compras
        $frecuencia = $this->cantidad_compras ?? 0;
        
        // Monetario: total comprado
        $monetario = $this->total_compras ?? 0;

        // Clasificación simplificada
        $this->estado_rfm = match(true) {
            $recencia <= 30 && $frecuencia >= 3 && $monetario >= 10000 => 'vip',
            $recencia <= 60 && $frecuencia >= 2 => 'activo',
            $recencia <= 90 => 'regular',
            $recencia <= 180 => 'inactivo',
            default => 'perdido',
        };
    }

    /**
     * Calcular valor de tiempo de vida (LTV)
     */
    public function calcularValorTiempoVida(): float
    {
        if ($this->cantidad_compras < 2 || !$this->fecha_primera_compra) {
            return $this->total_compras ?? 0;
        }

        $mesesComoCliente = $this->fecha_primera_compra->diffInMonths(now());
        
        if ($mesesComoCliente < 1) {
            return $this->total_compras ?? 0;
        }

        $comprasMensuales = $this->cantidad_compras / $mesesComoCliente;
        $vidaEstimadaMeses = 36; // 3 años de vida estimada
        
        $this->valor_tiempo_vida = $this->ticket_promedio * $comprasMensuales * $vidaEstimadaMeses;
        $this->save();

        return $this->valor_tiempo_vida;
    }

    /**
     * Registrar NPS
     */
    public function registrarNps(int $score): void
    {
        $this->nps_score = $score;
        $this->fecha_ultimo_nps = now();
        $this->save();
    }

    /**
     * Verificar si tiene tickets abiertos
     */
    public function tieneTicketsAbiertos(): bool
    {
        return $this->tickets()->abiertos()->exists();
    }

    /**
     * Obtener próximo mantenimiento programado
     */
    public function proximoMantenimiento(): ?Mantenimiento
    {
        return $this->mantenimientos()
                    ->where('estado', 'programado')
                    ->where('fecha_programada', '>=', now())
                    ->orderBy('fecha_programada')
                    ->first();
    }
}
