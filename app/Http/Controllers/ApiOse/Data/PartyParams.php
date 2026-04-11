<?php

namespace App\Http\Controllers\ApiOse\Data;

class PartyParams
{
    public string $document_type;
    public string $document;
    public string $company_name;
    public ?string $trade_name = null;
    public ?string $ubigeo = null;
    public ?string $local_code = null;
    public ?string $province = null;
    public ?string $department = null;
    public ?string $district = null;
    public ?string $address = null;
    public ?string $country_code = null;
}
