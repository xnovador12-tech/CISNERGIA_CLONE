<?php

namespace App\Http\Controllers\ApiOse\Models;

class ReasonTransferModel
{
    public function __construct(
        public string $code,
        public ?string $descripcion = null
    ) {}
}
