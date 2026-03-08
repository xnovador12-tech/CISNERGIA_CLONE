<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Mantenimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mantenimientos';

    protected $fillable = [
        'codigo',
        'slug',
        'cliente_id',
        'ticket_id',
        'tipo',
        'titulo',
        'descripcion',
        'fecha_programada',
        'hora_programada',
        'fecha_realizada',
        'duracion_estimada_horas',
        'duracion_real_horas',
        'direccion',
        'estado',
        'checklist',
        'resultados',
        'hallazgos',
        'recomendaciones',
        'requiere_seguimiento',
        'fecha_proximo_mantenimiento',
        'costo_mano_obra',
        'costo_materiales',
        'costo_transporte',
        'costo_total',
        'tecnico_id',
        'evidencias',
        'observaciones',
        'notas_internas',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'hora_programada' => 'datetime:H:i',
        'fecha_realizada' => 'date',
        'fecha_proximo_mantenimiento' => 'date',
        'costo_mano_obra' => 'decimal:2',
        'costo_materiales' => 'decimal:2',
        'costo_transporte' => 'decimal:2',
        'costo_total' => 'decimal:2',
        'checklist'          => 'array',
        'resultados'         => 'array',
        'evidencias'         => 'array',
        'requiere_seguimiento' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mantenimiento) {
            if (empty($mantenimiento->codigo)) {
                $mantenimiento->codigo = self::generarCodigo();
            }
            if (empty($mantenimiento->slug)) {
                $mantenimiento->slug = Str::slug($mantenimiento->codigo . '-' . Str::random(5));
            }
            if (auth()->check()) {
                $mantenimiento->created_by = auth()->id();
            }
        });

        static::updating(function ($mantenimiento) {
            if (auth()->check()) {
                $mantenimiento->updated_by = auth()->id();
            }
            // Calcular costo total
            $mantenimiento->costo_total = $mantenimiento->costo_mano_obra + 
                                          $mantenimiento->costo_materiales + 
                                          $mantenimiento->costo_transporte;
        });
    }

    /**
     * Generar código único
     */
    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::withTrashed()->whereYear('created_at', $year)->count();
        $numero = str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);
        return "MANT-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ==================== RELACIONES ====================

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function actividades()
    {
        return $this->morphMany(ActividadCrm::class, 'actividadable');
    }

    // ==================== SCOPES ====================

    public function scopeProgramados($query)
    {
        return $query->where('estado', 'programado');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorTecnico($query, $tecnicoId)
    {
        return $query->where('tecnico_id', $tecnicoId);
    }

    public function scopeDeHoy($query)
    {
        return $query->whereDate('fecha_programada', today());
    }

    public function scopeDeSemana($query)
    {
        return $query->whereBetween('fecha_programada', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeProximos($query, $dias = 7)
    {
        return $query->whereBetween('fecha_programada', [now(), now()->addDays($dias)])
                    ->whereIn('estado', ['programado', 'confirmado']);
    }

    // ==================== MÉTODOS ====================

    /**
     * Confirmar mantenimiento
     */
    public function confirmar(): void
    {
        $this->estado = 'confirmado';
        $this->save();
    }

    /**
     * Iniciar mantenimiento
     */
    public function iniciar(): void
    {
        $this->estado = 'en_progreso';
        $this->save();
    }

    /**
     * Completar mantenimiento
     */
    public function completar(array $resultados): void
    {
        $this->estado     = 'completado';
        $this->fecha_realizada = now();
        $this->resultados = $resultados;
        $this->save();
    }

    /**
     * Cancelar mantenimiento
     */
    public function cancelar(): void
    {
        $this->estado = 'cancelado';
        $this->save();
    }
}
