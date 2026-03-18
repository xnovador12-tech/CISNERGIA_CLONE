<?php

namespace Database\Seeders;

use App\Models\Tiposcomprobante;
use Illuminate\Database\Seeder;

class ComprobanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Factura";
        $comprobante->slug = "factura";
        $comprobante->codigo = "01";
        $comprobante->tipo = "ventas";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Boleta de venta";
        $comprobante->slug = "boleta de venta";
        $comprobante->codigo = "03";
        $comprobante->tipo = "ventas";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Nota de Venta";
        $comprobante->slug = "nota-de-venta";
        $comprobante->codigo = "00";
        $comprobante->tipo = "ventas";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Nota de crédito";
        $comprobante->slug = "nota-de-credito";
        $comprobante->codigo = "07";
        $comprobante->tipo = "notac";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Nota de débito";
        $comprobante->slug = "nota-de-debito";
        $comprobante->codigo = "08";
        $comprobante->tipo = "notad";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Guia de remisión remitente";
        $comprobante->slug = "Guia-de-remision-remitente";
        $comprobante->codigo = "09";
        $comprobante->tipo = "guia";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Tiposcomprobante();
        $comprobante->name = "Guia de remisión transportista";
        $comprobante->slug = "Guia-de-remision-transportista";
        $comprobante->codigo = "31";
        $comprobante->tipo = "guia";
        $comprobante->estado = "Activo";
        $comprobante->save();
    }
}