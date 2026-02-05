<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Oportunidad;
use Illuminate\Support\Str;

echo "Total oportunidades: " . Oportunidad::count() . "\n";

foreach (Oportunidad::take(5)->get() as $o) {
    echo $o->id . " | " . $o->codigo . " | slug: [" . $o->slug . "]\n";
}

echo "\nListo!\n";
