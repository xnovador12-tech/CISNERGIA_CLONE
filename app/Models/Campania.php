<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campania extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campanias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'tipo',
        'descuento_porcentaje',
        'descuento_monto',
        'condicion_minimo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'imagen_banner',
        'aplica_todos_productos',
        'creado_por',
        'activado_por',
        'activado_at',
        'pausado_por',
        'pausado_at',
        'motivo_pausa',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activado_at' => 'datetime',
        'pausado_at' => 'datetime',
        'aplica_todos_productos' => 'boolean',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'condicion_minimo' => 'decimal:2',
    ];

    // Relaciones
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function activador()
    {
        return $this->belongsTo(User::class, 'activado_por');
    }

    public function pausador()
    {
        return $this->belongsTo(User::class, 'pausado_por');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'campania_productos', 'campania_id', 'producto_id')
            ->withPivot('descuento_especifico')
            ->withTimestamps();
    }

    public function metricas()
    {
        return $this->hasMany(CampaniaMetrica::class, 'campania_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'campania_id');
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa')
            ->where('fecha_inicio', '<=', Carbon::today())
            ->where('fecha_fin', '>=', Carbon::today());
    }

    public function scopeBorradores($query)
    {
        return $query->where('estado', 'borrador');
    }

    public function scopePausadas($query)
    {
        return $query->where('estado', 'pausada');
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', 'finalizada');
    }

    public function scopeVigentes($query)
    {
        return $query->activas();
    }

    // Accessors
    public function getDiasRestantesAttribute()
    {
        if ($this->fecha_fin->isPast()) return 0;
        return Carbon::today()->diffInDays($this->fecha_fin);
    }

    public function getEstaVigenteAttribute()
    {
        return $this->estado === 'activa'
            && $this->fecha_inicio->lte(Carbon::today())
            && $this->fecha_fin->gte(Carbon::today());
    }

    public function getTotalPedidosAttribute()
    {
        return $this->metricas->sum('pedidos_generados');
    }

    public function getTotalVentasAttribute()
    {
        return $this->metricas->sum('monto_total');
    }

    public function getTotalDescuentoAttribute()
    {
        return $this->metricas->sum('descuento_total_aplicado');
    }

    public function getTotalVisitasAttribute()
    {
        return $this->metricas->sum('visitas');
    }

    public function getTasaConversionAttribute()
    {
        $visitas = $this->total_visitas;
        if ($visitas <= 0) return 0;
        return round(($this->total_pedidos / $visitas) * 100, 1);
    }

    public function getTipoLabelAttribute()
    {
        return match ($this->tipo) {
            'descuento' => 'Descuento',
            'envio_gratis' => 'Envío Gratis',
            'combo' => 'Combo/Kit',
            'temporada' => 'Temporada',
            'flash_sale' => 'Flash Sale',
            default => $this->tipo,
        };
    }

    public function getDescuentoTextoAttribute()
    {
        if ($this->descuento_porcentaje) {
            return $this->descuento_porcentaje . '% dto.';
        }
        if ($this->descuento_monto) {
            return 'S/ ' . number_format($this->descuento_monto, 2) . ' dto.';
        }
        if ($this->tipo === 'envio_gratis') {
            return 'Envío Gratis';
        }
        return '';
    }

    // Métodos de estado
    public function activar($userId = null)
    {
        $this->update([
            'estado' => 'activa',
            'activado_por' => $userId,
            'activado_at' => now(),
            'motivo_pausa' => null,
        ]);
    }

    public function pausar($motivo, $userId = null)
    {
        $this->update([
            'estado' => 'pausada',
            'pausado_por' => $userId,
            'pausado_at' => now(),
            'motivo_pausa' => $motivo,
        ]);
    }

    public function reanudar($userId = null)
    {
        $this->update([
            'estado' => 'activa',
            'activado_por' => $userId,
            'activado_at' => now(),
            'motivo_pausa' => null,
            'pausado_por' => null,
            'pausado_at' => null,
        ]);
    }

    public function finalizar()
    {
        $this->update(['estado' => 'finalizada']);
    }

    // Verificar si aplica a un producto
    public function aplicaAProducto($productoId)
    {
        if ($this->aplica_todos_productos) return true;
        return $this->productos()->where('productos.id', $productoId)->exists();
    }

    // Calcular precio con descuento
    public function calcularPrecioConDescuento($producto)
    {
        $precio = $producto->precio;

        // Verificar descuento específico del pivote
        if (!$this->aplica_todos_productos) {
            $pivot = $this->productos()->where('productos.id', $producto->id)->first();
            if ($pivot && $pivot->pivot->descuento_especifico) {
                return round($precio * (1 - $pivot->pivot->descuento_especifico / 100), 2);
            }
        }

        // Descuento general
        if ($this->descuento_porcentaje) {
            return round($precio * (1 - $this->descuento_porcentaje / 100), 2);
        }

        if ($this->descuento_monto) {
            return max(0, round($precio - $this->descuento_monto, 2));
        }

        return $precio;
    }
}
