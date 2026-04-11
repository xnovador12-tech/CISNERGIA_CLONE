<?php

namespace App\Http\Controllers\ApiOse\Data;

class OperationResult
{
    public function __construct(
        public bool $estado = false,
        public string $message = '',
        public ?string $dataResponse = ''
    ) {}
}
