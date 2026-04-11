<?php

namespace App\Http\Controllers\ApiOse\Models;

class ProductModel
{
    public string $code;
    public string $description;
    public string $unit_code;
    public AffectTypeModel $affectTypeModel;
}
