<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOportunidadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nombre'                  => 'required|string|max:200',
            'prospecto_id'            => 'required|exists:prospectos,id',
            'tipo_proyecto'           => 'required|in:residencial,comercial,industrial,agricola',
            'tipo_oportunidad'        => 'required|in:producto,servicio,mixto',
            'monto_estimado'          => 'required|numeric|min:0',
            'fecha_cierre_estimada'   => 'required|date|after:today',
            'tipo_servicio'           => 'nullable|in:instalacion,mantenimiento_preventivo,mantenimiento_correctivo,ampliacion,otro',
            'servicio_id'             => 'nullable|exists:servicios,id',
            'descripcion_servicio'    => 'nullable|string',
            'requiere_visita_tecnica' => 'nullable|boolean',
            'fecha_visita_programada' => 'nullable|date',
            'ubicacion_visita'        => 'nullable|string|max:300',
            'tecnico_visita_id'       => 'nullable|exists:users,id',
            'descripcion'             => 'nullable|string',
            'observaciones'           => 'nullable|string',
            'user_id'                 => 'nullable|exists:users,id',
            'items'                   => 'nullable|array',
            'items.*.producto_id'     => 'required_with:items|exists:productos,id',
            'items.*.cantidad'        => 'required_with:items|numeric|min:0.01',
            'items.*.precio_unitario'  => 'nullable|numeric|min:0',
            'items.*.notas'           => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'                => 'El nombre de la oportunidad es obligatorio.',
            'nombre.max'                     => 'El nombre no puede superar los 200 caracteres.',
            'prospecto_id.required'          => 'Debe seleccionar un prospecto.',
            'prospecto_id.exists'            => 'El prospecto seleccionado no existe.',
            'tipo_proyecto.required'         => 'El tipo de proyecto es obligatorio.',
            'tipo_proyecto.in'               => 'El tipo de proyecto seleccionado no es válido.',
            'tipo_oportunidad.required'      => 'El tipo de oportunidad es obligatorio.',
            'tipo_oportunidad.in'            => 'El tipo de oportunidad seleccionado no es válido.',
            'monto_estimado.required'        => 'El monto estimado es obligatorio.',
            'monto_estimado.numeric'         => 'El monto estimado debe ser un número.',
            'monto_estimado.min'             => 'El monto estimado debe ser mayor o igual a 0.',
            'fecha_cierre_estimada.required' => 'La fecha de cierre estimada es obligatoria.',
            'fecha_cierre_estimada.date'     => 'La fecha de cierre no tiene un formato válido.',
            'fecha_cierre_estimada.after'    => 'La fecha de cierre debe ser posterior a hoy.',
            'tipo_servicio.in'               => 'El tipo de servicio seleccionado no es válido.',
            'fecha_visita_programada.date'   => 'La fecha de visita no tiene un formato válido.',
            'user_id.exists'                 => 'El vendedor seleccionado no existe.',
            'items.*.producto_id.required_with' => 'Cada ítem debe tener un producto seleccionado.',
            'items.*.producto_id.exists'     => 'Uno de los productos seleccionados no existe.',
            'items.*.cantidad.required_with' => 'Cada ítem debe tener una cantidad.',
            'items.*.cantidad.min'           => 'La cantidad debe ser mayor a 0.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'                  => 'nombre de la oportunidad',
            'prospecto_id'            => 'prospecto',
            'tipo_proyecto'           => 'tipo de proyecto',
            'tipo_oportunidad'        => 'tipo de oportunidad',
            'monto_estimado'          => 'monto estimado',
            'fecha_cierre_estimada'   => 'fecha de cierre estimada',
            'tipo_servicio'           => 'tipo de servicio',
            'descripcion_servicio'    => 'descripción del servicio',
            'requiere_visita_tecnica' => 'requiere visita técnica',
            'fecha_visita_programada' => 'fecha de visita programada',
            'descripcion'             => 'descripción',
            'observaciones'           => 'observaciones',
            'user_id'                 => 'vendedor asignado',
        ];
    }
}
