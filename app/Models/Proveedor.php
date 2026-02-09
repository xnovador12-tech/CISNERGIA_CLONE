<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedors';
    protected $fillable = [
        'giro',
        'tipo_cuenta_normal',
        'entidad_bancaria_normal',
        'nro_cuenta_normal',
        'nro_cci_normal',
        'tipo_cuenta_detraccion',
        'entidad_bancaria_detraccion',
        'nro_cuenta_detraccion',
        'direccion_fiscal',
        'nro_cuenta_normal',
        'name_contacto',
        'email_contacto',
        'nro_celular_contacto',
        'tipo_id',
        'persona_id',
        'estado',
        'departamento_id',
        'provincia_id',
        'distrito_id'
    ];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // public function tipo()
    // {
    //     return $this->belongsTo(Tipo::class, 'tipo_id');
    // }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    public function tipos()
    {
        return $this->belongsToMany(Tipo::class);
    }

    public function proveedorcuentas()
{
    return $this->hasMany(Proveedorcuenta::class, 'proveedor_id');
}
}
