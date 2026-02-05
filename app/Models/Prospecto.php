<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Prospecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prospectos';

    /**
     * Estados disponibles para prospectos
     */
    public const ESTADOS = [
        'nuevo' => 'Nuevo',
        'contactado' => 'Contactado',
        'calificado' => 'Calificado',
        'no_calificado' => 'No Calificado',
        'descartado' => 'Descartado',
        'convertido' => 'Convertido',
    ];

    /**
     * Orígenes de captación
     */
    public const ORIGENES = [
        'web' => 'Página Web',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'google_ads' => 'Google Ads',
        'referido' => 'Referido',
        'llamada' => 'Llamada',
        'visita' => 'Visita',
        'feria' => 'Feria/Evento',
        'otro' => 'Otro',
    ];

    /**
     * Segmentos de mercado
     */
    public const SEGMENTOS = [
        'residencial' => 'Residencial',
        'comercial' => 'Comercial',
        'industrial' => 'Industrial',
        'agricola' => 'Agrícola',
    ];

    /**
     * Niveles de scoring
     */
    public const SCORINGS = [
        'A' => 'A - Alto Potencial',
        'B' => 'B - Potencial Medio',
        'C' => 'C - Bajo Potencial',
    ];

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
        'distrito_id',
        'tipo_persona',
        'origen',
        'origen_detalle',
        'segmento',
        'scoring',
        'scoring_puntos',
        'estado',
        'motivo_descarte',
        'fecha_primer_contacto',
        'fecha_ultimo_contacto',
        'fecha_proximo_contacto',
        'consumo_mensual_kwh',
        'factura_mensual_soles',
        'tipo_inmueble',
        'area_disponible_m2',
        'tiene_medidor_bidireccional',
        'empresa_electrica',
        'presupuesto_estimado',
        'nivel_interes',
        'urgencia',
        'requiere_financiamiento',
        'user_id',
        'sede_id',
        'observaciones',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_primer_contacto' => 'date',
        'fecha_ultimo_contacto' => 'date',
        'fecha_proximo_contacto' => 'date',
        'consumo_mensual_kwh' => 'decimal:2',
        'factura_mensual_soles' => 'decimal:2',
        'area_disponible_m2' => 'decimal:2',
        'presupuesto_estimado' => 'decimal:2',
        'tiene_medidor_bidireccional' => 'boolean',
        'requiere_financiamiento' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prospecto) {
            if (empty($prospecto->codigo)) {
                $prospecto->codigo = self::generarCodigo();
            }
            if (empty($prospecto->slug)) {
                $prospecto->slug = Str::slug($prospecto->nombre . '-' . $prospecto->codigo);
            }
            if (auth()->check()) {
                $prospecto->created_by = auth()->id();
            }
        });

        static::updating(function ($prospecto) {
            if (auth()->check()) {
                $prospecto->updated_by = auth()->id();
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
        return "PROSP-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Nombre completo del prospecto
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

    // ==================== RELACIONES ====================

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
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

    public function oportunidades()
    {
        return $this->hasMany(Oportunidad::class);
    }

    public function actividades()
    {
        return $this->morphMany(ActividadCrm::class, 'actividadable');
    }

    public function cotizaciones()
    {
        return $this->hasMany(CotizacionCrm::class);
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'prospecto_id');
    }

    /**
     * Verificar si ya fue convertido a cliente
     */
    public function getEsClienteAttribute(): bool
    {
        return $this->cliente()->exists();
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
        return $query->whereNotIn('estado', ['descartado', 'no_calificado']);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePorSegmento($query, $segmento)
    {
        return $query->where('segmento', $segmento);
    }

    public function scopePorScoring($query, $scoring)
    {
        return $query->where('scoring', $scoring);
    }

    public function scopePorOrigen($query, $origen)
    {
        return $query->where('origen', $origen);
    }

    public function scopePorVendedor($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeConSeguimientoPendiente($query)
    {
        return $query->where('fecha_proximo_contacto', '<=', now())
                    ->whereNotIn('estado', ['descartado', 'no_calificado']);
    }

    public function scopeNuevosHoy($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeNuevosEsteMes($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // ==================== MÉTODOS ====================

    /**
     * Calcular el scoring basado en varios factores
     */
    public function calcularScoring(): int
    {
        $puntos = 0;

        // Por nivel de interés
        $puntos += match($this->nivel_interes) {
            'muy_alto' => 30,
            'alto' => 20,
            'medio' => 10,
            'bajo' => 0,
            default => 0,
        };

        // Por urgencia
        $puntos += match($this->urgencia) {
            'inmediata' => 25,
            'corto_plazo' => 15,
            'mediano_plazo' => 5,
            'largo_plazo' => 0,
            default => 0,
        };

        // Por presupuesto
        if ($this->presupuesto_estimado) {
            if ($this->presupuesto_estimado >= 100000) $puntos += 20;
            elseif ($this->presupuesto_estimado >= 50000) $puntos += 15;
            elseif ($this->presupuesto_estimado >= 20000) $puntos += 10;
            else $puntos += 5;
        }

        // Por segmento
        $puntos += match($this->segmento) {
            'industrial' => 15,
            'comercial' => 10,
            'agricola' => 10,
            'residencial' => 5,
            default => 0,
        };

        // Por consumo eléctrico
        if ($this->consumo_mensual_kwh && $this->consumo_mensual_kwh > 500) {
            $puntos += 10;
        }

        return min($puntos, 100);
    }

    /**
     * Actualizar scoring y categoría
     */
    public function actualizarScoring(): void
    {
        $this->scoring_puntos = $this->calcularScoring();
        
        $this->scoring = match(true) {
            $this->scoring_puntos >= 70 => 'A',
            $this->scoring_puntos >= 40 => 'B',
            default => 'C',
        };
        
        $this->save();
    }

    /**
     * Convertir prospecto a cliente
     */
    public function convertirACliente(): ?Cliente
    {
        $cliente = Cliente::create([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'razon_social' => $this->razon_social,
            'ruc' => $this->ruc,
            'dni' => $this->dni,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'celular' => $this->celular,
            'direccion' => $this->direccion,
            'prospecto_id' => $this->id,
            'segmento' => $this->segmento,
            'user_id' => $this->user_id ?? auth()->id(),
        ]);

        $this->update(['estado' => 'calificado']);

        return $cliente;
    }

    /**
     * Verificar si tiene actividades pendientes
     */
    public function tieneActividadesPendientes(): bool
    {
        return $this->actividades()
                    ->where('estado', 'programada')
                    ->where('fecha_programada', '>=', now())
                    ->exists();
    }

    /**
     * Obtener última actividad
     */
    public function ultimaActividad()
    {
        return $this->actividades()->latest('fecha_programada')->first();
    }
}
