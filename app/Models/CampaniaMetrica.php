<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaniaMetrica extends Model
{
    use HasFactory;

    protected $table = 'campania_metricas';

    protected $fillable = [
        'campania_id',
        'fecha',
        'pedidos_generados',
        'productos_vendidos',
        'monto_total',
        'descuento_total_aplicado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto_total' => 'decimal:2',
        'descuento_total_aplicado' => 'decimal:2',
    ];

    public function campania()
    {
        return $this->belongsTo(Campania::class, 'campania_id');
    }

    public static function registrarPedido(int $campaniaId, float $monto, float $descuento, int $cantidadProductos): void
    {
        $metrica = self::firstOrCreate(
            ['campania_id' => $campaniaId, 'fecha' => Carbon::today()],
            ['pedidos_generados' => 0, 'productos_vendidos' => 0, 'monto_total' => 0, 'descuento_total_aplicado' => 0]
        );

        $metrica->increment('pedidos_generados');
        $metrica->increment('productos_vendidos', $cantidadProductos);
        $metrica->increment('monto_total', $monto);
        $metrica->increment('descuento_total_aplicado', $descuento);
    }
}
