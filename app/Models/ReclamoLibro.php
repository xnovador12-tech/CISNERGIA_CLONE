<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReclamoLibro extends Model
{
    use HasFactory;

    protected $table = 'libro_reclamaciones';

    protected $fillable = [
        'numero_registro',
        'fecha_reclamo',
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'direccion',
        'telefono',
        'correo',
        'producto_id',
        'nro_pedido',
        'fecha_compra',
        'monto_pagado',
        'tipo_reclamo',
        'descripcion_reclamo',
        'solucion_esperada',
        'estado',
        'respuesta_empresa',
        'fecha_respuesta',
    ];

    protected $casts = [
        'fecha_reclamo' => 'date',
        'fecha_respuesta' => 'datetime',
        'fecha_compra' => 'date',
        'monto_pagado' => 'decimal:2',
    ];

    /**
     * Relación con Empresa
     */
    /**
     * Obtener el nombre completo del consumidor
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Determinar si el reclamo está resuelto
     */
    public function isResuelto()
    {
        return $this->estado === 'Resuelto';
    }

    /**
     * Determinar si el reclamo está pendiente
     */
    public function isPendiente()
    {
        return $this->estado === 'Pendiente';
    }
}
