<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoVerificacion extends Model
{
    use HasFactory;

    protected $table = 'pedido_verificaciones';

    protected $fillable = [
        'pedido_calidad_id',
        'checklist_item_id',
        'cumple',
        'observacion',
        'verificado_por',
        'fecha_verificacion',
    ];

    protected $casts = [
        'cumple' => 'boolean',
        'fecha_verificacion' => 'datetime',
    ];

    public function pedidoCalidad()
    {
        return $this->belongsTo(PedidoCalidad::class, 'pedido_calidad_id');
    }

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class, 'checklist_item_id');
    }

    public function verificador()
    {
        return $this->belongsTo(User::class, 'verificado_por');
    }
}
