<?php

namespace App\Http\Controllers\ApiOse\Data;

use App\Http\Controllers\ApiOse\Models\EmitterModel;

class SendDocumentParams
{
    public EmitterModel $emitterModel;
    public string $zipName;
    public string $codedZip;
    public string $codedSha;
}
