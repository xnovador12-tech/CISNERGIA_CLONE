<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #1a2a3a, #2c3e50); padding: 30px 40px; text-align: center;">
                            <h1 style="color:#ffffff; margin:0; font-size:22px; letter-spacing:1px;">CISNERGIA PER&Uacute;</h1>
                            <p style="color:#8fa4b8; margin:5px 0 0; font-size:13px;">Comprobante de Pago</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 35px 40px;">
                            <p style="color:#333; font-size:15px; margin:0 0 20px;">
                                Estimado/a <strong>{{ $venta->cliente->nombre_completo ?? 'Cliente' }}</strong>,
                            </p>
                            <p style="color:#555; font-size:14px; line-height:1.6; margin:0 0 25px;">
                                Le informamos que su comprobante de pago ha sido generado exitosamente.
                                Encontrar&aacute; el documento adjunto en formato PDF.
                            </p>

                            {{-- Resumen --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f9fa; border-radius:8px; margin-bottom:25px;">
                                <tr>
                                    <td style="padding: 20px 25px;">
                                        <table width="100%" cellpadding="6" cellspacing="0">
                                            <tr>
                                                <td style="color:#888; font-size:12px; text-transform:uppercase; padding-bottom:4px;">Comprobante</td>
                                                <td style="color:#333; font-size:14px; font-weight:bold; text-align:right; padding-bottom:4px;">
                                                    {{ $venta->tipocomprobante->name ?? 'Comprobante' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#888; font-size:12px; text-transform:uppercase; padding-bottom:4px;">N&uacute;mero</td>
                                                <td style="color:#333; font-size:14px; font-weight:bold; text-align:right; padding-bottom:4px;">
                                                    {{ $venta->numero_comprobante }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#888; font-size:12px; text-transform:uppercase; padding-bottom:4px;">Fecha</td>
                                                <td style="color:#333; font-size:14px; text-align:right; padding-bottom:4px;">
                                                    {{ $venta->created_at->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border-top:1px solid #dee2e6; padding-top:10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="color:#888; font-size:12px; text-transform:uppercase;">Total</td>
                                                <td style="color:#1a7f37; font-size:20px; font-weight:bold; text-align:right;">
                                                    S/ {{ number_format($venta->total, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#555; font-size:13px; line-height:1.6; margin:0;">
                                Si tiene alguna consulta sobre este comprobante, no dude en contactarnos.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#f8f9fa; padding: 20px 40px; border-top:1px solid #eee; text-align:center;">
                            <p style="color:#999; font-size:11px; margin:0 0 5px;">
                                Cisnergia Per&uacute; &bull; Soluciones Energ&eacute;ticas
                            </p>
                            <p style="color:#aaa; font-size:10px; margin:0;">
                                Este es un correo autom&aacute;tico, por favor no responda a este mensaje.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
