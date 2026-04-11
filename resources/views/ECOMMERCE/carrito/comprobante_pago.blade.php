<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISNERGIA | {{ strtoupper($tipo_label) }} - {{ $sale->pedido->codigo }}</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <style>

        @page { margin: 0cm 0cm; }
        .page-break { page-break-after: always; }
        .no-page-break { page-break-inside: avoid; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin-top: 2.2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
            font-size: 10px;
            color: #0f2028;
        }

        /* ─── HEADER ─── */
        header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 1.8cm;
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
            height: calc(1.8cm - 4px);
        }

        .hdr-td-logo {
            width: 2.8cm;
            text-align: center;
            vertical-align: middle;
            padding: 0.1cm 0.3cm;
            border-right: 1px solid #dce4e8;
        }

        .hdr-td-logo img { width: 110px; }

        .hdr-td-text {
            vertical-align: middle;
            padding: 0 0.4cm;
        }

        .hdr-eyebrow {
            font-size: 7px;
            font-weight: 600;
            color: #1a7abf;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .hdr-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f2028;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.1;
        }

        .hdr-title-accent { color: #2da44e; }

        .hdr-date {
            font-size: 7px;
            color: #8fa8b2;
            letter-spacing: 0.04em;
            margin-top: 2px;
            display: block;
        }

        /* Badge tipo comprobante en header */
        .hdr-td-badge {
            width: 3.2cm;
            text-align: center;
            vertical-align: middle;
            padding: 0 0.3cm;
            border-left: 1px solid #dce4e8;
        }

        .badge-tipo {
            display: inline-block;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-boleta   { background-color: #b8edc8; color: #1a6b2f; border: 1px solid #4dc972; }
        .badge-factura  { background-color: #b8e4f5; color: #0b4f7a; border: 1px solid #3aaee0; }
        .badge-nota     { background-color: #f5e6b8; color: #7a5c0b; border: 1px solid #e0b43a; }

        .hdr-codigo {
            font-size: 11px;
            font-weight: 800;
            color: #0b4f7a;
            display: block;
            margin-top: 4px;
        }

        .hdr-fecha {
            font-size: 7px;
            color: #8fa8b2;
            display: block;
            margin-top: 2px;
        }

        /* ─── SECCIÓN DATOS CLIENTE / EMPRESA ─── */
        .seccion-datos {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 0.3cm;
        }

        .datos-emisor {
            display: table-cell;
            width: 48%;
            background-color: #0b4f7a;
            border-radius: 5px;
            padding: 7px 10px;
            vertical-align: top;
        }

        .datos-cliente {
            display: table-cell;
            width: 52%;
            background-color: #eaf7fd;
            border: 1px solid #b8e4f5;
            border-radius: 5px;
            padding: 7px 10px;
            vertical-align: top;
        }

        .datos-label {
            font-size: 6.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 2px;
            display: block;
        }

        .datos-valor {
            font-size: 9px;
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }

        .emisor-label { color: #3aaee0; }
        .emisor-valor { color: #ffffff; }
        .cliente-label { color: #1a7abf; }
        .cliente-valor { color: #0b4f7a; }

        /* ─── TABLA DE PRODUCTOS ─── */
        .tabla-productos {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 0.3cm;
        }

        .tabla-productos thead tr {
            background-color: #0b4f7a;
        }

        .tabla-productos thead th {
            font-size: 7.5px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 5px 7px;
            text-align: center;
        }

        .tabla-productos thead th:first-child {
            border-left: 3px solid #3aaee0;
            text-align: left;
        }

        .tabla-productos thead th:last-child {
            text-align: right;
            padding-right: 10px;
        }

        .tabla-productos tbody tr {
            border-bottom: 1px solid #eef2f4;
        }

        .tabla-productos tbody tr.fila-par {
            background-color: #f8fafb;
        }

        .tabla-productos tbody td {
            padding: 5px 7px;
            color: #3d5a64;
            text-align: center;
            vertical-align: middle;
        }

        .tabla-productos tbody td:first-child {
            border-left: 3px solid #b8e4f5;
            text-align: left;
            font-weight: 600;
            color: #0f2028;
        }

        .tabla-productos tbody td:last-child {
            text-align: right;
            padding-right: 10px;
            font-weight: 700;
            color: #0f2028;
        }

        /* ─── TOTALES ─── */
        .totales-wrap {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
        }

        .totales-izq {
            display: table-cell;
            width: 55%;
            vertical-align: top;
        }

        .totales-der {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }

        .nota-legal {
            background-color: #f8fafb;
            border: 1px solid #dce4e8;
            border-left: 3px solid #3aaee0;
            border-radius: 0 4px 4px 0;
            padding: 6px 10px;
            font-size: 7.5px;
            color: #8fa8b2;
            line-height: 1.5;
        }

        .tabla-totales {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-totales td {
            padding: 3px 7px;
            font-size: 9px;
        }

        .tabla-totales .lbl {
            color: #8fa8b2;
            text-align: left;
        }

        .tabla-totales .val {
            text-align: right;
            font-weight: 600;
            color: #0f2028;
        }

        .fila-total-final {
            background-color: #0b4f7a;
            border-radius: 4px;
        }

        .fila-total-final td {
            padding: 5px 10px !important;
        }

        .fila-total-final .lbl {
            color: #b8e4f5 !important;
            font-size: 8px !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .fila-total-final .val {
            color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 800;
        }

        .fila-igv td { color: #1a7abf !important; }
        .tachado { text-decoration: line-through; color: #b8e4f5 !important; font-size: 8px !important; }

        /* Método de pago badge */
        .badge-pago {
            display: inline-block;
            font-size: 7.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            background-color: #b8edc8;
            color: #1a6b2f;
            border: 1px solid #4dc972;
        }

        /* ─── FOOTER ─── */
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
    /*
    |─────────────────────────────────────────────────────────
    | Variables esperadas desde el controller:
    |   $sale            → modelo Venta (con relaciones cargadas)
    |   $dtlle_venta     → colección de detalles de venta
    |   $tipo_comprobante → '1' = Factura, '2' = Boleta, '3' = Nota de Venta
    |   $tipo_label      → 'Factura', 'Boleta de Venta', 'Nota de Venta'
    |   $now             → Carbon::now()
    |─────────────────────────────────────────────────────────
    */
    $esFactura   = $tipo_label === 'Factura';
    $esBoleta    = $tipo_label === 'Boleta de Venta';
    $esNota      = $tipo_label === 'Nota de Venta';
    $badgeClass  = $esFactura ? 'badge-factura' : ($esBoleta ? 'badge-boleta' : 'badge-nota');
    $aplicaIGV   = !$esNota;
@endphp

<!-- ══════════════ HEADER ══════════════ -->
<header>
    <div class="hdr-stripe"></div>
    <table class="hdr-table">
        <tr>
            <td class="hdr-td-logo">
                <img src="{{ public_path('images/logo_v.png') }}" alt="CISNERGIA">
            </td>
            <td class="hdr-td-text">
                <span class="hdr-eyebrow">Energía Solar &nbsp;·&nbsp; Comprobante de Pago</span><br>
                <span class="hdr-title">CIS<span class="hdr-title-accent">NERGIA</span> PERU</span>
                <span class="hdr-date">
                    RUC: 20XXXXXXXXX &nbsp;·&nbsp; Av. Ejemplo 123, Lima, Perú
                </span>
            </td>
            <td class="hdr-td-badge p-2">
                <span class="badge-tipo {{ $badgeClass }}">{{ $tipo_label }}</span>
                <span class="hdr-codigo">{{ $sale->pedido->codigo }}</span>
                <span class="hdr-fecha">{{ $now->format('d/m/Y H:i') }}</span>
            </td>
        </tr>
    </table>
</header>

<!-- ══════════════ CONTENIDO ══════════════ -->
<div class="contenido">

    {{-- ── DATOS EMISOR / CLIENTE ── --}}
    <div class="seccion-datos">

        {{-- Emisor --}}
        <div class="datos-emisor">
            <span class="datos-label emisor-label">Emisor</span>
            <span class="datos-valor emisor-valor">CISNERGIA PERU S.A.C.</span>
            
            <span class="datos-label emisor-label">RUC</span>
            <span class="datos-valor emisor-valor">20XXXXXXXXX</span>

            <span class="datos-label emisor-label">Dirección</span>
            <span class="datos-valor emisor-valor">Av. Ejemplo 123, Lima, Perú</span>

            <span class="datos-label emisor-label">Método de Pago</span>
            <span class="badge-pago">
                {{ optional($sale->mediopago)->name ?? 'Pago procesado' }}
            </span>
        </div>

        {{-- Cliente / Receptor --}}
        <div class="datos-cliente">
            <span class="datos-label cliente-label">
                @if($esFactura) Razón Social @else Cliente @endif
            </span>
            <span class="datos-valor cliente-valor">
                @if($esFactura && $sale->razon_social)
                    {{ $sale->cliente->user->persona->name }}
                @else
                    {{ $sale->cliente->user->persona->name ?? '' }}
                    {{ $sale->cliente->user->persona->surnames ?? '' }}
                @endif
            </span>

            <span class="datos-label cliente-label">
                @if($esFactura) RUC @else DNI @endif
            </span>
            <span class="datos-valor cliente-valor">{{ $sale->cliente->user->persona->nro_identificacion }}</span>

            <span class="datos-label cliente-label">Email</span>
            <span class="datos-valor cliente-valor">{{ $sale->cliente->user->email }}</span>

            <span class="datos-label cliente-label">Teléfono</span>
            <span class="datos-valor cliente-valor">
                +51 {{ $sale->cliente->user->persona->celular }}
            </span>

            <span class="datos-label cliente-label">Dirección de Entrega</span>
            <span class="datos-valor cliente-valor">
                {{ $sale->direccion ?? $sale->cliente->user->persona->direccion }}
            </span>
        </div>

    </div>

    {{-- ── TABLA DE PRODUCTOS ── --}}
    <table class="tabla-productos">
        <thead>
            <tr>
                <th style="width:35%">Descripción</th>
                <th style="width:10%">Cant.</th>
                <th style="width:20%">P. Unitario</th>
                @if($aplicaIGV)
                <th style="width:15%">Sin IGV</th>
                @endif
                <th style="width:20%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach($dtlle_venta as $dtlle)
            @php
                $producto = App\Models\Producto::find($dtlle->producto_id);
                $precioSinIGV = $aplicaIGV ? round($dtlle->precio_unitario / 1.18, 2) : $dtlle->precio_unitario;
                $totalLinea   = $dtlle->precio_unitario * $dtlle->cantidad;
            @endphp
            <tr class="{{ $contador % 2 == 0 ? 'fila-par' : '' }}">
                <td>
                    {{ $producto->name ?? 'Producto' }}
                    @if($producto && $producto->codigo)
                        <br><span style="font-size:7px; color:#8fa8b2; font-weight:400;">
                            Cód: {{ $producto->codigo }}
                        </span>
                    @endif
                </td>
                <td>{{ $dtlle->cantidad }}</td>
                <td>S/ {{ number_format($dtlle->precio_unitario, 2) }}</td>
                @if($aplicaIGV)
                <td>S/ {{ number_format($precioSinIGV, 2) }}</td>
                @endif
                <td>S/ {{ number_format($totalLinea, 2) }}</td>
            </tr>
            @php $contador++; @endphp
            @endforeach
        </tbody>
    </table>

    {{-- ── TOTALES + NOTA LEGAL ── --}}
    <div class="totales-wrap">

        {{-- Nota legal izquierda --}}
        <div class="totales-izq">
            <div class="nota-legal">
                @if($esFactura)
                    Este documento es una <strong>Factura Electrónica</strong> válida para sustentar
                    crédito fiscal. Emitida conforme a la legislación tributaria peruana vigente (SUNAT).
                @elseif($esBoleta)
                    Este documento es una <strong>Boleta de Venta Electrónica</strong>.
                    Conserve este comprobante para cualquier reclamo o cambio dentro de los 30 días
                    de realizada la compra.
                @else
                    Este documento es una <strong>Nota de Venta</strong>. No tiene valor tributario
                    ni sustenta crédito fiscal. Válido únicamente como constancia de compra interna.
                @endif
                <br><br>
                Fecha estimada de entrega:
                <strong>
                    {{ $sale->pedido->fecha_entrega_estimada->locale('es_PE')->isoFormat('D [de] MMMM, YYYY') }}
                </strong>
            </div>
        </div>

        {{-- Tabla de totales derecha --}}
        <div class="totales-der">
            <table class="tabla-totales">
                <tr>
                    <td class="lbl">Subtotal</td>
                    <td class="val">S/ {{ number_format($sale->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="lbl">Descuento</td>
                    <td class="val">- S/ 0.00</td>
                </tr>
                @if($aplicaIGV)
                <tr class="fila-igv">
                    <td class="lbl" style="color:#1a7abf;">IGV (18%)</td>
                    <td class="val" style="color:#1a7abf;">S/ {{ number_format($sale->igv, 2) }}</td>
                </tr>
                @else
                <tr>
                    <td class="lbl">IGV (18%)</td>
                    <td class="val">
                        <span class="tachado">No aplica</span>
                    </td>
                </tr>
                @endif
                <tr>
                    <td class="lbl">Envío</td>
                    <td class="val" style="color:#2da44e;">GRATIS</td>
                </tr>
                <tr class="fila-total-final">
                    <td class="lbl">TOTAL A PAGAR</td>
                    <td class="val">S/ {{ number_format($sale->total, 2) }}</td>
                </tr>
            </table>
        </div>

    </div>

</div>

<!-- ══════════════ FOOTER ══════════════ -->
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
                    <span class="footer-sub">{{ $tipo_label }}</span>
                </td>
                <td class="footer-td-right">
                    <script type="text/php">
                        if ( isset($pdf) ) {
                            $pdf->page_script('
                                $font = $fontMetrics->get_font("DejaVu Sans, sans-serif", "normal");
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