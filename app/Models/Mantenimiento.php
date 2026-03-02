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
        'potencia_sistema_kw',
        'cantidad_paneles',
        'marca_inversor',
        'modelo_inversor',
        'checklist',
        'resultados',
        'produccion_actual_kwh',
        'produccion_esperada_kwh',
        'eficiencia_porcentaje',
        'hallazgos',
        'recomendaciones',
        'requiere_seguimiento',
        'fecha_proximo_mantenimiento',
        'es_gratuito',
        'costo_mano_obra',
        'costo_materiales',
        'costo_transporte',
        'costo_total',
        'estado_pago',
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
        'potencia_sistema_kw' => 'decimal:2',
        'produccion_actual_kwh' => 'decimal:2',
        'produccion_esperada_kwh' => 'decimal:2',
        'eficiencia_porcentaje' => 'decimal:2',
        'costo_mano_obra' => 'decimal:2',
        'costo_materiales' => 'decimal:2',
        'costo_transporte' => 'decimal:2',
        'costo_total' => 'decimal:2',
        'checklist' => 'array',
        'resultados' => 'array',
        'evidencias' => 'array',
        'es_gratuito' => 'boolean',
        'requiere_seguimiento' => 'boolean',
    ];

    /**
     * Checklist estándar de mantenimiento
     */
    public const CHECKLIST_ESTANDAR = [
        'paneles' => [
            'limpieza_paneles' => 'Limpieza de paneles solares',
            'inspeccion_visual' => 'Inspección visual de daños',
            'conexiones_paneles' => 'Verificar conexiones',
            'medicion_voltaje' => 'Medición de voltaje',
        ],
        'inversor' => [
            'funcionamiento_inversor' => 'Verificar funcionamiento',
            'display_errores' => 'Revisar display y errores',
            'ventilacion' => 'Limpieza de ventilación',
            'conexiones_inversor' => 'Verificar conexiones',
        ],
        'estructura' => [
            'anclajes' => 'Verificar anclajes',
            'corrosion' => 'Revisar corrosión',
            'ajuste_tornillos' => 'Ajustar tornillería',
        ],
        'cableado' => [
            'estado_cables' => 'Verificar estado de cables',
            'conexiones_generales' => 'Revisar conexiones',
            'protecciones' => 'Verificar protecciones eléctricas',
        ],
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
        $ultimo = self::whereYear('created_at', $year)->max('id') ?? 0;
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
        $this->estado = 'completado';
        $this->fecha_realizada = now();
        $this->resultados = $resultados;
        
        // Calcular eficiencia
        if ($this->produccion_esperada_kwh > 0 && $this->produccion_actual_kwh) {
            $this->eficiencia_porcentaje = ($this->produccion_actual_kwh / $this->produccion_esperada_kwh) * 100;
        }
        
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

    /**
     * Reprogramar
     */
    public function reprogramar(\DateTime $nuevaFecha): void
    {
        $this->estado = 'reprogramado';
        $this->fecha_programada = $nuevaFecha;
        $this->save();

        // Crear nuevo mantenimiento
        $nuevo = $this->replicate();
        $nuevo->codigo = self::generarCodigo();
        $nuevo->slug = Str::slug($nuevo->codigo . '-' . Str::random(5));
        $nuevo->estado = 'programado';
        $nuevo->fecha_programada = $nuevaFecha;
        $nuevo->fecha_realizada = null;
        $nuevo->resultados = null;
        $nuevo->save();
    }

    /**
     * Programar siguiente mantenimiento
     */
    public function programarSiguiente(int $meses = 6): self
    {
        $siguiente = $this->replicate();
        $siguiente->codigo = self::generarCodigo();
        $siguiente->slug = Str::slug($siguiente->codigo . '-' . Str::random(5));
        $siguiente->estado = 'programado';
        $siguiente->fecha_programada = now()->addMonths($meses);
        $siguiente->fecha_realizada = null;
        $siguiente->resultados = null;
        $siguiente->checklist = null;
        $siguiente->evidencias = null;
        $siguiente->hallazgos = null;
        $siguiente->recomendaciones = null;
        $siguiente->observaciones = null;
        $siguiente->duracion_real_horas = null;
        $siguiente->save();

        // Actualizar referencia en el actual
        $this->fecha_proximo_mantenimiento = $siguiente->fecha_programada;
        $this->save();

        return $siguiente;
    }

    /**
     * Obtener checklist con resultados
     */
    public function getChecklistCompleto(): array
    {
        $checklist = self::CHECKLIST_ESTANDAR;
        $resultados = $this->resultados ?? [];

        foreach ($checklist as $categoria => $items) {
            foreach ($items as $key => $descripcion) {
                $checklist[$categoria][$key] = [
                    'descripcion' => $descripcion,
                    'completado' => $resultados[$key]['completado'] ?? false,
                    'observacion' => $resultados[$key]['observacion'] ?? null,
                ];
            }
        }

        return $checklist;
    }
}
