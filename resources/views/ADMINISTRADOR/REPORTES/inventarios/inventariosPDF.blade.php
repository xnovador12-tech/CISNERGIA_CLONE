<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISNERGIA | REPORTE DE INVENTARIO - PDF</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>

        @page { margin: 0cm 0cm; }

        .page-break  { page-break-after: always; }
        .no-page-break { page-break-inside: avoid; }

        body {
            font-family: 'Outfit', sans-serif;
            margin-top: 2.6cm;
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
            height: 2.5cm;
            background-color: #ffffff;
            border-bottom: 2px solid #dce4e8;
        }

        .hdr-stripe { height: 4px; background-color: #3aaee0; }

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

        .hdr-td-logo img { width: 78px; }

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

        /* Bloque derecho: sede + tipo + contador */
        .hdr-td-info {
            width: 4.5cm;
            vertical-align: middle;
            padding: 0 0.3cm;
            border-left: 1px solid #dce4e8;
            text-align: center;
        }

        .hdr-sede-label {
            font-size: 6.5px;
            font-weight: 600;
            color: #8fa8b2;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            display: block;
        }

        .hdr-sede-val {
            font-size: 10px;
            font-weight: 700;
            color: #0b4f7a;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }

        .hdr-tipo-pill {
            display: inline-block;
            font-size: 8px;
            font-weight: 700;
            color: #1a6b2f;
            background-color: #b8edc8;
            border: 1px solid #4dc972;
            border-radius: 20px;
            padding: 1px 9px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .hdr-count-wrap {
            margin-top: 3px;
        }

        .hdr-count-num {
            font-size: 18px;
            font-weight: 800;
            color: #0b4f7a;
            line-height: 1;
        }

        .hdr-count-sub {
            font-size: 6.5px;
            color: #3aaee0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-left: 3px;
        }

        /* ─────────────────────────────
           LEYENDA STOCK
        ───────────────────────────── */
        .leyenda-tbl {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4px 0;
            margin-bottom: 0.2cm;
        }

        .leyenda-td {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            text-align: center;
            width: 33%;
        }

        .leyenda-critico  { background-color: #fce8ed; color: #8b001f; border: 1px solid #f1abbe; }
        .leyenda-alerta   { background-color: #fff8e1; color: #7a5900; border: 1px solid #ffe082; }
        .leyenda-ok       { background-color: #eafaf0; color: #1a6b2f; border: 1px solid #4dc972; }

        .leyenda-dot {
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 5px;
        }

        .dot-critico { background-color: #CD0C36; }
        .dot-alerta  { background-color: #ffc107; }
        .dot-ok      { background-color: #2da44e; }

        /* ─────────────────────────────
           DIVISOR
        ───────────────────────────── */
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
           TABLA INVENTARIO
        ───────────────────────────── */
        .tabla-inventario {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .tabla-inventario thead tr {
            background-color: #0b4f7a;
        }

        .tabla-inventario thead th {
            font-size: 7.5px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 5px 6px;
            text-align: center;
        }

        .tabla-inventario thead th:first-child {
            border-left: 3px solid #3aaee0;
        }

        .tabla-inventario tbody tr {
            border-bottom: 1px solid #eef2f4;
        }

        .tabla-inventario tbody tr.fila-par {
            background-color: #f8fafb;
        }

        .tabla-inventario tbody td {
            padding: 3px 6px;
            color: #3d5a64;
            text-align: center;
            text-transform: uppercase;
            font-size: 8.5px;
        }

        .tabla-inventario tbody td:first-child {
            font-size: 7.5px;
            font-weight: 600;
            color: #8fa8b2;
            border-left: 3px solid #b8e4f5;
        }

        .tabla-inventario tbody td.td-desc {
            text-align: left;
        }

        /* Badge código */
        .badge-codigo {
            display: inline-block;
            font-size: 7.5px;
            font-weight: 700;
            color: #ffffff;
            background-color: #0b4f7a;
            padding: 1px 7px;
            border-radius: 20px;
        }

        /* Badge tipo */
        .badge-tipo {
            display: inline-block;
            font-size: 7.5px;
            font-weight: 700;
            color: #0b4f7a;
            background-color: #eaf7fd;
            border: 1px solid #b8e4f5;
            padding: 1px 7px;
            border-radius: 20px;
        }

        /* Badges de stock */
        .stock-badge {
            display: inline-block;
            font-size: 8px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            min-width: 36px;
            text-align: center;
        }

        .stock-critico  { background-color: #fce8ed; color: #8b001f; border: 1px solid #f1abbe; }
        .stock-alerta   { background-color: #fff8e1; color: #7a5900; border: 1px solid #ffe082; }
        .stock-ok       { background-color: #eafaf0; color: #1a6b2f; border: 1px solid #4dc972; }

        /* Separador categoría */
        .cat-sep {
            color: #b8e4f5;
            margin: 0 3px;
        }

        /* ─────────────────────────────
           TOTALES FINALES
        ───────────────────────────── */
        .totales-tbl {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4px 0;
            margin-top: 0.25cm;
        }

        .total-card {
            border-radius: 4px;
            padding: 5px 10px;
            text-align: center;
            width: 33%;
        }

        .total-card-sky {
            background-color: #eaf7fd;
            border: 1px solid #b8e4f5;
        }

        .total-card-solar {
            background-color: #eafaf0;
            border: 1px solid #b8edc8;
        }

        .total-card-dark {
            background-color: #0b4f7a;
        }

        .tc-label {
            font-size: 6.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            display: block;
            margin-bottom: 2px;
        }

        .tc-label-sky   { color: #1a7abf; }
        .tc-label-solar { color: #2da44e; }
        .tc-label-white { color: rgba(255,255,255,0.6); }

        .tc-value {
            font-size: 15px;
            font-weight: 800;
            display: block;
            line-height: 1;
        }

        .tc-value-sky   { color: #0b4f7a; }
        .tc-value-solar { color: #1a6b2f; }
        .tc-value-white { color: #4dc972; }

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

    @php
        $sede = \App\Models\Sede::find($sede_id);
        $tipo_producto = $tipo_producto ?? null;
        $alm_tipo_producto = App\Models\Inventario::where('sede_id', $sede->id)
            ->when($tipo_producto, fn($q) => $q->where('tipo_producto', $tipo_producto))
            ->get();

        $total_cantidad = 0;
        $total_critico  = 0;
        $total_alerta   = 0;
        $total_ok       = 0;

        foreach ($alm_tipo_producto as $item) {
            $prod = \App\Models\Producto::find($item->id_producto);
            $total_cantidad += $item->cantidad;
            if ($prod) {
                if ($item->cantidad <= $prod->stock_critico)       $total_critico++;
                elseif ($item->cantidad <= $prod->stock_seguro)    $total_alerta++;
                else                                                $total_ok++;
            }
        }
    @endphp

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
                    <span class="hdr-title">Reporte de <span class="hdr-title-accent">Inventario</span></span>
                    <span class="hdr-date">
                        {{$now->isoFormat('dddd D \d\e MMMM \d\e\l Y')}} &nbsp;·&nbsp; {{$now->format('H:i:s')}}
                    </span>
                </td>
                <td class="hdr-td-info">
                    <span class="hdr-sede-label">Sede</span>
                    <span class="hdr-sede-val">{{ $sede->name }}</span>
                    <span class="hdr-tipo-pill">{{ $tipo_producto ?? 'Todos los tipos' }}</span>
                    <div class="hdr-count-wrap">
                        <span class="hdr-count-num">{{ $alm_tipo_producto->count() }}</span>
                        <span class="hdr-count-sub">productos</span>
                    </div>
                </td>
            </tr>
        </table>
    </header>

    <!-- ═══════════════ CONTENIDO ═══════════════ -->
    <div class="contenido">

        {{-- Leyenda de colores de stock --}}
        <table class="leyenda-tbl">
            <tr>
                <td class="leyenda-td leyenda-critico">
                    <span class="leyenda-dot dot-critico"></span>Stock Crítico
                </td>
                <td class="leyenda-td leyenda-alerta">
                    <span class="leyenda-dot dot-alerta"></span>Stock en Alerta
                </td>
                <td class="leyenda-td leyenda-ok">
                    <span class="leyenda-dot dot-ok"></span>Stock Óptimo
                </td>
            </tr>
        </table>

        {{-- Divisor --}}
        <div class="div-wrap">
            <span class="div-bar-sky"></span>
            <span class="div-bar-sol"></span>
            <span class="div-label">Listado de Productos en Inventario</span>
        </div>
        <hr class="div-line">

        {{-- Tabla --}}
        <table class="tabla-inventario">
            <thead>
                <tr>
                    <th style="width:3%">N°</th>
                    <th style="width:10%">Código</th>
                    <th style="width:10%">Tipo</th>
                    <th style="width:18%">Categoría / Subcategoría</th>
                    <th style="width:32%">Descripción</th>
                    <th style="width:7%">U.M.</th>
                    <th style="width:10%">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach($alm_tipo_producto as $alm_tipo_productos)
                    @php
                        $codigo_producto = \App\Models\Producto::where('id', $alm_tipo_productos->id_producto)->first();
                    @endphp
                    <tr class="{{ $contador % 2 == 0 ? 'fila-par' : '' }}">

                        <td>{{ $contador }}</td>

                        <td>
                            <span class="badge-codigo">
                                {{ $codigo_producto ? $codigo_producto->codigo : '—' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge-tipo">
                                {{ $codigo_producto ? $codigo_producto->tipo->name : '—' }}
                            </span>
                        </td>

                        <td>
                            {{ $codigo_producto?->categorie?->name ?? '—' }}
                            @if($codigo_producto?->subcategories?->name)
                                <span class="cat-sep">\</span>{{ $codigo_producto->subcategories->name }}
                            @endif
                        </td>

                        <td class="td-desc">{{ $alm_tipo_productos->producto }}</td>

                        <td>{{ $alm_tipo_productos->umedida }}</td>

                        <td>
                            @if($codigo_producto)
                                @if($alm_tipo_productos->cantidad <= $codigo_producto->stock_critico)
                                    <span class="stock-badge stock-critico">{{ $alm_tipo_productos->cantidad }}</span>
                                @elseif($alm_tipo_productos->cantidad <= $codigo_producto->stock_seguro)
                                    <span class="stock-badge stock-alerta">{{ $alm_tipo_productos->cantidad }}</span>
                                @else
                                    <span class="stock-badge stock-ok">{{ $alm_tipo_productos->cantidad }}</span>
                                @endif
                            @else
                                {{ $alm_tipo_productos->cantidad }}
                            @endif
                        </td>

                    </tr>
                    @php $contador++; @endphp
                @endforeach
            </tbody>
        </table>

        {{-- Totales resumen --}}
        <table class="totales-tbl no-page-break">
            <tr>
                <td class="total-card total-card-sky">
                    <span class="tc-label tc-label-sky">Total en Stock</span>
                    <span class="tc-value tc-value-sky">{{ number_format($total_cantidad, 0, '.', ',') }}</span>
                </td>
                <td class="total-card total-card-solar">
                    <span class="tc-label tc-label-solar">Productos Registrados</span>
                    <span class="tc-value tc-value-solar">{{ $alm_tipo_producto->count() }}</span>
                </td>
                <td class="total-card total-card-dark">
                    <span class="tc-label tc-label-white">Crítico / Alerta / Óptimo</span>
                    <span class="tc-value tc-value-white">{{ $total_critico }} / {{ $total_alerta }} / {{ $total_ok }}</span>
                </td>
            </tr>
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
                        <span class="footer-sub">Reporte de Inventario &nbsp;·&nbsp; {{ $sede->name }}</span>
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
