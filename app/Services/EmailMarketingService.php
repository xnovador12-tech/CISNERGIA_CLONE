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

        // ── 3. Encolar envío a cada destinatario (asíncrono) ───────────────
        $encolados   = 0;
        $invalidos   = 0;
        $fallosCola  = 0;

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

            try {
                Mail::to($email)
                    ->queue(
                        (new CampanaMarketing($htmlContent, $logoFullPath, $adjuntos))
                            ->subject($subject)
                    );
                $encolados++;
            } catch (Exception $e) {
                Log::error("EmailMarketingService: ✘ No se pudo encolar el envío a {$email}", [
                    'error' => $e->getMessage(),
                ]);
                $fallosCola++;
            }
        }

        Log::info('EmailMarketingService: ■ Campaña encolada', [
            'encolados'  => $encolados,
            'invalidos'  => $invalidos,
            'fallos_cola'=> $fallosCola,
        ]);

        $partes = ["Campaña en cola: {$encolados} correo(s) listo(s) para enviarse"];
        if ($invalidos  > 0) $partes[] = "{$invalidos} inválido(s) omitido(s)";
        if ($fallosCola > 0) $partes[] = "{$fallosCola} fallaron al encolar";
        $partes[] = 'El worker procesará los envíos en los próximos minutos.';

        return [
            'success'   => $encolados > 0,
            'encolados' => $encolados,
            'enviados'  => $encolados,
            'fallidos'  => 0,
            'invalidos' => $invalidos,
            'mensaje'   => implode(' — ', $partes),
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