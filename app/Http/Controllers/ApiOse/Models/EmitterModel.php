<?php

namespace App\Http\Controllers\ApiOse\Models;

class EmitterModel
{
    public string $document_type = '6';
    public string $document;
    public string $company_name;
    public ?string $trade_name;
    public string $country_code = 'PE';
    public string $detraction_account;
    public string $client_id;
    public string $client_secret;
    public string $secondary_user;
    public string $secondary_user_password;
    public string $certificate_name;
    public string $certificate_password;
    public string $certificate_start_date;
    public string $certificate_end_date;
}
