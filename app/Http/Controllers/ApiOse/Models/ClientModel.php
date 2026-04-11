<?php

namespace App\Http\Controllers\ApiOse\Models;

class ClientModel
{
    public string $document_type;
    public string $document;
    public string $company_name;
    public ?string $address = null;
}
