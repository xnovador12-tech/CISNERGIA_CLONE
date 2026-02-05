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
        'duracion_minutos',
        'hora_inicio',
        'hora_fin',
        'ubicacion',
        'direccion_completa',
        'latitud',
        'longitud',
        'estado',
        'motivo_cancelacion',
        'prioridad',
        'recordatorio_activo',
        'recordatorio_minutos_antes',
        'recordatorio_enviado',
        'telefono_contacto',
        'resultado_llamada',
        'email_contacto',
        'asunto_email',
        'requiere_seguimiento',
        'fecha_seguimiento',
        'notas_seguimiento',
        'user_id',
        'created_by',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_realizada' => 'datetime',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'fecha_seguimiento' => 'date',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
        'recordatorio_activo' => 'boolean',
        'recordatorio_enviado' => 'boolean',
        'requiere_seguimiento' => 'boolean',
    ];

    /**
     * Tipos de actividad con iconos
     */
    public const TIPOS = [
        'llamada' => ['nombre' => 'Llamada', 'icono' => 'bi-telephone', 'color' => 'primary'],
        'email' => ['nombre' => 'Email', 'icono' => 'bi-envelope', 'color' => 'info'],
        'reunion' => ['nombre' => 'Reunión', 'icono' => 'bi-people', 'color' => 'success'],
        'visita_tecnica' => ['nombre' => 'Visita Técnica', 'icono' => 'bi-house-gear', 'color' => 'warning'],
        'videollamada' => ['nombre' => 'Videollamada', 'icono' => 'bi-camera-video', 'color' => 'secondary'],
        'whatsapp' => ['nombre' => 'WhatsApp', 'icono' => 'bi-whatsapp', 'color' => 'success'],
        'tarea' => ['nombre' => 'Tarea', 'icono' => 'bi-check2-square', 'color' => 'dark'],
        'nota' => ['nombre' => 'Nota', 'icono' => 'bi-sticky', 'color' => 'light'],
        'otro' => ['nombre' => 'Otro', 'icono' => 'bi-three-dots', 'color' => 'secondary'],
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
            // NO sobrescribir created_by si ya tiene un valor
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
        $ultimo = self::whereYear('created_at', $year)->max('id') ?? 0;
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
        return self::TIPOS[$this->tipo] ?? self::TIPOS['otro'];
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

    public function scopeRequierenSeguimiento($query)
    {
        return $query->where('requiere_seguimiento', true)
                    ->where('fecha_seguimiento', '<=', today());
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    // ==================== MÉTODOS ====================

    /**
     * Marcar como completada
     */
    public function completar(?string $resultado = null): void
    {
        $this->estado = 'completada';
        $this->fecha_realizada = now();
        if ($resultado) {
            $this->resultado = $resultado;
        }
        $this->save();

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
        $this->estado = 'reprogramada';
        $this->fecha_programada = $nuevaFecha;
        if ($motivo) {
            $this->motivo_cancelacion = "Reprogramada: {$motivo}";
        }
        $this->save();

        // Crear nueva actividad
        $nueva = $this->replicate();
        $nueva->codigo = self::generarCodigo();
        $nueva->slug = Str::slug($nueva->titulo . '-' . $nueva->codigo);
        $nueva->estado = 'programada';
        $nueva->fecha_programada = $nuevaFecha;
        $nueva->motivo_cancelacion = null;
        $nueva->save();
    }

    /**
     * Actualizar último contacto del relacionado
     */
    protected function actualizarUltimoContacto(): void
    {
        if ($this->actividadable && method_exists($this->actividadable, 'update')) {
            if (in_array($this->tipo, ['llamada', 'email', 'reunion', 'visita_tecnica', 'videollamada', 'whatsapp'])) {
                $this->actividadable->update([
                    'fecha_ultimo_contacto' => now()
                ]);
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
                   ->where('recordatorio_enviado', false)
                   ->whereRaw('fecha_programada <= DATE_ADD(NOW(), INTERVAL recordatorio_minutos_antes MINUTE)')
                   ->get();
    }
}
