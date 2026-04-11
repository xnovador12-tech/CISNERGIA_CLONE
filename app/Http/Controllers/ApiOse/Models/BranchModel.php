<?php

namespace App\Http\Controllers\ApiOse\Models;

class BranchModel
{
    public EmitterModel $emitterModel;
    public string $local_code;
    public string $department;
    public string $province;
    public string $district;
    public string $ubigeo;
    public ?string $address = null;
}
