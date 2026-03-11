<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\CotizacionCrm;
use App\Models\DetallePedido;
use App\Models\Oportunidad;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PedidoCrmSeeder extends Seeder
{
    /**
     * Crea pedidos a partir de oportunidades GANADAS con cotización aceptada.
     *
     * Flujo real del negocio:
     *   Oportunidad (ganada) → Cotización (aceptada) → Pedido (entregado) → Sale
     *
     * Los ítems del pedido se copian de los detalles de la cotización aceptada.
     * Cada pedido se vincula al cliente creado desde esa misma oportunidad.
     * El descuento es general (nivel pedido), no por ítem.
     *
     * Dependencias: OportunidadSeeder, CotizacionCrmSeeder, ClienteSeeder
     */
    public function run(): void
    {
        $ganadas = Oportunidad::where('etapa', 'ganada')
            ->with(['cotizaciones.detalles', 'prospecto'])
            ->orderBy('fecha_cierre_real')
            ->get();

        if ($ganadas->isEmpty()) {
            return;
        }

        $almacen = \App\Models\Almacen::first();

        foreach ($ganadas as $oportunidad) {
            $prospecto = $oportunidad->prospecto;
            if (!$prospecto) {
                continue;
            }

            // Buscar el cliente creado desde esta oportunidad (via prospecto_id)
            $cliente = Cliente::where('prospecto_id', $prospecto->id)->first();
            if (!$cliente) {
                continue;
            }

            // Buscar la cotización aceptada de esta oportunidad
            $cotizacion = $oportunidad->cotizaciones
                ->where('estado', 'aceptada')
                ->first();

            if (!$cotizacion) {
                // Si no hay aceptada, tomar la más reciente
                $cotizacion = $oportunidad->cotizaciones->sortByDesc('created_at')->first();
            }

            if (!$cotizacion || $cotizacion->detalles->isEmpty()) {
                continue;
            }

            // ── Preparar ítems desde detalles de cotización ──
            // El subtotal por ítem ya viene calculado por DetalleCotizacionCrm::booted()
            $itemsData = [];
            $subtotalItems = 0;

            foreach ($cotizacion->detalles as $detalle) {
                $itemsData[] = [
                    'producto_id'     => $detalle->producto_id,
                    'servicio_id'     => $detalle->servicio_id,
                    'tipo'            => $detalle->categoria ?? 'producto',
                    'descripcion'     => $detalle->descripcion,
                    'cantidad'        => (int) $detalle->cantidad,
                    'unidad'          => $detalle->unidad ?? 'und',
                    'precio_unitario' => $detalle->precio_unitario,
                    'subtotal'        => $detalle->subtotal,
                ];

                $subtotalItems += (float) $detalle->subtotal;
            }

            // ── Calcular totales a nivel de pedido ──
            $descuentoGlobal = $subtotalItems * (($cotizacion->descuento_porcentaje ?? 0) / 100);
            $baseImponible   = $subtotalItems - $descuentoGlobal;
            $igv             = $cotizacion->incluye_igv ? round($baseImponible * 0.18, 2) : 0;
            $total           = round($baseImponible + $igv, 2);

            // ── Generar código del pedido ──
            $numero = Pedido::count() + 1;
            $codigo = 'PED-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

            // ── Determinar fechas (pedidos ya entregados) ──
            $fechaCierre  = $oportunidad->fecha_cierre_real ?? now()->subDays(10);
            $fechaEntrega = $fechaCierre->copy()->addDays(rand(3, 7));

            // ── Crear pedido ──
            $pedido = Pedido::create([
                'codigo'                 => $codigo,
                'slug'                   => Str::slug($codigo),
                'cliente_id'             => $cliente->id,
                'user_id'                => $oportunidad->user_id,
                'cotizacion_id'          => $cotizacion->id,
                'subtotal'               => round($subtotalItems, 2),
                'descuento_porcentaje'   => $cotizacion->descuento_porcentaje ?? 0,
                'descuento_monto'        => round($descuentoGlobal, 2),
                'igv'                    => $igv,
                'total'                  => $total,
                'estado'                 => 'entregado',
                'aprobacion_finanzas'    => true,
                'aprobacion_stock'       => true,
                'direccion_instalacion'  => $cliente->direccion,
                'distrito_id'            => $cliente->distrito_id,
                'fecha_entrega_estimada' => $fechaEntrega,
                'almacen_id'             => $almacen?->id,
                'origen'                 => 'cotizacion', // Pedido generado desde cotización CRM
                'observaciones'          => "Pedido generado desde oportunidad {$oportunidad->codigo}. Cotización: {$cotizacion->codigo}.",
            ]);

            // ── Crear detalles del pedido ──
            foreach ($itemsData as $item) {
                DetallePedido::create(array_merge($item, [
                    'pedido_id' => $pedido->id,
                ]));
            }
        }
    }
}
