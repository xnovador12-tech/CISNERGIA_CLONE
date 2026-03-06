<?php

namespace Database\Seeders;

use App\Models\ChecklistItem;
use Illuminate\Database\Seeder;

class ChecklistItemTableSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Empaque (4 items)
            ['seccion' => 'empaque', 'descripcion' => 'Productos completos según pedido', 'orden' => 1],
            ['seccion' => 'empaque', 'descripcion' => 'Embalaje correcto y sellado', 'orden' => 2],
            ['seccion' => 'empaque', 'descripcion' => 'Etiquetado visible y legible', 'orden' => 3],
            ['seccion' => 'empaque', 'descripcion' => 'Protección adecuada (espuma, cartón)', 'orden' => 4],

            // Facturación (4 items)
            ['seccion' => 'facturacion', 'descripcion' => 'Factura/Boleta generada', 'orden' => 1],
            ['seccion' => 'facturacion', 'descripcion' => 'Datos del cliente correctos', 'orden' => 2],
            ['seccion' => 'facturacion', 'descripcion' => 'Montos coinciden con pedido', 'orden' => 3],
            ['seccion' => 'facturacion', 'descripcion' => 'Comprobante adjunto al paquete', 'orden' => 4],

            // Preparación de envío (4 items)
            ['seccion' => 'preparacion_envio', 'descripcion' => 'Dirección de entrega verificada', 'orden' => 1],
            ['seccion' => 'preparacion_envio', 'descripcion' => 'Transportista asignado', 'orden' => 2],
            ['seccion' => 'preparacion_envio', 'descripcion' => 'Guía de remisión generada', 'orden' => 3],
            ['seccion' => 'preparacion_envio', 'descripcion' => 'Contacto con cliente confirmado', 'orden' => 4],
        ];

        foreach ($items as $item) {
            ChecklistItem::create($item);
        }
    }
}
