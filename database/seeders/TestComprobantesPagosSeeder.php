<?php

namespace Database\Seeders;

use App\Models\ComprobanteCompra;
use App\Models\Ordencompra;
use App\Models\Detallecompra;
use App\Models\DetalleComprobanteCompra;
use App\Models\Mediopago;
use App\Models\Moneda;
use App\Models\Proveedor;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Tiposcomprobante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestComprobantesPagosSeeder extends Seeder
{
    public function run()
    {
        // Limpiar datos previos de prueba
        Ordencompra::where('codigo', 'like', 'OC-TEST-%')->delete();

        // 1. Asegurar un Proveedor
        $persona = Persona::where('nro_identificacion', '20123456789')->first();
        if (!$persona) {
            $persona = Persona::create([
                'name' => 'Proveedor de Prueba S.A.C.',
                'slug' => 'proveedor-prueba-' . Str::random(5),
                'tipo_persona' => 'juridica',
                'nro_identificacion' => '20123456789',
                'identificacion' => 'RUC',
                'sede_id' => 1
            ]);
        }

        $proveedor = Proveedor::where('persona_id', $persona->id)->first();
        if (!$proveedor) {
            $proveedor = Proveedor::create([
                'persona_id' => $persona->id,
                'estado' => 'Activo',
                'giro' => 'Comercial',
                'departamento_id' => 1
            ]);
        } else {
            $proveedor->update(['estado' => 'Activo']);
        }

        $producto = Producto::first();
        $tiposComprobante = Tiposcomprobante::all();
        $tipoFactura = $tiposComprobante->first(fn($t) => str_contains(strtoupper($t->name), 'FACTURA'));
        $monedas = Moneda::all();
        $soles = $monedas->first(fn($m) => str_contains(strtoupper($m->descripcion), 'SOLES'));
        $mediosPago = Mediopago::all();
        $efectivo = $mediosPago->first(fn($mp) => str_contains(strtoupper($mp->name), 'EFECTIVO'));

        // 2. Crear OC de Prueba 1 (Contado - Soles - Factura)
        $oc1 = Ordencompra::create([
            'codigo' => 'OC-TEST-001',
            'slug' => 'oc-test-001-' . Str::random(3),
            'fecha' => now()->format('Y-m-d'),
            'total' => 1180.00,
            'total_pago' => 0.00,
            'tipo_moneda' => 'Soles',
            'forma_pago' => 'Contado',
            'comprobante' => 'Factura',
            'estado' => 'Aprobado',
            'estado_pago' => 'Pendiente',
            'proveedor_id' => $proveedor->id,
            'sede_id' => 1,
            'observacion' => 'Prueba de pago contado - Insumos del Proveedor'
        ]);

        Detallecompra::create([
            'ordencompra_id' => $oc1->id,
            'producto' => 'Insumo Eléctrico Premium (Proveedor)',
            'producto_id' => $producto ? $producto->id : 1,
            'tipo_producto' => 'producto',
            'umedida' => 'unidades',
            'cantidad' => 10,
            'cantidadp_ingresar' => 10,
            'precio' => 100.00,
            'subtotal' => 1000.00,
            'tipo_impuesto_value' => 'GRAVADO'
        ]);

        // 3. Crear OC de Prueba 2 (Crédito - Dólares - Boleta)
        $oc2 = Ordencompra::create([
            'codigo' => 'OC-TEST-002',
            'slug' => 'oc-test-002-' . Str::random(3),
            'fecha' => now()->format('Y-m-d'),
            'total' => 2360.00,
            'total_pago' => 0.00,
            'tipo_moneda' => 'Dolares',
            'forma_pago' => 'Credito',
            'comprobante' => 'Boleta',
            'plazo_pago' => '30 días',
            'estado' => 'Aprobado',
            'estado_pago' => 'Pendiente',
            'proveedor_id' => $proveedor->id,
            'sede_id' => 1,
            'observacion' => 'Prueba de pago crédito - Equipamiento Técnico'
        ]);

        Detallecompra::create([
            'ordencompra_id' => $oc2->id,
            'producto' => 'Transformador Industrial (Proveedor)',
            'producto_id' => $producto ? $producto->id : 1,
            'tipo_producto' => 'producto',
            'umedida' => 'unidades',
            'cantidad' => 2,
            'cantidadp_ingresar' => 2,
            'precio' => 1000.00,
            'subtotal' => 2000.00,
            'tipo_impuesto_value' => 'GRAVADO'
        ]);

        // 4. Crear un Comprobante de Compra ya registrado (para el Index)
        $oc3 = Ordencompra::create([
            'codigo' => 'OC-TEST-003',
            'slug' => 'oc-test-003-' . Str::random(3),
            'fecha' => now()->subDays(5)->format('Y-m-d'),
            'total' => 500.00,
            'total_pago' => 500.00,
            'tipo_moneda' => 'Soles',
            'forma_pago' => 'Contado',
            'comprobante' => 'Factura',
            'estado' => 'Aprobado',
            'estado_pago' => 'Facturado',
            'proveedor_id' => $proveedor->id,
            'sede_id' => 1,
            'observacion' => 'OC ya facturada para probar el index'
        ]);

        $comp = ComprobanteCompra::create([
            'codigo' => 'CP-TEST-001',
            'slug' => 'cp-test-001-' . Str::random(3),
            'proveedor_id' => $proveedor->id,
            'ordencompra_id' => $oc3->id,
            'tiposcomprobante_id' => $tipoFactura ? $tipoFactura->id : 1,
            'numero_comprobante' => 'F001-00000100',
            'subtotal' => 423.73,
            'igv' => 76.27,
            'total' => 500.00,
            'moneda_id' => $soles ? $soles->id : 1,
            'mediopago_id' => $efectivo ? $efectivo->id : 1,
            'condicion_pago' => 'Contado',
            'estado' => 'completada',
            'user_id' => 1,
            'sede_id' => 1,
            'observaciones' => 'Comprobante de prueba auto-generado'
        ]);

        DetalleComprobanteCompra::create([
            'comprobante_compra_id' => $comp->id,
            'descripcion' => 'Insumos Varios - OC-TEST-003',
            'cantidad' => 1,
            'precio_unitario' => 423.73,
            'subtotal' => 423.73,
            'igv' => 76.27,
            'total' => 500.00
        ]);

        echo "Datos de prueba para Comprobantes de Pagos (OCs pendientes y Comprobante registrado) creados correctamente.\n";
    }
}
