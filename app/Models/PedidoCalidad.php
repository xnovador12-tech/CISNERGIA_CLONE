<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoCalidad extends Model
{
    use HasFactory;

    protected $table = 'pedido_calidad';

    protected $fillable = [
        'pedido_id',
        'estado_calidad',
        'observaciones',
        'motivo_rechazo',
        'area_destino',
        'verificado_por',
        'fecha_verificacion',
    ];

    protected $casts = [
        'fecha_verificacion' => 'datetime',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function verificador()
    {
        return $this->belongsTo(User::class, 'verificado_por');
    }

    public function verificaciones()
    {
        return $this->hasMany(PedidoVerificacion::class, 'pedido_calidad_id');
    }

    public function verificacionesPorSeccion($seccion)
    {
        return $this->verificaciones()
            ->whereHas('checklistItem', fn($q) => $q->where('seccion', $seccion))
            ->with('checklistItem')
            ->get();
    }

    public function progresoSeccion($seccion)
    {
        $verificaciones = $this->verificaciones()
            ->whereHas('checklistItem', fn($q) => $q->where('seccion', $seccion))
            ->get();

        $total = $verificaciones->count();
        $cumplidos = $verificaciones->where('cumple', true)->count();

        return [
            'total' => $total,
            'cumplidos' => $cumplidos,
            'porcentaje' => $total > 0 ? round(($cumplidos / $total) * 100) : 0,
        ];
    }

    public function estaCompleto()
    {
        $total = $this->verificaciones()->count();
        $cumplidos = $this->verificaciones()->where('cumple', true)->count();
        return $total > 0 && $total === $cumplidos;
    }
}
