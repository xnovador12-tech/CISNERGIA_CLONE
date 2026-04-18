<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MetaWebhookController extends Controller
{
    /**
     * Paso 1: Verificación de Meta (GET)
     */
    public function verify(Request $request)
    {
        $verify_token = env('META_VERIFY_TOKEN');

        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode === 'subscribe' && $token === $verify_token) {
            Log::info('Webhook de Meta verificado exitosamente.');
            return response($challenge, 200);
        }

        Log::error('Fallo en la verificación del Webhook de Meta.');
        return response()->json(['error' => 'Token de verificación inválido'], 403);
    }

    /**
     * Paso 2: Recepción de Mensajes y Leads (POST)
     */
    public function handle(Request $request)
    {
        $data = $request->all();

        // Guardamos todo el JSON en los logs para que veas qué te manda Meta
        Log::info('Datos recibidos de Meta:', $data);

        // Meta siempre envía el objeto 'object' == 'page' o 'instagram'
        if (isset($data['object'])) {
            foreach ($data['entry'] as $entry) {
                // Aquí es donde extraeremos los mensajes en el futuro
                // $mensaje = $entry['messaging'][0];
            }

            // SIEMPRE debes responder 200 OK rápido, sino Meta te bloquea
            return response('EVENT_RECEIVED', 200);
        }

        return response()->json(['error' => 'No es un evento de página'], 404);
    }
}