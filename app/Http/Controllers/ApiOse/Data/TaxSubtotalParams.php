<?php

namespace App\Http\Controllers\ApiOse\Data;

class TaxSubtotalParams
{
    public string $coin_code;
    public string $total;
    public string $igv;
    public ?string $percentage = null;
    public ?string $code = null;
    public string $tribute_code;
    public string $tribute_name;
    public string $tribute_type;
}
