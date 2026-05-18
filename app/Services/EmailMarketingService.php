<?php

namespace App\Services;

use App\Mail\CampanaMarketing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class EmailMarketingService
{
    /**
     * Envía una campaña de correos corporativos.
     *
     * Mejoras anti-spam aplicadas:
     * 1. Usa Mailable en lugar de Mail::html() — genera headers MIME completos.
     * 2. Incluye versión texto plano automáticamente (penalización de spam sin ella).
     * 3. Logo incrustado por CID (Content-ID) — 100% compatible con Gmail/Outlook.
     * 4. Headers adicionales: X-Mailer, X-Priority, Precedence, List-Unsubscribe.
     * 5. Reply-To correctamente configurado.
     */
    public function dispatchCampaign(
        array   $recipients,
        string  $subject,
        string  $htmlContent,
        ?string $logoPath  = null,
        array   $adjuntos  = []
    ): array {

        Log::info('EmailMarketingService: ▶ Iniciando campaña', [
            'asunto'        => $subject,
            'destinatarios' => count($recipients),
            'logo_path'     => $logoPath ?? 'ninguno',
            'adjuntos'      => count($adjuntos),
        ]);

        // ── 1. Verificar configuración de correo ───────────────────────────
        $this->logMailConfig();

        $mailFrom = config('mail.from.address');
        if (empty($mailFrom)) {
            Log::error('EmailMarketingService: ✘ MAIL_FROM_ADDRESS no definido — Abortando.');
            return [
                'success' => false,
                'enviados' => 0, 'fallidos' => 0, 'invalidos' => 0,
                'mensaje'  => 'Error de configuración: MAIL_FROM_ADDRESS no está definido en .env',
            ];
        }

        // ── 2. Preparar logo (Ruta Absoluta para CID) ──────────────────────
        // Buscamos la ruta real del archivo en el sistema para que Laravel 
        // pueda adjuntarlo e incrustarlo con $message->embed()
        $logoFullPath = null;
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            $logoFullPath = Storage::disk('public')->path($logoPath);
            Log::info("EmailMarketingService: ✔ Ruta absoluta del logo obtenida: {$logoFullPath}");
        } elseif ($logoPath) {
            Log::warning("EmailMarketingService: ⚠ Logo no encontrado en disco: {$logoPath} — Se enviará sin logo.");
        }

        // ── 3. Enviar a cada destinatario ──────────────────────────────────
        $enviados         = 0;
        $fallidos         = 0;
        $invalidos        = 0;
        $detallesFallidos = [];

        foreach ($recipients as $rawEmail) {
            $email = trim($rawEmail);

            if (empty($email)) {
                continue;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Log::warning("EmailMarketingService: ✘ Email inválido omitido: '{$email}'");
                $invalidos++;
                continue;
            }

            Log::info("EmailMarketingService: → Enviando a: {$email}");


            try {
                // Instanciamos el Mailable pasando la ruta absoluta del logo
                Mail::to($email)
                    ->send(
                        (new CampanaMarketing($htmlContent, $logoFullPath, $adjuntos))
                            ->subject($subject)
                    );

                Log::info("EmailMarketingService: ✔ Enviado exitosamente a: {$email}");
                $enviados++;

            } catch (Exception $e) {
                Log::error("EmailMarketingService: ✘ Fallo al enviar a {$email}", [
                    'error'           => $e->getMessage(),
                    'exception'       => get_class($e),
                    'file'            => $e->getFile(),
                    'line'            => $e->getLine(),
                    'posibles_causas' => [
                        'Credenciales SMTP incorrectas (MAIL_USERNAME / MAIL_PASSWORD en .env)',
                        'Host SMTP no alcanzable (MAIL_HOST / MAIL_PORT)',
                        'Puerto bloqueado por firewall del servidor (probar 587 vs 465 vs 25)',
                        'Límite de envío del proveedor SMTP alcanzado',
                        'El destinatario fue rechazado por el servidor remoto',
                        'SSL/TLS no configurado correctamente (MAIL_ENCRYPTION)',
                    ],
                ]);
                $fallidos++;
                $detallesFallidos[] = $email;
            }
        }

        // ── 4. Resumen final ───────────────────────────────────────────────
        Log::info('EmailMarketingService: ■ Campaña finalizada', [
            'enviados'          => $enviados,
            'fallidos'          => $fallidos,
            'invalidos'         => $invalidos,
            'fallidos_detalle'  => $detallesFallidos,
        ]);

        $partes = ["Campaña procesada: {$enviados} enviado(s)"];
        if ($fallidos  > 0) $partes[] = "{$fallidos} fallido(s)";
        if ($invalidos > 0) $partes[] = "{$invalidos} inválido(s)";
        $partes[] = 'Revisa storage/logs/laravel.log para el detalle.';

        return [
            'success'          => $enviados > 0,
            'enviados'         => $enviados,
            'fallidos'         => $fallidos,
            'invalidos'        => $invalidos,
            'fallidos_detalle' => $detallesFallidos,
            'mensaje'          => implode(' — ', $partes),
        ];
    }

    /**
     * Registra en logs la configuración SMTP activa para facilitar diagnóstico.
     */
    private function logMailConfig(): void
    {
        Log::info('EmailMarketingService: ⚙ Configuración SMTP activa', [
            'driver'      => config('mail.default'),
            'host'        => config('mail.mailers.smtp.host')       ?? 'NO DEFINIDO',
            'port'        => config('mail.mailers.smtp.port')       ?? 'NO DEFINIDO',
            'encryption'  => config('mail.mailers.smtp.encryption') ?? 'NO DEFINIDO',
            'username'    => config('mail.mailers.smtp.username')
                                ? substr(config('mail.mailers.smtp.username'), 0, 4) . '****'
                                : 'NO DEFINIDO',
            'from_address'=> config('mail.from.address')  ?? 'NO DEFINIDO',
            'from_name'   => config('mail.from.name')     ?? 'NO DEFINIDO',
        ]);
    }
}