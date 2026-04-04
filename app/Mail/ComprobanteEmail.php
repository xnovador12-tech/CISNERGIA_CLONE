<?php

namespace App\Mail;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComprobanteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Sale $venta;

    public function __construct(Sale $venta)
    {
        $this->venta = $venta;
    }

    public function envelope(): Envelope
    {
        $numero = $this->venta->numero_comprobante ?? $this->venta->codigo;

        return new Envelope(
            subject: "Su Comprobante {$numero} | Cisnergia Perú",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comprobante',
            with: ['venta' => $this->venta],
        );
    }

    public function attachments(): array
    {
        $pedido = $this->venta->pedido;

        if (!$pedido) {
            return [];
        }

        $pedido->load([
            'cliente', 'detalles', 'usuario', 'cuotas',
            'venta.tipocomprobante', 'venta.mediopago',
        ]);

        return [
            Attachment::fromData(
                fn () => Pdf::loadView(
                    'ADMINISTRADOR.PRINCIPAL.ventas.pedidos.voucher_pdf',
                    ['pedido' => $pedido]
                )->output(),
                'Comprobante-' . $pedido->codigo . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
