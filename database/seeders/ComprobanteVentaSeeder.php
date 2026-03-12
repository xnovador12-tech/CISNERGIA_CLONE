<?php

namespace Database\Seeders;

use App\Models\ComprobanteVenta;
use App\Models\Pedido;
use App\Models\TipoComprobante;
use App\Models\TipoOperacion;
use App\Models\Serie;
use App\Models\Moneda;
use App\Models\Sede;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ComprobanteVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pedido = Pedido::first();
        $tipoComprobante = TipoComprobante::where('descripcion', 'FACTURA')->first();
        $tipoOperacion = TipoOperacion::first();
        $moneda = Moneda::where('descripcion', 'SOLES')->first();
        $sede = Sede::first();
        $user = User::first();
        $cliente = Cliente::first();
        
        if ($pedido && $tipoComprobante && $tipoOperacion && $moneda && $sede && $user && $cliente) {
            $serie = Serie::where('tipo_comprobante_id', $tipoComprobante->id)->first();
            
            if ($serie) {
                ComprobanteVenta::create([
                    'user_id' => $user->id,
                    'cliente_id' => $cliente->id,
                    'sede_id' => $sede->id,
                    'pedido_id' => $pedido->id,
                    'tipo_comprobante_id' => $tipoComprobante->id,
                    'tipo_operacion_id' => $tipoOperacion->id,
                    'serie_id' => $serie->id,
                    'moneda_id' => $moneda->id,
                    'numero_comprobante' => '000001',
                    'fecha_emision' => now()->format('Y-m-d'),
                    'subtotal' => $pedido->subtotal,
                    'igv' => $pedido->igv,
                    'total' => $pedido->total,
                    'estado' => 'Emitido',
                ]);
            }
        }
    }
}
