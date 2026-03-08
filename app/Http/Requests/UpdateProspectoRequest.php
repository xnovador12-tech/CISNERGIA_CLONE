<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProspectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $prospectoId = $this->route('prospecto')?->id;

        return [
            'nombre'          => 'required|string|max:100',
            'apellidos'       => 'nullable|string|max:100',
            'razon_social'    => 'nullable|string|max:200',
            'ruc'             => 'nullable|string|size:11|unique:prospectos,ruc,' . $prospectoId,
            'dni'             => 'nullable|string|size:8|unique:prospectos,dni,' . $prospectoId,
            'email'           => 'nullable|email|max:150|unique:prospectos,email,' . $prospectoId,
            'telefono'        => 'nullable|string|max:20',
            'celular'         => 'nullable|string|max:20',
            'direccion'       => 'nullable|string|max:255',
            'distrito_id'     => 'nullable|exists:distritos,id',
            'tipo_persona'    => 'required|in:natural,juridica',
            'origen'          => 'required|in:sitio_web,redes_sociales,llamada,referido,ecommerce,otro', // ecommerce: solo lectura para prospectos del ecommerce
            'segmento'        => 'required|in:residencial,comercial,industrial,agricola',
            'tipo_interes'    => 'required|in:producto,servicio,ambos',
            'estado'          => 'required|in:nuevo,contactado,calificado,descartado',
            'motivo_descarte' => 'nullable|required_if:estado,descartado|string|max:255',
            'nivel_interes'   => 'nullable|in:muy_alto,alto,medio,bajo',
            'urgencia'        => 'nullable|in:inmediata,corto_plazo,mediano_plazo,largo_plazo',
            'user_id'         => 'nullable|exists:users,id',
            'fecha_proximo_contacto' => 'nullable|date',
            'observaciones'   => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            // nombre
            'nombre.required'            => 'El nombre es obligatorio.',
            'nombre.max'                 => 'El nombre no puede superar los 100 caracteres.',

            // apellidos / razón social
            'apellidos.max'              => 'Los apellidos no pueden superar los 100 caracteres.',
            'razon_social.max'           => 'La razón social no puede superar los 200 caracteres.',

            // documentos
            'ruc.size'                   => 'El RUC debe tener exactamente 11 dígitos.',
            'ruc.unique'                 => 'Ya existe otro prospecto registrado con este RUC.',
            'dni.size'                   => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique'                 => 'Ya existe otro prospecto registrado con este DNI.',

            // contacto
            'email.email'                => 'El formato del correo electrónico no es válido.',
            'email.max'                  => 'El correo no puede superar los 150 caracteres.',
            'email.unique'               => 'Ya existe otro prospecto registrado con este correo electrónico.',
            'telefono.max'               => 'El teléfono no puede superar los 20 caracteres.',
            'celular.max'                => 'El celular no puede superar los 20 caracteres.',
            'direccion.max'              => 'La dirección no puede superar los 255 caracteres.',

            // ubicación
            'distrito_id.exists'         => 'El distrito seleccionado no es válido.',

            // clasificación
            'tipo_persona.required'      => 'Debe seleccionar el tipo de persona.',
            'tipo_persona.in'            => 'El tipo de persona debe ser Natural o Jurídica.',
            'origen.required'            => 'El origen del prospecto es obligatorio.',
            'origen.in'                  => 'El origen seleccionado no es válido.',
            'segmento.required'          => 'El segmento es obligatorio.',
            'segmento.in'                => 'El segmento seleccionado no es válido.',
            'tipo_interes.required'      => 'El tipo de interés es obligatorio.',
            'tipo_interes.in'            => 'El tipo de interés seleccionado no es válido.',
            'nivel_interes.in'           => 'El nivel de interés seleccionado no es válido.',
            'urgencia.in'                => 'La urgencia seleccionada no es válida.',

            // estado
            'estado.required'            => 'El estado es obligatorio.',
            'estado.in'                  => 'El estado seleccionado no es válido.',
            'motivo_descarte.required_if' => 'Debe indicar el motivo de descarte.',
            'motivo_descarte.max'        => 'El motivo de descarte no puede superar los 255 caracteres.',

            // asignación
            'user_id.exists'             => 'El vendedor seleccionado no existe.',

            // fechas
            'fecha_proximo_contacto.date' => 'La fecha de próximo contacto no tiene un formato válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'          => 'nombre',
            'apellidos'       => 'apellidos',
            'razon_social'    => 'razón social',
            'ruc'             => 'RUC',
            'dni'             => 'DNI',
            'email'           => 'correo electrónico',
            'telefono'        => 'teléfono',
            'celular'         => 'celular',
            'direccion'       => 'dirección',
            'distrito_id'     => 'distrito',
            'tipo_persona'    => 'tipo de persona',
            'origen'          => 'origen',
            'segmento'        => 'segmento',
            'tipo_interes'    => 'tipo de interés',
            'estado'          => 'estado',
            'motivo_descarte' => 'motivo de descarte',
            'nivel_interes'   => 'nivel de interés',
            'urgencia'        => 'urgencia',
            'user_id'         => 'vendedor asignado',
            'fecha_proximo_contacto' => 'fecha de próximo contacto',
            'observaciones'   => 'observaciones',
        ];
    }
}
