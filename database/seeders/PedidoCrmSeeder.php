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
            $this->command->warn('⚠️ No hay oportunidades ganadas. Se omitió PedidoCrmSeeder.');
            return;
        }

        $almacen = \App\Models\Almacen::first();
        $tecnico = User::skip(1)->first() ?? User::first();

        $totalPedidos = 0;

        foreach ($ganadas as $index => $oportunidad) {
            $prospecto = $oportunidad->prospecto;
            if (!$prospecto) {
                $this->command->warn("  ⚠️ Oportunidad {$oportunidad->codigo} sin prospecto. Omitida.");
                continue;
            }

            // Buscar el cliente que fue creado desde esta oportunidad (via prospecto_id)
            $cliente = Cliente::where('prospecto_id', $prospecto->id)->first();
            if (!$cliente) {
                $this->command->warn("  ⚠️ No se encontró cliente para prospecto {$prospecto->email}. Omitida.");
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
                $this->command->warn("  ⚠️ Oportunidad {$oportunidad->codigo} sin cotización con detalles. Omitida.");
                continue;
            }

            // ── Calcular totales desde detalles de cotización ──
            $subtotal = 0;
            $itemsData = [];

            foreach ($cotizacion->detalles as $detalle) {
                $precioUnit = $detalle->precio_unitario;
                $cantidad   = $detalle->cantidad;
                $descuento  = ($precioUnit * $cantidad) * ($detalle->descuento_porcentaje / 100);
                $lineTotal  = ($precioUnit * $cantidad) - $descuento;

                $itemsData[] = [
                    'producto_id'    => $detalle->producto_id,
                    'servicio_id'    => null, // servicios de cotización no tienen FK a tabla servicios
                    'tipo'           => $detalle->categoria ?? 'producto',
                    'descripcion'    => $detalle->descripcion,
                    'cantidad'       => (int) $cantidad,
                    'precio_unitario' => $precioUnit,
                    'descuento_monto' => $descuento,
                    'subtotal'       => $lineTotal,
                ];

                $subtotal += $lineTotal;
            }

            $descuentoGlobal = $subtotal * (($cotizacion->descuento_porcentaje ?? 0) / 100);
            $baseImponible   = $subtotal - $descuentoGlobal;
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
                'codigo'                => $codigo,
                'slug'                  => Str::slug($codigo),
                'cliente_id'            => $cliente->id,
                'user_id'               => $oportunidad->user_id,
                'subtotal'              => round($baseImponible, 2),
                'descuento_monto'       => round($descuentoGlobal, 2),
                'igv'                   => $igv,
                'total'                 => $total,
                'estado'                => 'entregado',
                'aprobacion_finanzas'   => true,
                'aprobacion_stock'      => true,
                'direccion_instalacion' => $cliente->direccion,
                'distrito_id'           => $cliente->distrito_id,
                'fecha_entrega_estimada' => $fechaEntrega,
                'almacen_id'            => $almacen?->id,
                'origen'                => $cliente->origen === 'ecommerce' ? 'ecommerce' : 'directo',
                'observaciones'         => "Pedido generado desde oportunidad {$oportunidad->codigo}. Cotización: {$cotizacion->codigo}.",
            ]);

            // ── Crear detalles del pedido ──
            foreach ($itemsData as $item) {
                DetallePedido::create(array_merge($item, [
                    'pedido_id' => $pedido->id,
                ]));
            }

            $totalPedidos++;
            $itemCount = count($itemsData);
            $this->command->info("  📦 {$codigo} → {$cliente->nombre} {$cliente->apellidos} ({$itemCount} ítems, Total: S/ {$total})");
        }

        $this->command->info("✅ {$totalPedidos} pedidos creados desde oportunidades ganadas.");
    }
}
