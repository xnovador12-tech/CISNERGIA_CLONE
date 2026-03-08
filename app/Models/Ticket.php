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
        'codigo', 'slug', 'cliente_id',
        'asunto', 'descripcion',
        'categoria', 'componente_afectado',
        'tipo_mantenimiento', 'fecha_mantenimiento', 'hora_mantenimiento',
        'prioridad', 'sla_horas', 'sla_vencimiento', 'sla_cumplido',
        'estado',
        'fecha_primera_respuesta', 'fecha_resolucion', 'fecha_cierre',
        'solucion', 'tipo_solucion',
        'pedido_id', 'venta_id',
        'canal', 'direccion_sistema',
        'adjuntos', 'notas_internas',
        'user_id', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'fecha_primera_respuesta' => 'datetime',
        'fecha_resolucion'        => 'datetime',
        'fecha_cierre'            => 'datetime',
        'sla_vencimiento'         => 'datetime',
        'sla_cumplido'            => 'boolean',
        'adjuntos'                => 'array',
        'fecha_mantenimiento'     => 'date',
    ];

    // ── Constantes ─────────────────────────────────────────────────────────

    public const SLA_POR_PRIORIDAD = [
        'critica' => 4,
        'alta'    => 24,
        'media'   => 48,
        'baja'    => 72,
    ];

    /**
     * 5 categorías operativas.
     * mantenimiento → genera Mantenimiento automáticamente al crear el ticket.
     * soporte_tecnico → puede derivar en Mantenimiento correctivo desde el show.
     */
    public const CATEGORIAS = [
        'mantenimiento'    => 'Mantenimiento',
        'soporte_tecnico'  => 'Soporte Técnico',
        'garantia'         => 'Garantía',
        'facturacion'      => 'Facturación / Cobranza',
        'consulta_reclamo' => 'Consulta / Reclamo',
    ];

    /** Categorías que requieren referencia a pedido + dirección */
    public const CATEGORIAS_CON_PEDIDO = ['soporte_tecnico', 'garantia', 'mantenimiento'];

    /** Categorías que requieren referencia a venta/comprobante */
    public const CATEGORIAS_CON_VENTA = ['facturacion'];

    // ── Accessors ──────────────────────────────────────────────────────────

    public function getCategoriaLabelAttribute(): string
    {
        return self::CATEGORIAS[$this->categoria] ?? ucfirst($this->categoria);
    }

    public function getEsMantenimientoAttribute(): bool
    {
        return $this->categoria === 'mantenimiento';
    }

    public function getEsSoporteAttribute(): bool
    {
        return $this->categoria === 'soporte_tecnico';
    }

    public function getTiempoRestanteSlaAttribute(): string
    {
        if ($this->estado === 'resuelto') return 'Resuelto';
        if (!$this->sla_vencimiento) return '—';

        $diff = now()->diff($this->sla_vencimiento);
        if ($this->sla_vencimiento < now()) {
            return "Vencido hace {$diff->h}h {$diff->i}m";
        }
        return "{$diff->h}h {$diff->i}m restantes";
    }

    public function getEstaVencidoAttribute(): bool
    {
        return $this->estado !== 'resuelto'
            && $this->sla_vencimiento
            && $this->sla_vencimiento < now();
    }

    // ── Boot ───────────────────────────────────────────────────────────────

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
            if (empty($ticket->sla_horas)) {
                $ticket->sla_horas = self::SLA_POR_PRIORIDAD[$ticket->prioridad] ?? 48;
            }
            $ticket->sla_vencimiento = now()->addHours($ticket->sla_horas);

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

    public static function generarCodigo(): string
    {
        $year   = date('Y');
        $ultimo = self::withTrashed()->whereYear('created_at', $year)->count();
        return 'TK-' . $year . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ── Relaciones ─────────────────────────────────────────────────────────

    public function cliente()    { return $this->belongsTo(Cliente::class); }
    public function pedido()     { return $this->belongsTo(Pedido::class); }
    public function venta()      { return $this->belongsTo(Sale::class, 'venta_id'); }
    public function actividades(){ return $this->morphMany(ActividadCrm::class, 'actividadable'); }
    public function mantenimiento(){ return $this->hasOne(Mantenimiento::class); }
    public function asignado()   { return $this->belongsTo(User::class, 'user_id'); }
    public function creador()    { return $this->belongsTo(User::class, 'created_by'); }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeAbiertos($q)          { return $q->whereNotIn('estado', ['resuelto']); }
    public function scopeCerrados($q)          { return $q->where('estado', 'resuelto'); }
    public function scopePorEstado($q, $e)     { return $q->where('estado', $e); }
    public function scopePorPrioridad($q, $p)  { return $q->where('prioridad', $p); }
    public function scopePorAgente($q, $uid)   { return $q->where('user_id', $uid); }
    public function scopeVencidos($q)          { return $q->abiertos()->where('sla_vencimiento', '<', now()); }
    public function scopeDeHoy($q)             { return $q->whereDate('created_at', today()); }

    // ── Métodos de negocio ─────────────────────────────────────────────────

    public function asignar(int $userId): void
    {
        $this->user_id = $userId;
        $this->estado  = 'asignado';
        $this->save();
    }

    public function iniciar(): void
    {
        $this->estado = 'en_progreso';
        if (!$this->fecha_primera_respuesta) {
            $this->fecha_primera_respuesta = now();
        }
        $this->save();
    }

    public function resolver(string $solucion, string $tipoSolucion): void
    {
        $this->estado           = 'resuelto';
        $this->solucion         = $solucion;
        $this->tipo_solucion    = $tipoSolucion;
        $this->fecha_resolucion = now();
        $this->sla_cumplido     = $this->sla_vencimiento ? now()->lte($this->sla_vencimiento) : null;
        $this->save();
    }

    public function reabrir(): void
    {
        $this->estado           = 'reabierto';
        $this->sla_vencimiento  = now()->addHours($this->sla_horas);
        $this->sla_cumplido     = null;
        $this->fecha_resolucion = null;
        $this->fecha_cierre     = null;
        $this->save();
    }
}
