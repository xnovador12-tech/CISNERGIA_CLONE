<?php

namespace App\Http\Controllers;

use App\Models\InformacionEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class admin_InformacionController extends Controller
{
    /**
     * Muestra el formulario de edición de la información de la empresa.
     * Como solo existe un registro (ID=1), no hay listado ni "create".
     * El método index actúa como vista de edición directamente.
     */
    public function index()
    {
        $info = InformacionEmpresa::current();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.informacion.index', compact('info'));
    }

    /**
     * Actualiza la información de la empresa.
     * Recibe todos los campos editables, valida y guarda.
     * Si se sube un nuevo logo, reemplaza el anterior en storage.
     */
    public function update(Request $request, $id = 1)
    {
        // Normalizar URLs de redes sociales: si el usuario no escribió
        // el protocolo, le agregamos 'https://' automáticamente para
        // que la validación 'url' las acepte sin problemas.
        foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $red) {
            $valor = $request->input($red);
            if (!empty($valor) && !preg_match('~^https?://~i', $valor)) {
                $request->merge([$red => 'https://' . ltrim($valor, '/')]);
            }
        }

        $request->validate([
            'razon_social'     => 'required|string|max:255',
            'ruc'              => 'required|string|size:11',
            'nombre_comercial' => 'nullable|string|max:255',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',

            'direccion'        => 'required|string|max:255',
            'telefono'         => 'nullable|string|max:50',
            'celular'          => 'nullable|string|max:50',
            'whatsapp'         => 'nullable|string|max:50',
            'email'            => 'required|email|max:255',
            'horario_atencion' => 'nullable|string|max:255',

            'facebook'         => 'nullable|url|max:255',
            'instagram'        => 'nullable|url|max:255',
            'linkedin'         => 'nullable|url|max:255',
            'youtube'          => 'nullable|url|max:255',
        ], [
            'ruc.size'        => 'El RUC debe tener exactamente 11 dígitos.',
            'logo.image'      => 'El logo debe ser una imagen válida.',
            'logo.mimes'      => 'El logo debe ser JPG, PNG, WEBP o SVG.',
            'logo.max'        => 'El logo no puede pesar más de 2 MB.',
            'email.email'     => 'El correo debe tener un formato válido.',
            'facebook.url'    => 'La URL de Facebook no es válida.',
            'instagram.url'   => 'La URL de Instagram no es válida.',
            'linkedin.url'    => 'La URL de LinkedIn no es válida.',
            'youtube.url'     => 'La URL de YouTube no es válida.',
        ]);

        $info = InformacionEmpresa::current();

        $data = $request->only([
            'razon_social', 'ruc', 'nombre_comercial',
            'direccion', 'telefono', 'celular', 'whatsapp', 'email', 'horario_atencion',
            'facebook', 'instagram', 'linkedin', 'youtube',
        ]);

        // Manejo del logo: si llega un archivo nuevo, reemplaza el anterior
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($info->logo && Storage::disk('public')->exists($info->logo)) {
                Storage::disk('public')->delete($info->logo);
            }
            // Guardar nuevo logo
            $data['logo'] = $request->file('logo')->store('empresa', 'public');
        }

        $info->update($data);

        return redirect()
            ->route('admin-informacion.index')
            ->with('update_registration', 'ok');
    }
}
