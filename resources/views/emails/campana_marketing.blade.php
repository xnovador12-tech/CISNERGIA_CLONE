<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('mail.from.name', 'Cisnergia Perú') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f2f5;font-family:Georgia,'Times New Roman',serif;-webkit-text-size-adjust:100%;mso-line-height-rule:exactly;">

    {{-- Preheader oculto: aparece en la vista previa del cliente de correo --}}
    <div style="display:none;font-size:1px;color:#f0f2f5;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;">
        Comunicación oficial de Cisnergia Perú — {{ strip_tags(Str::limit($htmlContent, 90)) }}
    </div>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f0f2f5"
           style="background-color:#f0f2f5;min-width:100%;">
        <tr>
            <td align="center" valign="top" style="padding:32px 16px;">

                <table width="600" border="0" cellpadding="0" cellspacing="0"
                       style="max-width:600px;width:100%;background-color:#ffffff;
                              border-radius:8px;overflow:hidden;
                              border:1px solid #dee2e6;">

                    {{-- HEADER --}}
                    <tr>
                        <td bgcolor="#212529" align="center" valign="middle"
                            style="background-color:#212529;padding:22px 40px;">
                            <p style="margin:0;font-family:Arial,sans-serif;font-size:10px;
                                      letter-spacing:3px;text-transform:uppercase;color:#adb5bd;">
                                Comunicación Oficial &nbsp;·&nbsp; Cisnergia Perú
                            </p>
                        </td>
                    </tr>

                    {{--
                        LOGO incrustado en base64.

                        POR QUÉ {!! !!} Y NO {{ }}:
                        El string base64 contiene los caracteres +, = y /
                        que Blade escapa con htmlspecialchars() cuando usas {{ }},
                        convirtiendo por ejemplo + en &amp;#43; y rompiendo
                        completamente la cadena de imagen.
                        Con {!! !!} se imprime sin escape — seguro porque
                        nosotros mismos generamos el base64 en el service.
                    --}}
                    @if($logoPath)
                    <tr>
                        <td align="center" valign="middle"
                            style="padding:28px 40px 20px;border-bottom:1px solid #e9ecef;background-color:#ffffff;">
                            <img src="{{ $message->embed($logoPath) }}"
                                 alt="Cisnergia Perú"
                                 width="200"
                                 style="max-width:200px;height:auto;display:block;margin:0 auto;border:0;outline:none;text-decoration:none;">
                        </td>
                    </tr>
                    @endif

                    {{-- CUERPO DEL MENSAJE --}}
                    <tr>
                        <td valign="top" style="padding:36px 40px;background-color:#ffffff;">
                            <div style="font-family:Georgia,'Times New Roman',serif;
                                        font-size:15px;line-height:1.85;color:#343a40;">
                                {!! $htmlContent !!}
                            </div>
                        </td>
                    </tr>

                    {{-- FIRMA --}}
                    <tr>
                        <td valign="top"
                            style="padding:20px 40px;background-color:#ffffff;
                                   border-top:2px solid #212529;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <p style="margin:0 0 2px;font-family:Arial,sans-serif;
                                                  font-size:13px;font-weight:bold;color:#212529;">
                                            Equipo Comercial — Cisnergia Perú
                                        </p>
                                        <p style="margin:0;font-family:Arial,sans-serif;
                                                  font-size:12px;color:#6c757d;">
                                            {{ config('mail.from.address') }}
                                        </p>
                                    </td>
                                    <td align="right" valign="middle">
                                        <p style="margin:0;font-family:Arial,sans-serif;
                                                  font-size:10px;color:#adb5bd;
                                                  text-transform:uppercase;letter-spacing:1.5px;">
                                            Energía Solar
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td align="center" bgcolor="#f8f9fa" valign="top"
                            style="background-color:#f8f9fa;padding:20px 40px;
                                   border-top:1px solid #dee2e6;">
                            <p style="margin:0 0 6px;font-family:Arial,sans-serif;
                                      font-size:11px;color:#6c757d;line-height:1.6;">
                                © {{ date('Y') }} <strong style="color:#212529;">Cisnergia Perú</strong>.
                                Todos los derechos reservados.
                            </p>
                            <p style="margin:0;font-family:Arial,sans-serif;
                                      font-size:10px;color:#adb5bd;line-height:1.6;">
                                Este es un correo oficial. Si no solicitaste esta información,
                                puedes ignorarlo o escribirnos a
                                <a href="mailto:{{ config('mail.from.address') }}"
                                   style="color:#495057;text-decoration:underline;">
                                    {{ config('mail.from.address') }}
                                </a>
                                para ser removido de nuestra lista.
                            </p>
                        </td>
                    </tr>

                </table>

                <table width="600" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;">
                    <tr>
                        <td style="padding:16px 0;text-align:center;">
                            <p style="margin:0;font-family:Arial,sans-serif;font-size:10px;color:#adb5bd;">
                                Cisnergia Perú &nbsp;·&nbsp; Sistema CRM interno
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>