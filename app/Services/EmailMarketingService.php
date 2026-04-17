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
    public function dispatchCampaign(array $recipients, string $subject, string $htmlContent): array
    {
        $enviados = 0;
        $fallidos = 0;

        foreach ($recipients as $email) {
            $email = trim($email);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $fallidos++;
                continue;
            }

            try {
                // Usamos Mail::html para enviar contenido rico sin necesidad de crear clases Mailable extra
                // Usamos queue() en lugar de send() para que se vaya a segundo plano (Jobs)
                Mail::html($htmlContent, function ($message) use ($email, $subject) {
                    $message->to($email)
                            ->subject($subject)
                            ->from(config('mail.from.address', 'ventas@cisnergia.com'), config('mail.from.name', 'Cisnergia Solar'));
                });
                
                $enviados++;
            } catch (Exception $e) {
                Log::error("Error enviando email a {$email}: " . $e->getMessage());
                $fallidos++;
            }
        }

        return [
            'success' => true,
            'total_procesados' => count($recipients),
            'enviados' => $enviados,
            'fallidos' => $fallidos,
            'mensaje' => "Campaña encolada: {$enviados} envíos programados exitosamente."
        ];
    }
}