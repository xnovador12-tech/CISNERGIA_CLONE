<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiOse\Models\ClientModel;
use App\Http\Controllers\ApiOse\Models\SaleModel;
use App\Http\Controllers\ApiOse\Services\UtilService;
use App\Models\ComprobanteControlProceso;
use App\Models\Sale;
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
            }
        } catch (Exception $e) {
            // 5. Manejo de Error Crítico: Detiene todo y activa bloqueo de 5 min
            $control->update(['en_ejecucion' => false, 'fecha_fin' => now()]);
            // Log::error($e->getMessage());
        }
    }
}
