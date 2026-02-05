<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Garantia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'garantias';

    protected $fillable = [
        'codigo',
        'slug',
        'cliente_id',
        'venta_id',
        'producto_id',
        'tipo',
        'marca',
        'modelo',
        'numero_serie',
        'cantidad',
        'fecha_inicio',
        'fecha_fin',
        'anos_garantia',
        'estado',
        'condiciones',
        'exclusiones',
        'cubre_mano_obra',
        'cubre_repuestos',
        'cubre_transporte',
        'veces_utilizada',
        'certificado_garantia',
        'observaciones',
        'created_by',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'cubre_mano_obra' => 'boolean',
        'cubre_repuestos' => 'boolean',
        'cubre_transporte' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($garantia) {
            if (empty($garantia->codigo)) {
                $garantia->codigo = self::generarCodigo();
            }
            if (empty($garantia->slug)) {
                $garantia->slug = Str::slug($garantia->codigo . '-' . Str::random(5));
            }
            if (auth()->check()) {
                $garantia->created_by = auth()->id();
            }
            // Calcular fecha fin
            if ($garantia->fecha_inicio && $garantia->anos_garantia) {
                $garantia->fecha_fin = $garantia->fecha_inicio->addYears((int)$garantia->anos_garantia);
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
        return "GAR-{$year}-{$numero}";
    }

    /**
     * Usar slug como route key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Verificar si está vigente
     */
    public function getEstaVigenteAttribute(): bool
    {
        return $this->estado === 'vigente' && $this->fecha_fin >= now();
    }

    /**
     * Días restantes
     */
    public function getDiasRestantesAttribute(): int
    {
        return max(0, now()->diffInDays($this->fecha_fin, false));
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

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usos()
    {
        return $this->hasMany(GarantiaUso::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==================== SCOPES ====================

    public function scopeVigentes($query)
    {
        return $query->where('estado', 'vigente')
                    ->where('fecha_fin', '>=', now());
    }

    public function scopeVencidas($query)
    {
        return $query->where('fecha_fin', '<', now());
    }

    public function scopePorVencer($query, $dias = 30)
    {
        return $query->vigentes()
                    ->whereBetween('fecha_fin', [now(), now()->addDays($dias)]);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // ==================== MÉTODOS ====================

    /**
     * Registrar uso de garantía
     */
    public function registrarUso(array $datos): GarantiaUso
    {
        $uso = $this->usos()->create(array_merge($datos, [
            'fecha_uso' => now(),
            'user_id' => auth()->id(),
        ]));

        $this->increment('veces_utilizada');
        
        return $uso;
    }

    /**
     * Verificar disponibilidad
     */
    public function estaDisponible(): bool
    {
        return $this->esta_vigente && $this->estado === 'vigente';
    }

    /**
     * Actualizar estado automáticamente
     */
    public static function actualizarEstadosVencidos(): int
    {
        return self::where('estado', 'vigente')
                   ->where('fecha_fin', '<', now())
                   ->update(['estado' => 'vencida']);
    }
}
