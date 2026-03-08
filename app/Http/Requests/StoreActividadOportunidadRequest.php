<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActividadOportunidadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'tipo'             => 'required|in:llamada,email,reunion,visita_tecnica,whatsapp',
            'titulo'           => 'required|string|max:200',
            'descripcion'      => 'nullable|string',
            'fecha_programada' => 'required|date',
            'prioridad'        => 'nullable|in:alta,media,baja',
            'user_id'          => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required'             => 'Debe seleccionar el tipo de actividad.',
            'tipo.in'                   => 'El tipo de actividad seleccionado no es válido.',
            'titulo.required'           => 'El título es obligatorio.',
            'titulo.max'                => 'El título no puede superar los 200 caracteres.',
            'fecha_programada.required' => 'La fecha y hora son obligatorias.',
            'fecha_programada.date'     => 'La fecha no tiene un formato válido.',
            'prioridad.in'              => 'La prioridad seleccionada no es válida.',
            'user_id.exists'            => 'El responsable seleccionado no existe.',
        ];
    }

    public function attributes(): array
    {
        return [
            'tipo'             => 'tipo de actividad',
            'titulo'           => 'título',
            'fecha_programada' => 'fecha y hora',
            'prioridad'        => 'prioridad',
            'user_id'          => 'responsable',
        ];
    }
}
