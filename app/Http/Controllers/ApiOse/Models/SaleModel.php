<?php

namespace App\Http\Controllers\ApiOse\Models;

class SaleModel
{
    // Detectar el emisor
    public BranchModel $branchModel;

    // Cliente
    public ClientModel $clientModel;

    // Datos que lleva la factura
    public string $operation_type_code;
    public string $voucher_type_code;
    public string $serie;
    public int $correlative;
    public string $issue_date;
    public string $expiration_date;
    public string $hour;
    public ?string $observation = null;
    public string $coin_code;
    public string $taxed_operation;
    public string $exonerated_operation = '0.0';
    public string $unaffected_operation = '0.0';
    public string $igv;
    public string $total;
    public string $payment_method;
    public string $pending_amount = '0.0';
    public string $xml_name;

    // Detalles
    public array $sale_details = [];
    public array $sale_quotas = [];
    public array $sale_guides = [];

    // Si ahi DETRACCIÓN
    public DetractionModel $detractionModel;

    // Si es NOTA CREDITO/DEBITO
    public SaleReferenceModel $saleReferenceModel;
}
