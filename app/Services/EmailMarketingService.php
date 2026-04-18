<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class EmailMarketingService
{
    /**
     * Envía una campaña de correos en segundo plano a múltiples destinatarios.
     * Cero base de datos.
     */
public function dispatchCampaign(array $recipients, string $subject, string $htmlContent, ?string $logoPath = null, array $adjuntos = []): array
    {
        $enviados = 0;
        $fallidos = 0;

        // Armamos el envoltorio HTML para que se vea corporativo y no caiga en Spam
        $logoHtml = '';
        if ($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath)) {
            // Generamos la URL absoluta pública del logo
            $logoUrl = asset('storage/' . $logoPath);
            $logoHtml = "<div style='text-align: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;'>
                            <img src='{$logoUrl}' alt='Cisnergia' style='max-width: 200px; height: auto;'>
                         </div>";
        }

        $cuerpoCorporativo = "
            <div style='font-family: Arial, sans-serif; color: #334155; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;'>
                {$logoHtml}
                <div style='font-size: 15px; line-height: 1.6;'>
                    {$htmlContent}
                </div>
                <div style='margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8; text-align: center;'>
                    © " . date('Y') . " Cisnergia Perú. Todos los derechos reservados.<br>
                    Este es un correo oficial de la empresa.
                </div>
            </div>
        ";

        foreach ($recipients as $email) {
            $email = trim($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

            try {
                Mail::html($cuerpoCorporativo, function ($message) use ($email, $subject, $adjuntos) {
                    $message->to($email)
                            ->subject($subject)
                            ->from(config('mail.from.address', 'ventas@cisnergia.com'), config('mail.from.name', 'Cisnergia Solar'));
                    
                    // Procesar archivos adjuntos si los hay
                    foreach ($adjuntos as $file) {
                        $message->attach($file['path'], [
                            'as' => $file['name'],
                            'mime' => $file['mime']
                        ]);
                    }
                });
                $enviados++;
            } catch (Exception $e) {
                Log::error("Error enviando email a {$email}: " . $e->getMessage());
                $fallidos++;
            }
        }

        return [
            'success' => true,
            'mensaje' => "Campaña procesada: {$enviados} correos enviados exitosamente."
        ];
    }
}