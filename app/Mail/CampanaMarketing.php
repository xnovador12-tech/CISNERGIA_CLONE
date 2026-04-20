<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CampanaMarketing extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param string      $htmlContent Contenido del editor Quill (HTML)
     * @param string|null $logoPath    Ruta absoluta del logo en el disco
     * @param array       $adjuntos    Lista de archivos: [['path','name','mime'], ...]
     */
    public function __construct(
        public readonly string  $htmlContent,
        public readonly ?string $logoPath = null,
        public readonly array   $adjuntos = [],
    ) {}

    // ── Envelope: remitente, asunto y headers anti-spam ───────────────────
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address'),
                config('mail.from.name', 'Cisnergia Perú')
            ),
            // Reply-To igual al from para evitar señales de suplantación
            replyTo: [
                new \Illuminate\Mail\Mailables\Address(
                    config('mail.from.address'),
                    config('mail.from.name', 'Cisnergia Perú')
                ),
            ],
        );
    }

    // ── Headers adicionales que mejoran la entregabilidad ────────────────
    public function headers(): Headers
    {
        return new Headers(
            // Identifica el sistema que genera el correo (buena práctica)
            text: [
                'X-Mailer'         => 'Cisnergia-CRM/1.0',
                'X-Priority'       => '3',           // Normal (no urgente = menos sospechoso)
                'Precedence'       => 'bulk',        // Indica envío masivo de forma transparente
                'List-Unsubscribe' => '<mailto:' . config('mail.from.address') . '?subject=Unsubscribe>',
            ],
        );
    }

    // ── Vista HTML + texto plano (obligatorio anti-spam) ─────────────────
    public function content(): Content
    {
        return new Content(
            view: 'emails.campana_marketing',
            text: 'emails.campana_marketing_text',
        );
    }

    // ── Adjuntos ──────────────────────────────────────────────────────────
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->adjuntos as $index => $file) {
            if (!file_exists($file['path'])) {
                Log::warning("CampanaMarketing Mailable: Adjunto #{$index} no encontrado — omitido.", [
                    'path' => $file['path'],
                    'name' => $file['name'],
                ]);
                continue;
            }

            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath($file['path'])
                ->as($file['name'])
                ->withMime($file['mime']);

            Log::info("CampanaMarketing Mailable: Adjunto añadido: {$file['name']}");
        }

        return $attachments;
    }
}