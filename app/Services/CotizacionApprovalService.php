<?php

namespace App\Services;

use App\Models\CotizacionCrm;
use App\Models\Cliente;
use App\Models\DetallePedido;
use App\Models\Oportunidad;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CotizacionApprovalService
{
    /**
     * Aprobar cotización: flujo completo de conversión.
     *
     * 1. Cotización → aceptada
     * 2. Oportunidad → ganada
     * 3. Prospecto → convertido (si aún no lo es)
     * 4. Cliente → creado (si aún no existe)
     * 5. Pedido → creado (estado pendiente, requiere aprobación de finanzas y stock)
     *
     * La venta (Sale) se genera después desde el módulo de Pedidos
     * cuando se aprueba finanzas y se ejecuta generarComprobante().
     *
     * @return array ['success' => bool, 'message' => string, 'cliente' => Cliente|null, 'pedido' => Pedido|null]
     */
    public function aprobar(CotizacionCrm $cotizacion): array
    {
        // Validar que la cotización pueda ser aprobada
        if (!in_array($cotizacion->estado, ['borrador', 'enviada'])) {
            return [
                'success' => false,
                'message' => 'Esta cotización no puede ser aprobada en su estado actual (' . $cotizacion->estado . ').',
                'cliente' => null,
                'pedido'  => null,
            ];
        }

        // Validar que tenga ítems
        if ($cotizacion->detalles()->count() === 0) {
            return [
                'success' => false,
                'message' => 'La cotización no tiene ítems. Agregue productos o servicios antes de aprobar.',
                'cliente' => null,
                'pedido'  => null,
            ];
        }

        return DB::transaction(function () use ($cotizacion) {

            // ── 1. Marcar cotización como aceptada ──
            $cotizacion->update([
                'estado'          => 'aceptada',
                'fecha_respuesta' => now(),
            ]);

            // ── 2. Obtener oportunidad y prospecto ──
            $oportunidad = $cotizacion->oportunidad;
            $prospecto   = $oportunidad->prospecto ?? $cotizacion->prospecto;
            $cliente     = null;

            // ── 3. Convertir prospecto a cliente (si aún no lo es) ──
            if ($prospecto && $prospecto->estado !== 'convertido') {
                // Usa el método centralizado del modelo Prospecto.
                // Pasamos vendedor_id explícito desde la cotización (vendedor que cerró el deal)
                // en lugar del default ($prospecto->user_id), para mejor trazabilidad.
                $cliente = $prospecto->convertir([
                    'vendedor_id' => $cotizacion->user_id ?? $prospecto->user_id ?? auth()->id(),
                ]);

                // Vincular cliente a la oportunidad y cotización
                $oportunidad->update(['cliente_id' => $cliente->id]);
                $cotizacion->update(['cliente_id' => $cliente->id]);
            } else {
                // Si ya es cliente, obtener el existente
                $cliente = $oportunidad->cliente
                    ?? Cliente::where('prospecto_id', $prospecto?->id)->first();
            }

            if (!$cliente) {
                throw new \Exception('No se pudo crear o encontrar el cliente.');
            }

            // ── 4. Marcar oportunidad como ganada ──
            if ($oportunidad && $oportunidad->etapa !== 'ganada') {
                $oportunidad->update([
                    'etapa'             => 'ganada',
                    'probabilidad'      => 100,
                    'monto_final'       => $cotizacion->total,
                    'valor_ponderado'   => $cotizacion->total,
                    'fecha_cierre_real' => now(),
                ]);
            }

            // ── 5. Crear pedido automático (estado pendiente) ──
            $pedido = $this->crearPedido($cotizacion, $oportunidad, $cliente);

            // ── Mensaje de resultado ──
            $nombreCliente = $cliente->razon_social
                ?? ($cliente->nombre . ' ' . $cliente->apellidos);

            $message = "Cotización {$cotizacion->codigo} aprobada exitosamente. "
                . "Se generó el pedido {$pedido->codigo} para {$nombreCliente}. "
                . "Pendiente: aprobación de Finanzas y Stock para facturar.";

            return [
                'success' => true,
                'message' => $message,
                'cliente' => $cliente,
                'pedido'  => $pedido,
            ];
        });
    }

    /**
     * Crear pedido desde cotización aprobada.
     * Estado: pendiente (requiere aprobación de finanzas y stock).
     * Los ítems se copian directamente de los detalles de la cotización.
     * El descuento es general (a nivel de cotización), no por ítem.
     */
    private function crearPedido(CotizacionCrm $cotizacion, Oportunidad $oportunidad, Cliente $cliente): Pedido
    {
        // Generar código secuencial
        $ultimoPedido = Pedido::latest('id')->first();
        $numero = $ultimoPedido ? $ultimoPedido->id + 1 : 1;
        $codigo = 'PED-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        // Crear pedido
        $pedido = Pedido::create([
            'codigo'                 => $codigo,
            'slug'                   => Str::slug($codigo),
            'cliente_id'             => $cliente->id,
            'user_id'                => $cotizacion->user_id ?? auth()->id(),
            'cotizacion_id'          => $cotizacion->id,
            'subtotal'               => $cotizacion->subtotal,
            'incluye_igv'            => $cotizacion->incluye_igv ?? false,
            'descuento_porcentaje'   => $cotizacion->descuento_porcentaje ?? 0,
            'descuento_monto'        => $cotizacion->descuento_monto ?? 0,
            'igv'                    => $cotizacion->igv,
            'total'                  => $cotizacion->total,
            'estado'                 => 'pendiente',
            'tipo'                   => $this->determinarTipoPedido($cotizacion),
            'aprobacion_finanzas'    => false,
            'aprobacion_stock'       => false,
            'direccion_instalacion'  => $cliente->direccion,
            'distrito_id'            => $cliente->distrito_id,
            'fecha_entrega_estimada' => now()->addDays($cotizacion->tiempo_ejecucion_dias ?? 7),
            'vigencia_dias'          => 15,
            'origen'                 => 'directo', // Clientes CRM siempre son directos (ENUM: ecommerce|directo)
            'observaciones'          => "Generado desde cotización {$cotizacion->codigo}."
                . " Oportunidad: {$oportunidad->codigo}."
                . " Proyecto: {$oportunidad->nombre}.",
        ]);

        // Copiar ítems de la cotización al pedido.
        // El descuento es general (nivel pedido), no por ítem.
        foreach ($cotizacion->detalles as $detalle) {
            DetallePedido::create([
                'pedido_id'       => $pedido->id,
                'producto_id'     => $detalle->producto_id,
                'servicio_id'     => $detalle->servicio_id,
                'tipo'            => $detalle->categoria ?? 'producto',
                'descripcion'     => $detalle->descripcion,
                'cantidad'        => $detalle->cantidad,
                'unidad'          => $detalle->unidad ?? 'und',
                'precio_unitario' => $detalle->precio_unitario,
                'subtotal'        => $detalle->subtotal,
            ]);
        }

        return $pedido;
    }

    /**
     * Determinar tipo de pedido según los ítems de la cotización.
     */
    private function determinarTipoPedido(CotizacionCrm $cotizacion): string
    {
        $categorias = $cotizacion->detalles->pluck('categoria')->unique();

        if ($categorias->contains('producto') && $categorias->contains('servicio')) {
            return 'producto'; // Mixto → default producto
        }

        return $categorias->first() === 'servicio' ? 'servicio' : 'producto';
    }

    /**
     * Rechazar cotización.
     */
    public function rechazar(CotizacionCrm $cotizacion, string $motivo): array
    {
        $cotizacion->update([
            'estado'          => 'rechazada',
            'motivo_rechazo'  => $motivo,
            'fecha_respuesta' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Cotización marcada como rechazada.',
        ];
    }
}
