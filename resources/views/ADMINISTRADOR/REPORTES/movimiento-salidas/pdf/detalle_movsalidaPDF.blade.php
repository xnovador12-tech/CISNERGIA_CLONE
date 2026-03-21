<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISNERGIA | MOVIMIENTO DE SALIDA - {{ $admin_salida->codigo }} - PDF</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>

        @page { margin: 0cm 0cm; }

        .page-break { page-break-after: always; }
        .no-page-break { page-break-inside: avoid; }

        body {
            font-family: 'Outfit', sans-serif;
            margin-top: 2.0cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 1.8cm;
            background-image: url({{ public_path('images/wallpaper_document.png') }});
            background-repeat: no-repeat;
            background-size: 100% auto;
            background-attachment: fixed;
            background-position: center;
            font-size: 10px;
            color: #0f2028;
        }

        /* ─────────────────────────────
           HEADER
        ───────────────────────────── */
        header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 1.8cm;
            background-color: #eaf7fd;
        }

        .hdr-stripe {
            height: 4px;
            background-color: #3aaee0; /* fallback */
        }

        .hdr-table {
            width: 100%;
            border-collapse: collapse;
            height: calc(2.5cm - 4px);
        }

        .hdr-td-logo {
            width: 3cm;
            text-align: center;
            vertical-align: middle;
            padding: 0.2cm 0.3cm;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .hdr-td-logo img {
            width: 120px;
            filter: brightness(0) invert(1);
        }

        .hdr-td-text {
            vertical-align: middle;
            padding: 0 0.4cm;
        }

        .hdr-eyebrow {
            font-size: 7px;
            font-weight: 500;
            color: #3aaee0;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .hdr-title {
            font-size: 19px;
            font-weight: 800;
            color: #0f2028;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.1;
        }

        .hdr-title-accent { color: #4dc972; }

        .hdr-badge {
            display: inline-block;
            font-size: 8.5px;
            font-weight: 700;
            color: #0f2028;
            background-color: #4dc972;
            padding: 1px 9px;
            border-radius: 20px;
            margin-top: 3px;
            margin-right: 5px;
        }

        .hdr-date {
            font-size: 7.5px;
            color: #8fa8b2;
            letter-spacing: 0.04em;
        }

        .hdr-td-panel {
            width: 1.8cm;
            text-align: center;
            vertical-align: middle;
            padding-right: 0.2cm;
        }

        /* Grilla panel solar decorativo */
        .solar-tbl {
            border-collapse: separate;
            border-spacing: 2px;
            margin: 0 auto;
        }

        .sc {
            width: 10px; height: 10px;
            border-radius: 1px;
            background-color: rgba(58,174,224,0.3);
            border: 1px solid rgba(58,174,224,0.5);
        }

        .sc-on {
            background-color: rgba(77,201,114,0.5);
            border: 1px solid rgba(77,201,114,0.7);
        }

        /* ─────────────────────────────
           DIVISOR DE SECCIÓN
        ───────────────────────────── */
        .section { margin-bottom: 0.22cm; margin-top: 0; }

        .div-wrap { margin-bottom: 0.12cm; }

        .div-bar-sky {
            display: inline-block;
            width: 3px; height: 13px;
            background-color: #1a7abf;
            border-radius: 2px;
            vertical-align: middle;
            margin-right: 1px;
        }

        .div-bar-sol {
            display: inline-block;
            width: 3px; height: 13px;
            background-color: #2da44e;
            border-radius: 2px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .div-label {
            font-size: 8px;
            font-weight: 700;
            color: #0b4f7a;
            text-transform: uppercase;
            letter-spacing: 0.17em;
            vertical-align: middle;
        }

        .div-line {
            border: 0;
            border-top: 1px solid #dce4e8;
            margin-top: 0.1cm;
            margin-bottom: 0.15cm;
        }

        /* ─────────────────────────────
           CARDS INFO — tabla horizontal
        ───────────────────────────── */
        .info-tbl {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4px 0;
        }

        .info-tbl td { vertical-align: top; padding: 0; }

        .ic-head {
            padding: 3px 8px;
            border-radius: 3px 3px 0 0;
        }

        .ic-sky   { background-color: #0b4f7a; }
        .ic-solar { background-color: #1a6b2f; }

        .ic-dot {
            display: inline-block;
            width: 5px; height: 5px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 4px;
        }

        .dot-sky   { background-color: #3aaee0; }
        .dot-solar { background-color: #4dc972; }

        .ic-lbl {
            font-size: 6.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.75);
            text-transform: uppercase;
            letter-spacing: 0.18em;
            vertical-align: middle;
        }

        .ic-body {
            padding: 5px 8px 6px;
            border-radius: 0 0 3px 3px;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        }

        .ic-body-sky   { background-color: #eaf7fd; border-color: #b8e4f5; }
        .ic-body-solar { background-color: #eafaf0; border-color: #b8edc8; }

        .ic-val {
            font-size: 10.5px;
            font-weight: 700;
            color: #0f2028;
            text-transform: uppercase;
        }

        .pill {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            color: #1a6b2f;
            background-color: #b8edc8;
            border: 1px solid #4dc972;
            border-radius: 20px;
            padding: 1px 10px;
            text-transform: uppercase;
        }

        /* ─────────────────────────────
           BANNER RESPONSABLE
        ───────────────────────────── */
        .resp-banner {
            border-left: 4px solid #1a7abf;
            background-color: #eaf7fd;
            border-top: 1px solid #b8e4f5;
            border-right: 1px solid #b8e4f5;
            border-bottom: 1px solid #b8e4f5;
            border-radius: 0 4px 4px 0;
            padding: 5px 12px;
        }

        .resp-label {
            font-size: 7px;
            font-weight: 600;
            color: #1a7abf;
            text-transform: uppercase;
            letter-spacing: 0.18em;
        }

        .resp-value {
            font-size: 11px;
            font-weight: 700;
            color: #0f2028;
            text-transform: uppercase;
        }

        /* ─────────────────────────────
           TABLA DETALLE
        ───────────────────────────── */
        .tabla-detalle {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-detalle thead tr {
            background-color: #0b4f7a;
        }

        .tabla-detalle thead th {
            font-size: 8px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 6px 7px;
            text-align: center;
        }

        .tabla-detalle thead th:first-child {
            border-left: 3px solid #3aaee0;
        }

        .tabla-detalle thead th:last-child {
            text-align: right;
            padding-right: 10px;
        }

        .tabla-detalle tbody tr {
            border-bottom: 1px solid #eef2f4;
        }

        .tabla-detalle tbody tr.fila-par {
            background-color: #f8fafb;
        }

        .tabla-detalle tbody td {
            padding: 4px 7px;
            font-size: 9.5px;
            color: #3d5a64;
            text-align: center;
            text-transform: uppercase;
        }

        .tabla-detalle tbody td:first-child {
            font-size: 8px;
            font-weight: 600;
            color: #8fa8b2;
            border-left: 3px solid #b8e4f5;
        }

        .tabla-detalle tbody td:last-child {
            text-align: right;
            padding-right: 10px;
            font-weight: 600;
            color: #0f2028;
        }

        .tabla-detalle tfoot tr {
            background-color: #0f2028;
        }

        .tabla-detalle tfoot td {
            padding: 6px 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .tfoot-lbl {
            font-size: 8.5px;
            text-align: right;
            color: #8fa8b2;
            letter-spacing: 0.14em;
        }

        .tfoot-val {
            font-size: 13px;
            text-align: right;
            padding-right: 10px;
            color: #4dc972;
        }

        /* ─────────────────────────────
           OBSERVACIONES
        ───────────────────────────── */
        .obs-outer {
            margin-top: 0.28cm;
            border: 1px solid #b8edc8;
            border-radius: 4px;
        }

        .obs-head {
            background-color: #1a6b2f;
            padding: 4px 12px;
            border-radius: 3px 3px 0 0;
        }

        .obs-dot {
            display: inline-block;
            width: 6px; height: 6px;
            border-radius: 50%;
            background-color: #4dc972;
            vertical-align: middle;
            margin-right: 6px;
        }

        .obs-title {
            font-size: 8px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            vertical-align: middle;
        }

        .obs-body {
            padding: 8px 12px;
            font-size: 10px;
            color: #3d5a64;
            line-height: 1.55;
            background-color: #eafaf0;
            border-radius: 0 0 3px 3px;
        }

        /* ─────────────────────────────
           FOOTER
        ───────────────────────────── */
        footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 1.5cm;
        }

        .footer-stripe-tbl {
            width: 100%;
            border-collapse: collapse;
            height: 5px;
        }

        .fstr-sky   { background-color: #1a7abf; width: 50%; height: 5px; }
        .fstr-solar { background-color: #2da44e; width: 50%; height: 5px; }

        .footer-body {
            background-color: #0f2028;
            height: calc(1.5cm - 5px);
        }

        .footer-tbl {
            width: 100%;
            border-collapse: collapse;
            height: 100%;
        }

        .footer-td-left {
            vertical-align: middle;
            padding-left: 1.1cm;
        }

        .footer-brand {
            font-size: 9px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .footer-brand-accent { color: #4dc972; }

        .footer-divider {
            display: inline-block;
            width: 1px; height: 11px;
            background-color: rgba(255,255,255,0.15);
            vertical-align: middle;
            margin: 0 7px;
        }

        .footer-sub {
            font-size: 7.5px;
            color: #8fa8b2;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            vertical-align: middle;
        }

        .footer-td-right {
            vertical-align: middle;
            text-align: right;
            padding-right: 1.1cm;
            font-size: 8px;
            color: #8fa8b2;
            letter-spacing: 0.1em;
        }

    </style>
</head>
<body>

    <!-- ═══════════════ HEADER ═══════════════ -->
    <header>
        <div class="hdr-stripe"></div>
        <table class="hdr-table">
            <tr>
                <td class="hdr-td-logo">
                    <img src="{{ public_path('images/logo_v.png') }}" alt="CISNERGIA">
                </td>
                <td class="hdr-td-text">
                    <span class="hdr-eyebrow">Energía Solar &nbsp;·&nbsp; Gestión de Almacén</span><br>
                    <span class="hdr-title">Movimiento de <span class="hdr-title-accent">Salida</span></span><br>
                    <span class="hdr-badge">{{ $admin_salida->codigo }}</span>
                    <span class="hdr-date">
                        {{$now->isoFormat('dddd D \d\e MMMM \d\e\l Y')}} &nbsp;·&nbsp; {{$now->format('H:i:s')}}
                    </span>
                </td>
                <td class="hdr-td-panel">
                    <table class="solar-tbl">
                        <tr>
                            <td class="sc sc-on"></td>
                            <td class="sc"></td>
                            <td class="sc sc-on"></td>
                        </tr>
                        <tr>
                            <td class="sc"></td>
                            <td class="sc sc-on"></td>
                            <td class="sc"></td>
                        </tr>
                        <tr>
                            <td class="sc sc-on"></td>
                            <td class="sc"></td>
                            <td class="sc sc-on"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>

    <!-- ═══════════════ CONTENIDO ═══════════════ -->
    <div class="contenido">

        <!-- INFO GENERAL -->
        <div class="section">
            <div class="div-wrap">
                <span class="div-bar-sky"></span>
                <span class="div-bar-sol"></span>
                <span class="div-label">Información General</span>
            </div>
            <hr class="div-line">

            @php
                $sede_almacen = \App\Models\Sede::where('id',$admin_salida->almacen->sede_id)->first();
            @endphp

            <table class="info-tbl">
                <tr>
                    <!-- Código -->
                    <td style="width:17%">
                        <div class="ic-head ic-sky">
                            <span class="ic-dot dot-sky"></span>
                            <span class="ic-lbl">Código</span>
                        </div>
                        <div class="ic-body ic-body-sky">
                            <span class="ic-val">{{ $admin_salida->codigo }}</span>
                        </div>
                    </td>

                    <!-- Motivo -->
                    <td style="width:15%">
                        <div class="ic-head ic-solar">
                            <span class="ic-dot dot-solar"></span>
                            <span class="ic-lbl">Motivo</span>
                        </div>
                        <div class="ic-body ic-body-solar">
                            <span class="pill">{{ $admin_salida->motivo }}</span>
                        </div>
                    </td>

                    <!-- Fecha -->
                    <td style="width:16%">
                        <div class="ic-head ic-sky">
                            <span class="ic-dot dot-sky"></span>
                            <span class="ic-lbl">Fecha</span>
                        </div>
                        <div class="ic-body ic-body-sky">
                            <span class="ic-val">{{ \Carbon\Carbon::parse($admin_salida->created_at)->format('d-m-Y') }}</span>
                        </div>
                    </td>

                    <!-- Ingresa a -->
                    <td style="width:{{ $admin_salida->motivo == 'COMPRA' ? '26%' : '52%' }}">
                        <div class="ic-head ic-solar">
                            <span class="ic-dot dot-solar"></span>
                            <span class="ic-lbl">Ingresa a</span>
                        </div>
                        <div class="ic-body ic-body-solar">
                            <span class="ic-val">{{ $admin_salida->almacen->name }}</span>
                        </div>
                    </td>

                    @if($admin_salida->motivo == 'COMPRA')
                    <!-- Compra de origen -->
                    <td style="width:26%">
                        <div class="ic-head ic-sky">
                            <span class="ic-dot dot-sky"></span>
                            <span class="ic-lbl">Compra de Origen</span>
                        </div>
                        <div class="ic-body ic-body-sky">
                            <span class="ic-val">{{ $admin_salida->codigo_ocompra }}</span>
                        </div>
                    </td>
                    @endif
                </tr>
            </table>
        </div>

        <!-- RESPONSABLE -->
        <div class="section">
            <div class="div-wrap">
                <span class="div-bar-sky"></span>
                <span class="div-bar-sol"></span>
                <span class="div-label">Responsable</span>
            </div>
            <hr class="div-line">
            <div class="resp-banner">
                <span class="resp-label">Registrado por &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                <span class="resp-value">{{ $admin_salida->registrado_por }}</span>
            </div>
        </div>

        <!-- DETALLE DE PRODUCTOS -->
        <div class="section no-page-break">
            <div class="div-wrap">
                <span class="div-bar-sky"></span>
                <span class="div-bar-sol"></span>
                <span class="div-label">Detalle de Productos</span>
            </div>
            <hr class="div-line">

            <table class="tabla-detalle">
                <thead>
                    <tr>
                        <th style="width:4%">N°</th>
                        <th style="width:13%">Tipo</th>
                        <th style="width:52%">Descripción</th>
                        <th style="width:8%">Cant.</th>
                        <th style="width:11%; text-align:right; padding-right:10px">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @php $contador = 1; @endphp
                    @foreach($dtlle_salida as $item)
                        @php
                            $tipo_ = \App\Models\Tipo::where('name',$item->tipo_producto)->first();
                        @endphp
                        <tr class="{{ $contador % 2 == 0 ? 'fila-par' : '' }}">
                            <td>{{ $contador }}</td>
                            <td>{{ $tipo_->name }}</td>
                            <td>{{ $item->producto.' - '.$item->umedida }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td style="text-align:right; padding-right:10px">
                                @if($item->precio == NULL) — @else {{ number_format($item->precio, 2, '.', ',') }} @endif
                            </td>
                        </tr>
                        @php $contador++; @endphp
                    @endforeach

                    @php
                        $filas_totales = 20;
                        $filas_vacias = max($filas_totales - $dtlle_salida->count(), 0);
                    @endphp
                    @for($i = 0; $i < $filas_vacias; $i++)
                        <tr class="{{ ($contador + $i) % 2 == 0 ? 'fila-par' : '' }}">
                            <td><span style="opacity:0">0</span></td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="tfoot-lbl">Cantidad Total</td>
                        <td class="tfoot-val">{{ number_format($admin_salida->total ?? 0, 2, '.', ',') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- OBSERVACIONES -->
        <div class="obs-outer no-page-break">
            <div class="obs-head">
                <span class="obs-dot"></span>
                <span class="obs-title">Observaciones</span>
            </div>
            <div class="obs-body">
                {{ $admin_salida->descripcion ? $admin_salida->descripcion : 'Sin observaciones.' }}
            </div>
        </div>

    </div>

    <!-- ═══════════════ FOOTER ═══════════════ -->
    <footer>
        <table class="footer-stripe-tbl">
            <tr>
                <td class="fstr-sky"></td>
                <td class="fstr-solar"></td>
            </tr>
        </table>
        <div class="footer-body">
            <table class="footer-tbl">
                <tr>
                    <td class="footer-td-left">
                        <span class="footer-brand">CIS<span class="footer-brand-accent">NERGIA</span></span>
                        <span class="footer-divider"></span>
                        <span class="footer-sub">Movimiento de Salida &nbsp;·&nbsp; {{ $admin_salida->codigo }}</span>
                    </td>
                    <td class="footer-td-right">
                        <script type="text/php">
                            if ( isset($pdf) ) {
                                $pdf->page_script('
                                    $font = $fontMetrics->get_font("Outfit, sans-serif", "normal");
                                    $pdf->text(530, 828, "PÁG. $PAGE_NUM / $PAGE_COUNT", $font, 7);
                                ');
                            }
                        </script>
                    </td>
                </tr>
            </table>
        </div>
    </footer>

</body>
</html>
