<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiOse\Models\AffectTypeModel;
use App\Http\Controllers\ApiOse\Models\ClientModel;
use App\Http\Controllers\ApiOse\Models\DetractionModel;
use App\Http\Controllers\ApiOse\Models\ProductModel;
use App\Http\Controllers\ApiOse\Models\SaleDetailModel;
use App\Http\Controllers\ApiOse\Models\SaleModel;
use App\Http\Controllers\ApiOse\Models\SaleQuotaModel;
use App\Http\Controllers\ApiOse\Models\SaleReferenceModel;
use App\Http\Controllers\ApiOse\Services\MathService;
use App\Http\Controllers\ApiOse\Services\UtilService;
use App\Http\Controllers\ApiOse\Voucher;
use App\Models\ComprobanteControlProceso;
use App\Models\ComprobanteError;
use App\Models\Detailsale;
use App\Models\Nota;
use App\Models\Sale;
use App\Models\SaleCuota;
use App\Models\VentaDetraccion;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class SendSalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:send-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía las ventas pendientes a OSE/SUNAT de forma correlativa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Obtener o crear el control para este proceso
        $control = ComprobanteControlProceso::firstOrCreate(
            ['nombre' => 'ventas_foreach'],
            ['en_ejecucion' => false]
        );

        // 2. Control de Concurrencia
        if ($control->en_ejecucion) {
            if (Carbon::parse($control->fecha_inicio)->addMinutes(30)->isPast()) {
                $control->update(['en_ejecucion' => false]);

                return;
            }

            return;
        }

        // 3. Iniciar Proceso
        $control->update(['en_ejecucion' => true, 'fecha_inicio' => now(), 'fecha_fin' => null]);

        try {
            $saleList = Sale::with([
                'cliente',
                'tipoOperacion',
                'tipoComprobante',
                'detalles' => [
                    'producto',
                    'servicio',
                ],
            ])->where('estado_sunat', false)
                ->orderBy('id', 'asc')
                ->limit(20)
                ->get();

            $utilService = new UtilService();

            /** @var Sale $sale */
            foreach ($saleList as $sale) {
                $cliente = $sale->cliente;
                $documentType = !empty($cliente->ruc) ? '6' : '1';
                $document = !empty($cliente->ruc) ? $cliente->ruc : $cliente->dni;
                $companyName = !empty($cliente->razon_social) ? $cliente->razon_social : ($cliente->nombre . ' ' . $cliente->apellidos);

                $clientModel = new ClientModel();
                $clientModel->document_type = $documentType;
                $clientModel->document = $document;
                $clientModel->company_name = $companyName;

                if (!empty($cliente->direccion)) {
                    $clientModel->address = $cliente->direccion;
                }

                $saleModel = new SaleModel();
                $saleModel->branchModel = $utilService->getBranch();
                $saleModel->clientModel = $clientModel;
                $saleModel->operation_type_code = $sale->tipoOperacion->code;
                $saleModel->voucher_type_code = $sale->tipoComprobante->codigo;
                $saleModel->serie = $sale->serie;
                $saleModel->correlative = $sale->correlativo;
                $saleModel->issue_date = $sale->fecha_emision->format('Y-m-d');
                $saleModel->expiration_date = $sale->fecha_vencimiento->format('Y-m-d');
                $saleModel->hour = $sale->hora;
                $saleModel->coin_code = 'PEN';
                $saleModel->taxed_operation = $sale->subtotal;
                $saleModel->igv = $sale->igv;
                $saleModel->total = $sale->total;
                $saleModel->payment_method = $sale->condicion_pago;
                $saleModel->xml_name = $utilService->buildXmlName($saleModel);

                // Validar si no tiene error
                $ultimoError = ComprobanteError::where('comprobante', "{$saleModel->serie}-{$saleModel->correlative}")
                    ->latest('fecha')
                    ->first();

                if (!empty($ultimoError)) {
                    $fechaError = Carbon::parse($ultimoError->fecha);

                    if ($fechaError->addMinutes(5)->isFuture()) {
                        return;
                    }
                }

                // Detracciones
                if ($saleModel->operation_type_code === '1001') {
                    $ventaDetraccion = VentaDetraccion::with([
                        'tipoDetraccion'
                    ])->where('venta_id', $sale->id)->first();

                    if (!empty($ventaDetraccion)) {
                        $detractionModel = new DetractionModel();
                        $detractionModel->detraction_type = $ventaDetraccion->tipoDetraccion->code;
                        $detractionModel->percentage = $ventaDetraccion->tipoDetraccion->porcentaje;
                        $detractionModel->total = $ventaDetraccion->monto_detraccion;
                        $saleModel->detractionModel = $detractionModel;
                    }
                }

                // Cuotas
                if ($saleModel->payment_method === 'Credito') {
                    $ventaCuotas = SaleCuota::where('sale_id', $sale->id)->get();
                    $totalQuotas = '0.0';

                    /** @var SaleCuota $cuota */
                    foreach ($ventaCuotas as $key => $cuota) {
                        $saleQuotaModel = new SaleQuotaModel();
                        $saleQuotaModel->name = 'Cuota' . $utilService->padWithZeros($key + 1, 3);
                        $saleQuotaModel->date = $cuota->fecha_vencimiento->format('Y-m-d');
                        $saleQuotaModel->amount = $cuota->importe;
                        $saleModel->sale_quotas[] = $saleQuotaModel;
                        $totalQuotas = MathService::sum($cuota->importe, $totalQuotas);
                    }

                    $saleModel->pending_amount = $totalQuotas;
                }

                // Para las Notas Credito/Debito
                if ($saleModel->voucher_type_code === '07' || $saleModel->voucher_type_code === '08') {
                    $referencia = Nota::with([
                        'tipoComprobante',
                    ])->where('sale_id', $sale->id)->first();

                    $saleModelReference = new SaleModel();
                    $saleModelReference->voucher_type_code = $referencia->tipoComprobante->codigo;
                    $saleModelReference->serie = $referencia->serie;
                    $saleModelReference->correlative = $referencia->correlativo;

                    $saleReferenceModel = new SaleReferenceModel();
                    $saleReferenceModel->saleModel = $saleModelReference;
                    $saleReferenceModel->reason_code = $referencia->motivo_codigo;
                    $saleReferenceModel->reason_description = $referencia->motivo_descripcion;
                    $saleModel->saleReferenceModel = $saleReferenceModel;
                }

                // Detalle de la venta
                /** @var Detailsale $dt */
                foreach ($sale->detalles as $key => $dt) {
                    $affectTypeModel = new AffectTypeModel();
                    $affectTypeModel->code = '10';
                    $affectTypeModel->tribute_code = '1000';
                    $affectTypeModel->tribute_type = 'VAT';
                    $affectTypeModel->tribute_name = 'IGV';
                    $affectTypeModel->percentage = '18';

                    $productModel = new ProductModel();

                    if (!empty($dt->producto_id)) {
                        $productModel->code = $dt->producto->codigo;
                        $productModel->description = $dt->producto->name;

                        if (!empty($dt->producto->descripcion)) {
                            $productModel->description .= ' | ' . $dt->producto->descripcion;
                        }

                        $productModel->unit_code = 'NIU';
                        $productModel->affectTypeModel = $affectTypeModel;
                    } else {
                        $productModel->code = $dt->servicio->codigo;
                        $productModel->description = $dt->servicio->name;

                        if (!empty($dt->servicio->descripcion)) {
                            $productModel->description .= ' | ' . $dt->servicio->descripcion;
                        }

                        $productModel->unit_code = 'ZZ';
                        $productModel->affectTypeModel = $affectTypeModel;
                    }


                    $saleDetailModel = new SaleDetailModel();
                    $saleDetailModel->item = $key + 1;
                    $saleDetailModel->productModel = $productModel;
                    $saleDetailModel->amout = $dt->cantidad;
                    $saleDetailModel->unit_value = $utilService->formatDecimal($dt->valor_unitario);
                    $saleDetailModel->price = $utilService->formatDecimal($dt->precio_unitario);
                    $saleDetailModel->total_value = $dt->subtotal;
                    $saleDetailModel->igv = $dt->igv;
                    $saleDetailModel->total = $dt->total;

                    $saleModel->sale_details[] = $saleDetailModel;
                }

                $voucher = new Voucher();
                $response = $voucher->sale($saleModel);

                if (!empty($ultimoError)) {
                    $ultimoError->delete();
                }

                if (!$response->estado) {
                    ComprobanteError::create([
                        'comprobante' => "{$saleModel->serie}-{$saleModel->correlative}",
                        'mensaje' => $response->message,
                        'fecha' => now(),
                    ]);

                    throw new Exception($response->message);
                }

                $sale->update([
                    'estado_sunat' => true,
                    'mensaje_sunat' => $response->message,
                    'nombre_xml_sunat' => $saleModel->xml_name,
                ]);
            }
        } catch (Exception $e) {
            // 5. Manejo de Error Crítico: Detiene todo y activa bloqueo de 5 min
            $control->update(['en_ejecucion' => false, 'fecha_fin' => now()]);
        }
    }
}
