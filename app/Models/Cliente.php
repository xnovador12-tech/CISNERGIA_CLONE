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
        'origen',
        'estado',
        'prospecto_id',
        'segmento',
        'fecha_primera_compra',
        'vendedor_id',
        'user_id',
        'sede_id',
        'distrito_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_primera_compra' => 'date',
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
            // Slug = codigo slugificado (CLI-2026-00001 → cli-2026-00001)
            if (empty($cliente->slug)) {
                $cliente->slug = Str::slug($cliente->codigo);
            }
        });
    }

    /**
     * Generar código único (no depende de created_at)
     */
    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::withTrashed()
            ->where('codigo', 'like', "CLI-{$year}-%")
            ->count();
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

    // ==================== RELACIONES ====================

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

    public function oportunidades()
    {
        return $this->hasMany(Oportunidad::class, 'prospecto_id', 'prospecto_id');
    }

    public function cotizaciones()
    {
        return $this->hasMany(CotizacionCrm::class, 'prospecto_id', 'prospecto_id');
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

    // ==================== SCOPES ====================

    public function scopePorSegmento($query, $segmento)
    {
        return $query->where('segmento', $segmento);
    }

    // ==================== MÉTODOS ====================

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
