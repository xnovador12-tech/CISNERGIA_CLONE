<?php

namespace App\Http\Controllers\ApiOse\Models;

class SaleDetailModel
{
    public int $item;
    public ProductModel $productModel;
    public string $amout;
    public string $unit_value;
    public string $price;
    public string $price_type_code = '01';
    public string $total_value;
    public string $igv;
    public string $total;
}
