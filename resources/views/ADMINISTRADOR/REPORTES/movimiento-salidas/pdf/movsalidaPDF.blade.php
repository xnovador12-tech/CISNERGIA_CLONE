<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISNERGIA | REPORTE DE MOVIMIENTOS DE SALIDA - PDF</title>
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
            font-size: 10px;
            color: #0f2028;
        }

        /* ─────────────────────────────
           HEADER
        ───────────────────────────── */
        header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 1.6cm;
            background-color: #eaf7fd;
            border-bottom: 2px solid #dce4e8;
        }

        .hdr-stripe {
            height: 4px;
            background-color: #3aaee0;
        }

        .hdr-table {
            width: 100%;
            border-collapse: collapse;
            height: calc(2.5cm - 4px);
        }

        .hdr-td-logo {
            width: 2.8cm;
            text-align: center;
            vertical-align: middle;
            padding: 0.15cm 0.3cm;
            border-right: 1px solid #dce4e8;
        }

        .hdr-td-logo img {
            width: 120px;
        }

        .hdr-td-text {
            vertical-align: middle;
            padding: 0 0.4cm;
        }

        .hdr-eyebrow {
            font-size: 7px;
            font-weight: 500;
            color: #1a7abf;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .hdr-title {
            font-size: 17px;
            font-weight: 800;
            color: #0f2028;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.1;
        }

        .hdr-title-accent { color: #2da44e; }

        .hdr-date {
            font-size: 7.5px;
            color: #8fa8b2;
            letter-spacing: 0.04em;
            margin-top: 2px;
            display: block;
        }

        .hdr-td-badge {
            width: 3cm;
            text-align: center;
            vertical-align: middle;
            padding: 0 0.3cm;
            border-left: 1px solid #dce4e8;
        }

        .hdr-count-label {
            font-size: 7px;
            font-weight: 600;
            color: #8fa8b2;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            display: block;
            margin-bottom: 3px;
        }

        .hdr-count-num {
            font-size: 22px;
            font-weight: 800;
            color: #0b4f7a;
            line-height: 1;
            display: block;
        }

        .hdr-count-sub {
            font-size: 7px;
            color: #3aaee0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            display: block;
            margin-top: 2px;
        }

        /* ─────────────────────────────
           FILTRO ALERT
        ───────────────────────────── */
        .filtro-banner {
            border-left: 4px solid #1a7abf;
            background-color: #eaf7fd;
            border-top: 1px solid #b8e4f5;
            border-right: 1px solid #b8e4f5;
            border-bottom: 1px solid #b8e4f5;
            border-radius: 0 4px 4px 0;
            padding: 5px 12px;
            margin-bottom: 0.25cm;
            font-size: 9px;
            color: #0b4f7a;
        }

        .filtro-banner b { font-weight: 700; }

        /* ─────────────────────────────
           TABLA PRINCIPAL
        ───────────────────────────── */
        .tabla-reporte {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }

        .tabla-reporte thead tr {
            background-color: #0b4f7a;
        }

        .tabla-reporte thead th {
            font-size: 8px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 6px 7px;
            text-align: center;
        }

        .tabla-reporte thead th:first-child {
            border-left: 3px solid #3aaee0;
        }

        .tabla-reporte thead th:last-child {
            text-align: right;
            padding-right: 10px;
        }

        .tabla-reporte tbody tr {
            border-bottom: 1px solid #eef2f4;
        }

        .tabla-reporte tbody tr.fila-par {
            background-color: #f8fafb;
        }

        .tabla-reporte tbody td {
            padding: 4px 7px;
            color: #3d5a64;
            text-align: center;
            text-transform: uppercase;
        }

        .tabla-reporte tbody td:first-child {
            font-size: 8px;
            font-weight: 600;
            color: #8fa8b2;
            border-left: 3px solid #b8e4f5;
        }

        .tabla-reporte tbody td:last-child {
            text-align: right;
            padding-right: 10px;
            font-weight: 600;
            color: #0f2028;
        }

        /* Badge código */
        .badge-codigo {
            display: inline-block;
            font-size: 8px;
            font-weight: 700;
            color: #ffffff;
            background-color: #0b4f7a;
            padding: 1px 7px;
            border-radius: 20px;
        }

        /* Badge motivo */
        .badge-motivo {
            display: inline-block;
            font-size: 8px;
            font-weight: 700;
            padding: 1px 8px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .motivo-compra   { background-color: #b8edc8; color: #1a6b2f; border: 1px solid #4dc972; }
        .motivo-traslado { background-color: #b8e4f5; color: #0b4f7a; border: 1px solid #3aaee0; }
        .motivo-otros    { background-color: #eef2f4; color: #3d5a64; border: 1px solid #8fa8b2; }

        /* Código origen */
        .origen-prefix {
            font-size: 7.5px;
            font-weight: 700;
            color: #8fa8b2;
            text-transform: uppercase;
            margin-right: 2px;
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
                    <span class="hdr-title">Reporte de <span class="hdr-title-accent">Salidas</span></span>
                    <span class="hdr-date">
                        {{$now->isoFormat('dddd D \d\e MMMM \d\e\l Y')}} &nbsp;·&nbsp; {{$now->format('H:i:s')}}
                    </span>
                </td>
                <td class="hdr-td-badge">
                    <span class="hdr-count-label">Total encontrados</span>
                    <span class="hdr-count-num">{{ $salidas->count() }}</span>
                    <span class="hdr-count-sub">movimientos</span>
                </td>
            </tr>
        </table>
    </header>

    <!-- ═══════════════ CONTENIDO ═══════════════ -->
    <div class="contenido">

        {{-- Banner filtro --}}
        @if(!empty($name_sede && $fi && $ff))
            <div class="filtro-banner">
                <b>Sucursal:</b> {{ $name_sede->name }}
                &nbsp;·&nbsp;
                <b>Período:</b> desde {{ $fi }} hasta {{ $ff }}
            </div>
        @endif

        {{-- Tabla --}}
        <table class="tabla-reporte">
            <thead>
                <tr>
                    <th style="width:4%">N°</th>
                    <th style="width:13%">Código</th>
                    <th style="width:13%">Fecha</th>
                    <th style="width:10%">Motivo</th>
                    <th style="width:18%">Cód. Origen</th>
                    <th style="width:22%">Registrado por</th>
                    <th style="width:10%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach($salidas as $item)
                    <tr class="{{ $contador % 2 == 0 ? 'fila-par' : '' }}">
                        <td>{{ $contador }}</td>

                        <td>
                            <span class="badge-codigo">{{ $item->codigo }}</span>
                        </td>

                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>

                        <td>
                            <span class="badge-motivo {{ $item->motivo }}">{{ $item->motivo }}</span>
                        </td>

                        <td>
                            @if($item->motivo == 'Venta')
                                <span class="origen-prefix">CV:</span>{{ $item->codigo_venta }}
                            @elseif($item->motivo == 'Merma' || $item->motivo == 'Robo o perdida')
                                <span class="origen-prefix">CM:</span>{{ $item->codigo }}
                            @else
                                <span class="origen-prefix">CM:</span>{{ $item->codigo }}
                            @endif
                        </td>

                        <td>{{ $item->registrado_por }}</td>

                        <td>{{ number_format($item->total ?? 0, 2, '.', ',') }}</td>
                    </tr>
                    @php $contador++; @endphp
                @endforeach
            </tbody>
        </table>

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
                        <span class="footer-sub">Reporte de Movimientos de Salida</span>
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
