<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionCrmLeida extends Model
{
    public $timestamps = false;

    protected $table = 'notificaciones_crm_leidas';

    protected $fillable = [
        'user_id',
        'actividad_crm_id',
        'prospecto_id',
        'tipo',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actividad()
    {
        return $this->belongsTo(ActividadCrm::class, 'actividad_crm_id');
    }

    public function prospecto()
    {
        return $this->belongsTo(Prospecto::class, 'prospecto_id');
    }
}
