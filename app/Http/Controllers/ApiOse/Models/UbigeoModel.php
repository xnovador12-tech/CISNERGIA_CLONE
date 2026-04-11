<?php

namespace App\Http\Controllers\ApiOse\Models;

class UbigeoModel
{
    public function __construct(
        public string $code,
        public string $address
    ) {}
}
