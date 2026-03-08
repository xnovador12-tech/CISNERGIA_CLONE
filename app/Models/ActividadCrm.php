<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ActividadCrm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actividades_crm';

    protected $fillable = [
        'codigo',
        'slug',
        'tipo',
        'actividadable_id',
        'actividadable_type',
        'titulo',
        'descripcion',
        'resultado',
        'fecha_programada',
        'fecha_realizada',
        'ubicacion',
        'estado',
        'motivo_cancelacion',
        'prioridad',
        'recordatorio_activo',
        'recordatorio_minutos_antes',
        'user_id',
        'created_by',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_realizada' => 'datetime',
        'recordatorio_activo' => 'boolean',
    ];

    /**
     * Tipos de actividad con iconos
     */
    public const TIPOS = [
        'llamada'        => ['nombre' => 'Llamada',         'icono' => 'bi-telephone',   'color' => 'primary'],
        'email'          => ['nombre' => 'Email',           'icono' => 'bi-envelope',    'color' => 'info'],
        'reunion'        => ['nombre' => 'Reunión',         'icono' => 'bi-people',      'color' => 'success'],
        'visita_tecnica' => ['nombre' => 'Visita Técnica',  'icono' => 'bi-house-gear',  'color' => 'warning'],
        'whatsapp'       => ['nombre' => 'WhatsApp',        'icono' => 'bi-whatsapp',    'color' => 'success'],
        'seguimiento'    => ['nombre' => 'Seguimiento',     'icono' => 'bi-arrow-repeat', 'color' => 'secondary'],
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($actividad) {
            if (empty($actividad->codigo)) {
                $actividad->codigo = self::generarCodigo();
            }
            if (empty($actividad->slug)) {
                $actividad->slug = Str::slug($actividad->titulo . '-' . $actividad->codigo);
            }
            if (empty($actividad->created_by) && auth()->check()) {
                $actividad->created_by = auth()->id();
            }
        });
    }

    /**
     * Generar código único
     */
    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::withTrashed()->whereYear('created_at', $year)->count();
        $numero = str_pad($ultimo + 1, 5, '0', STR_PAD_LEFT);
        return "ACT-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Obtener info del tipo
     */
    public function getTipoInfoAttribute(): array
    {
        return self::TIPOS[$this->tipo] ?? ['nombre' => ucfirst($this->tipo), 'icono' => 'bi-calendar', 'color' => 'secondary'];
    }

    /**
     * Accessor para recordatorio_minutos (alias de recordatorio_minutos_antes)
     */
    public function getRecordatorioMinutosAttribute()
    {
        return $this->recordatorio_minutos_antes;
    }

    /**
     * Verificar si está vencida
     */
    public function getEstaVencidaAttribute(): bool
    {
        return $this->estado === 'programada' && $this->fecha_programada < now();
    }

    /**
     * Teléfono de contacto (se obtiene del prospecto/oportunidad/cliente vinculado)
     */
    public function getTelefonoContactoAttribute(): ?string
    {
        $entidad = $this->actividadable;

        if (!$entidad) {
            return null;
        }

        return $entidad->celular ?? $entidad->telefono ?? null;
    }

    /**
     * Email de contacto (se obtiene del prospecto/oportunidad/cliente vinculado)
     */
    public function getEmailContactoAttribute(): ?string
    {
        $entidad = $this->actividadable;

        if (!$entidad) {
            return null;
        }

        // Oportunidad no tiene email directo, se obtiene del prospecto
        if ($entidad instanceof Oportunidad) {
            return $entidad->prospecto?->email;
        }

        return $entidad->email ?? null;
    }

    // ==================== RELACIONES ====================

    /**
     * Relación polimórfica (prospecto, oportunidad, cliente)
     */
    public function actividadable()
    {
        return $this->morphTo('actividadable');
    }

    /**
     * Alias para actividadable
     */
    public function activable()
    {
        return $this->morphTo('actividadable');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asignadoA()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==================== SCOPES ====================

    public function scopeProgramadas($query)
    {
        return $query->where('estado', 'programada');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'programada')
                    ->where('fecha_programada', '>=', now());
    }

    public function scopeVencidas($query)
    {
        return $query->where('estado', 'programada')
                    ->where('fecha_programada', '<', now());
    }

    public function scopeDeHoy($query)
    {
        return $query->whereDate('fecha_programada', today());
    }

    public function scopeProgramadasHoy($query)
    {
        return $query->where('estado', 'programada')
                    ->whereDate('fecha_programada', today());
    }

    public function scopeCompletadasEstaSemana($query)
    {
        return $query->where('estado', 'completada')
                    ->whereBetween('fecha_realizada', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
    }

    public function scopeDeSemana($query)
    {
        return $query->whereBetween('fecha_programada', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorResponsable($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    // ==================== MÉTODOS ====================

    /**
     * Iniciar evaluación (solo visita_tecnica: programada → en_evaluacion)
     * Dispara el cambio de etapa en la oportunidad vinculada
     */
    public function iniciarEvaluacion(): void
    {
        $this->estado = 'en_evaluacion';
        $this->save();

        // Si está vinculada a una oportunidad, avanzar a evaluacion
        if ($this->actividadable_type === \App\Models\Oportunidad::class) {
            $oportunidad = $this->actividadable;
            if ($oportunidad && $oportunidad->etapa === 'calificacion') {
                $oportunidad->etapa = 'evaluacion';
                $oportunidad->probabilidad = \App\Models\Oportunidad::ETAPAS['evaluacion']['probabilidad'];
                $oportunidad->save();
            }
        }
    }

    /**
     * Marcar como no realizada (requiere motivo obligatorio)
     * La oportunidad permanece en evaluacion, botón cotizacion sigue bloqueado
     */
    public function marcarNoRealizada(string $motivo): void
    {
        $this->estado = 'no_realizada';
        $this->motivo_cancelacion = $motivo;
        $this->save();
    }

    /**
     * Marcar como completada
     * Para visita_tecnica: el resultado es obligatorio y se copia a la oportunidad
     */
    public function completar(?string $resultado = null): void
    {
        $this->estado = 'completada';
        $this->fecha_realizada = now();
        if ($resultado) {
            $this->resultado = $resultado;
        }
        $this->save();

        // Para visita_tecnica: copiar resultado a oportunidad
        if ($this->tipo === 'visita_tecnica' && $resultado &&
            $this->actividadable_type === \App\Models\Oportunidad::class) {
            $oportunidad = $this->actividadable;
            if ($oportunidad) {
                $oportunidad->resultado_visita = $resultado;
                $oportunidad->save();
            }
        }

        // Actualizar fecha de último contacto en el relacionado
        $this->actualizarUltimoContacto();
    }

    /**
     * Cancelar actividad
     */
    public function cancelar(string $motivo): void
    {
        $this->estado = 'cancelada';
        $this->motivo_cancelacion = $motivo;
        $this->save();
    }

    /**
     * Reprogramar actividad
     */
    public function reprogramar(\DateTime $nuevaFecha, ?string $motivo = null): void
    {
        $this->fecha_programada = $nuevaFecha;
        $this->estado = 'reprogramada';

        if ($motivo) {
            $nota = "\n\n[Reprogramada el " . now()->format('d/m/Y H:i') . "]\nMotivo: {$motivo}";
            $this->descripcion = ($this->descripcion ?? '') . $nota;
        }

        $this->save();
    }

    /**
     * Actualizar último contacto del relacionado
     */
    protected function actualizarUltimoContacto(): void
    {
        if ($this->actividadable && method_exists($this->actividadable, 'update')) {
            if (in_array($this->tipo, ['llamada', 'email', 'reunion', 'visita_tecnica', 'whatsapp'])) {
                $this->actividadable->update([
                    'fecha_ultimo_contacto' => now()
                ]);

                // Si el relacionado es un Prospecto en estado "nuevo",
                // avanzar automáticamente a "contactado" al completar la actividad
                if (
                    $this->actividadable instanceof \App\Models\Prospecto &&
                    $this->actividadable->estado === 'nuevo'
                ) {
                    $this->actividadable->update(['estado' => 'contactado']);
                }
            }
        }
    }

    /**
     * Crear actividad de seguimiento
     */
    public function crearSeguimiento(array $datos): self
    {
        return self::create(array_merge([
            'actividadable_id' => $this->actividadable_id,
            'actividadable_type' => $this->actividadable_type,
            'user_id' => $this->user_id,
            'estado' => 'programada',
        ], $datos));
    }

    /**
     * Obtener actividades pendientes para recordatorio
     */
    public static function getParaRecordatorio(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('estado', 'programada')
                   ->where('recordatorio_activo', true)
                   ->whereRaw('DATE_SUB(fecha_programada, INTERVAL recordatorio_minutos_antes MINUTE) <= ?', [now()])
                   ->where('fecha_programada', '>', now())
                   ->get();
    }
}
