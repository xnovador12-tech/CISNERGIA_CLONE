<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function ($pedido) {
            if (auth()->check()) {
                $pedido->created_by = auth()->id();
            }
        });

        static::updating(function ($pedido) {
            if (auth()->check()) {
                $pedido->updated_by = auth()->id();
            }
        });
    }

    protected $table = 'pedidos';

    protected $fillable = [
        'codigo',
        'slug',
        'cliente_id',
        'user_id',
        'tipo_id',
        'categoria_id',
        'subtotal',
        'condicion_pago',
        'incluye_igv',
        'descuento_porcentaje',
        'descuento_monto',
        'igv',
        'total',
        'estado',
        'tipo',
        'aprobacion_finanzas',
        'aprobacion_stock',
        'direccion_instalacion',
        'distrito_id',
        'fecha_entrega_estimada',
        'vigencia_dias',
        'almacen_id',
        'observaciones',
        'cotizacion_id',
        'origen',
        'created_by',
        'updated_by',
        // Operaciones
        'estado_operativo',
        'area_actual',
        'tecnico_asignado_id',
        'fecha_asignacion',
        'prioridad',
        'observaciones_operativas',
        'campania_id',
        // Pagos
        'pago_banco',
        'pago_operacion',
        'pago_monto',
        'pago_fecha',
        'pago_comprobante',
    ];

    protected $casts = [
        'fecha_entrega_estimada' => 'date',
        'fecha_asignacion'       => 'datetime',
        'subtotal'               => 'decimal:2',
        'incluye_igv'            => 'boolean',
        'descuento_porcentaje'   => 'decimal:2',
        'descuento_monto'        => 'decimal:2',
        'igv'                    => 'decimal:2',
        'total'                  => 'decimal:2',
        'aprobacion_finanzas'    => 'boolean',
        'aprobacion_stock'       => 'boolean',
        'pago_monto'             => 'decimal:2',
        'pago_fecha'             => 'date',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // =====================================================
    // RELACIONES PRINCIPALES
    // =====================================================

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(CotizacionCrm::class, 'cotizacion_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }

    public function cuotas()
    {
        return $this->hasMany(PedidoCuota::class, 'pedido_id');
    }

    public function venta()
    {
        return $this->hasOne(Sale::class, 'pedido_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // =====================================================
    // OPERACIONES - Relaciones, Scopes y Métodos
    // =====================================================

    protected $transicionesValidas = [
        'sin_asignar' => ['logistica'],
        'logistica'   => ['almacen', 'sin_asignar'],
        'almacen'     => ['calidad', 'logistica'],
        'calidad'     => ['despacho', 'almacen', 'logistica'],
        'despacho'    => ['completado', 'calidad'],
        'completado'  => [],
    ];

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_asignado_id');
    }

    public function campania()
    {
        return $this->belongsTo(Campania::class, 'campania_id');
    }

    public function calidad()
    {
        return $this->hasOne(PedidoCalidad::class);
    }

    public function verificaciones()
    {
        return $this->hasManyThrough(PedidoVerificacion::class, PedidoCalidad::class);
    }

    public function scopeEnKanban($query)
    {
        return $query->whereHas('venta', function ($q) {
            $q->where('estado', 'completada');
        });
    }

    public function scopeEstadoOperativo($query, $estado)
    {
        return $query->where('estado_operativo', $estado);
    }

    public function moverEstado($nuevoEstado, $datos = [])
    {
        $estadoActual = $this->estado_operativo;

        if (!isset($this->transicionesValidas[$estadoActual]) ||
            !in_array($nuevoEstado, $this->transicionesValidas[$estadoActual])) {
            return [
                'success' => false,
                'message' => "No se puede mover de '{$estadoActual}' a '{$nuevoEstado}'."
            ];
        }

        $this->estado_operativo = $nuevoEstado;
        $this->area_actual      = $nuevoEstado;

        if (isset($datos['tecnico_asignado_id'])) {
            $this->tecnico_asignado_id = $datos['tecnico_asignado_id'];
            if (!$this->fecha_asignacion) {
                $this->fecha_asignacion = now();
            }
        }

        if (isset($datos['fecha_entrega_estimada'])) {
            $this->fecha_entrega_estimada = $datos['fecha_entrega_estimada'];
        }

        if (isset($datos['prioridad'])) {
            $this->prioridad = $datos['prioridad'];
        }

        if (isset($datos['observaciones_operativas'])) {
            $this->observaciones_operativas = $datos['observaciones_operativas'];
        }

        $this->save();

        return [
            'success' => true,
            'message' => "Pedido movido a '{$nuevoEstado}' exitosamente."
        ];
    }
}
