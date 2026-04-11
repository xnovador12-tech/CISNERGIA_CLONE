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
        'descartado' => 'Descartado',
        'convertido' => 'Convertido',
    ];

    /**
     * Orígenes de captación
     */
    public const ORIGENES = [
        'sitio_web' => 'Sitio Web',
        'redes_sociales' => 'Redes Sociales',
        'llamada' => 'Llamada',
        'referido' => 'Referido',
        'ecommerce' => 'E-commerce',
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
        'segmento',
        'tipo_interes',
        'estado',
        'motivo_descarte',
        'fecha_primer_contacto',
        'fecha_ultimo_contacto',
        'fecha_proximo_contacto',
        'nivel_interes',
        'urgencia',
        'user_id',
        'registered_user_id',
        'observaciones',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_primer_contacto' => 'date',
        'fecha_ultimo_contacto' => 'date',
        'fecha_proximo_contacto' => 'date',
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
        // Buscar el último número extraído del código para evitar huecos por soft deletes
        $ultimo = self::withTrashed()
            ->whereYear('created_at', $year)
            ->where('codigo', 'like', "PROSP-{$year}-%")
            ->orderByDesc('codigo')
            ->value('codigo');

        if ($ultimo) {
            $numero = (int) substr($ultimo, strrpos($ultimo, '-') + 1);
        } else {
            $numero = 0;
        }

        return "PROSP-{$year}-" . str_pad($numero + 1, 4, '0', STR_PAD_LEFT);
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

    /**
     * Usuario del e-commerce vinculado a este prospecto.
     * Diferente a vendedor() que es el usuario interno asignado.
     */
    public function registeredUser()
    {
        return $this->belongsTo(User::class, 'registered_user_id');
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
        return $query->whereNotIn('estado', ['descartado', 'convertido']);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePorSegmento($query, $segmento)
    {
        return $query->where('segmento', $segmento);
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
                    ->whereNotIn('estado', ['descartado', 'convertido']);
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

    /**
     * Convertir este prospecto en cliente.
     *
     * Centraliza la lógica de conversión usada por:
     *   - CotizacionApprovalService::aprobar() cuando se aprueba una cotización
     *   - ecommerceController::processCheckout() cuando un user logueado paga
     *
     * Idempotente: si el prospecto ya tiene un cliente vinculado, lo retorna
     * sin crear uno nuevo (re-marca el estado como 'convertido' por consistencia).
     *
     * El caller es responsable de envolver esta llamada en una transacción
     * cuando forme parte de un flujo más amplio.
     *
     * @param array $overrides Campos del Cliente a sobrescribir desde el caller.
     *                         Útil para pasar datos del formulario de checkout
     *                         (dni, ruc, dirección de facturación distinta, etc.)
     *                         o un vendedor_id específico.
     * @return Cliente
     */
    public function convertir(array $overrides = []): Cliente
    {
        // Idempotencia: si ya tiene cliente, retornarlo
        $existente = $this->cliente()->first();
        if ($existente) {
            if ($this->estado !== 'convertido') {
                $this->update(['estado' => 'convertido']);
            }
            return $existente;
        }

        // Datos base del cliente, derivados del prospecto
        $datos = [
            'nombre'               => $this->nombre,
            'apellidos'            => $this->apellidos,
            'razon_social'         => $this->razon_social,
            'ruc'                  => $this->ruc,
            'dni'                  => $this->dni,
            'email'                => $this->email,
            'telefono'             => $this->telefono,
            'celular'              => $this->celular,
            'direccion'            => $this->direccion,
            'tipo_persona'         => $this->tipo_persona ?? 'natural',
            'segmento'             => $this->segmento ?? 'residencial',
            'distrito_id'          => $this->distrito_id,
            'prospecto_id'         => $this->id,
            'origen'               => 'directo', // default; checkout sobrescribe a 'ecommerce'
            'estado'               => 'activo',
            'vendedor_id'          => $this->user_id ?? auth()->id(),
            'user_id'              => $this->registered_user_id, // FK al user del ecommerce
            'fecha_primera_compra' => now(),
        ];

        // Aplicar overrides del caller (datos del formulario, vendedor específico, etc.)
        $datos = array_merge($datos, $overrides);

        $cliente = Cliente::create($datos);

        // Marcar prospecto como convertido
        $this->update(['estado' => 'convertido']);

        return $cliente;
    }
}
