<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'codigo',
        'slug',
        'cliente_id',
        'venta_id',
        'asunto',
        'descripcion',
        'tipo',
        'categoria',
        'prioridad',
        'sla_horas',
        'sla_vencimiento',
        'sla_cumplido',
        'estado',
        'fecha_apertura',
        'fecha_primera_respuesta',
        'fecha_resolucion',
        'fecha_cierre',
        'solucion',
        'tipo_solucion',
        'calificacion_cliente',
        'comentario_cliente',
        'user_id',
        'tecnico_id',
        'sede_id',
        'canal',
        'notas_internas',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_primera_respuesta' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'fecha_cierre' => 'datetime',
        'sla_vencimiento' => 'datetime',
        'sla_cumplido' => 'boolean',
    ];

    /**
     * SLA por prioridad (en horas)
     */
    public const SLA_POR_PRIORIDAD = [
        'critica' => 4,
        'alta' => 24,
        'media' => 48,
        'baja' => 72,
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->codigo)) {
                $ticket->codigo = self::generarCodigo();
            }
            if (empty($ticket->slug)) {
                $ticket->slug = Str::slug($ticket->codigo . '-' . Str::random(5));
            }
            if (empty($ticket->fecha_apertura)) {
                $ticket->fecha_apertura = now();
            }
            if (empty($ticket->sla_horas)) {
                $ticket->sla_horas = self::SLA_POR_PRIORIDAD[$ticket->prioridad] ?? 48;
            }
            $ticket->sla_vencimiento = $ticket->fecha_apertura->addHours($ticket->sla_horas);
            
            if (auth()->check()) {
                $ticket->created_by = auth()->id();
            }
        });

        static::updating(function ($ticket) {
            if (auth()->check()) {
                $ticket->updated_by = auth()->id();
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
        return "TK-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Tiempo restante para SLA
     */
    public function getTiempoRestanteSlaAttribute(): string
    {
        if (in_array($this->estado, ['resuelto', 'cerrado'])) {
            return 'Cerrado';
        }
        
        $diff = now()->diff($this->sla_vencimiento);
        
        if ($this->sla_vencimiento < now()) {
            return "Vencido hace {$diff->h}h {$diff->i}m";
        }
        
        return "{$diff->h}h {$diff->i}m restantes";
    }

    /**
     * Verificar si está vencido
     */
    public function getEstaVencidoAttribute(): bool
    {
        return !in_array($this->estado, ['resuelto', 'cerrado']) && $this->sla_vencimiento < now();
    }

    // ==================== RELACIONES ====================

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function venta()
    {
        return $this->belongsTo(Sale::class, 'venta_id');
    }

    public function agente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function mensajes()
    {
        return $this->hasMany(TicketMensaje::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==================== SCOPES ====================

    public function scopeAbiertos($query)
    {
        return $query->whereNotIn('estado', ['cerrado', 'resuelto']);
    }

    public function scopeCerrados($query)
    {
        return $query->whereIn('estado', ['cerrado', 'resuelto']);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopePorAgente($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeVencidos($query)
    {
        return $query->abiertos()
                    ->where('sla_vencimiento', '<', now());
    }

    public function scopeVencidosSla($query)
    {
        return $query->abiertos()
                    ->where('sla_vencimiento', '<', now());
    }

    public function scopePorVencer($query, $horas = 4)
    {
        return $query->abiertos()
                    ->whereBetween('sla_vencimiento', [now(), now()->addHours($horas)]);
    }

    public function scopeDeHoy($query)
    {
        return $query->whereDate('fecha_apertura', today());
    }

    // ==================== MÉTODOS ====================

    /**
     * Asignar agente
     */
    public function asignar(int $userId): void
    {
        $this->user_id = $userId;
        $this->estado = 'asignado';
        $this->save();
    }

    /**
     * Iniciar trabajo
     */
    public function iniciar(): void
    {
        $this->estado = 'en_progreso';
        if (!$this->fecha_primera_respuesta) {
            $this->fecha_primera_respuesta = now();
        }
        $this->save();
    }

    /**
     * Resolver ticket
     */
    public function resolver(string $solucion, string $tipoSolucion): void
    {
        $this->estado = 'resuelto';
        $this->solucion = $solucion;
        $this->tipo_solucion = $tipoSolucion;
        $this->fecha_resolucion = now();
        $this->sla_cumplido = $this->fecha_resolucion <= $this->sla_vencimiento;
        $this->save();
    }

    /**
     * Cerrar ticket
     */
    public function cerrar(?int $calificacion = null, ?string $comentario = null): void
    {
        $this->estado = 'cerrado';
        $this->fecha_cierre = now();
        if ($calificacion) {
            $this->calificacion_cliente = $calificacion;
            $this->comentario_cliente = $comentario;
        }
        $this->save();
    }

    /**
     * Reabrir ticket
     */
    public function reabrir(): void
    {
        $this->estado = 'reabierto';
        // Recalcular SLA
        $this->sla_vencimiento = now()->addHours($this->sla_horas);
        $this->sla_cumplido = null;
        $this->fecha_resolucion = null;
        $this->fecha_cierre = null;
        $this->save();
    }

    /**
     * Agregar mensaje
     */
    public function agregarMensaje(string $mensaje, string $tipo = 'respuesta', bool $esCliente = false): TicketMensaje
    {
        return $this->mensajes()->create([
            'mensaje' => $mensaje,
            'tipo' => $tipo,
            'es_cliente' => $esCliente,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Calcular métricas de SLA
     */
    public static function calcularMetricasSla(): array
    {
        $total = self::cerrados()->count();
        $cumplidos = self::cerrados()->where('sla_cumplido', true)->count();
        
        return [
            'total_cerrados' => $total,
            'sla_cumplido' => $cumplidos,
            'porcentaje_cumplimiento' => $total > 0 ? round(($cumplidos / $total) * 100, 1) : 0,
        ];
    }
}
