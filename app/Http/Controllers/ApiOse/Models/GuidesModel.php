<?php

namespace App\Http\Controllers\ApiOse\Models;

class GuidesModel
{
    // Detectar el emisor
    public BranchModel $branchModel;

    // Cliente
    public ClientModel $clientModel;

    // Datos que lleva la guía
    public string $voucher_type_code;
    public string $serie;
    public int $correlative;
    public string $issue_date;
    public string $transfer_date;
    public string $hour;
    public ?ReasonTransferModel $reasonTransferModel = null;
    public string $weight;
    public string $unit_code;
    public string $sunat_indicator;
    public ?TransportTypeModel $transportTypeModel = null;
    public ?CarrierModel $carrierModel = null;
    public ?DriveModel $driveModel = null;
    public UbigeoModel $origin_ubigeo;
    public UbigeoModel $destination_ubigeo;
    public ?string $observation = null;
    public string $xml_name;

    // Detalles
    public array $guide_details = [];
    public array $guide_sales = [];
    public array $guide_plates = [];
}
