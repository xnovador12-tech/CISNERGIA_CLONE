{{ config('mail.from.name', 'Cisnergia Perú') }} — Comunicación Oficial
================================================================================

{!! strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>'], "\n", $htmlContent)) !!}

--------------------------------------------------------------------------------
Equipo Comercial — Cisnergia Perú
{{ config('mail.from.address') }}

© {{ date('Y') }} Cisnergia Perú. Todos los derechos reservados.

Este es un correo oficial. Si no solicitaste esta información, puedes ignorarlo
o escribirnos a {{ config('mail.from.address') }} para ser removido de la lista.
