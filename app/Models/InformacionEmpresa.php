<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionEmpresa extends Model
{
    use HasFactory;

    protected $table = 'informacion_empresa';

    protected $fillable = [
        'razon_social',
        'ruc',
        'nombre_comercial',
        'logo',
        'direccion',
        'telefono',
        'celular',
        'whatsapp',
        'email',
        'horario_atencion',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
    ];

    /**
     * Devuelve el único registro de información de la empresa.
     * Si por alguna razón no existe, lo crea con valores por defecto.
     * Esto garantiza que el sistema nunca falle por falta del registro.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'razon_social' => 'CISNERGIA PERÚ',
                'ruc'          => '00000000000',
                'direccion'    => 'Por configurar',
                'email'        => 'info@cisnergia.pe',
            ]
        );
    }

    /**
     * URL pública del logo (o un placeholder si no se ha subido).
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && \Storage::disk('public')->exists($this->logo)) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/logo_v.png'); // logo por defecto del proyecto
    }
}
