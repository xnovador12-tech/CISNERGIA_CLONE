<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cotización {{ $cotizacion->codigo }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }

        /* ===== HEADER ===== */
        .header {
            background-color: #1C3146;
            color: #fff;
            padding: 25px 40px 20px;
            position: relative;
        }
        .header-table {
            width: 100%;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-img {
            max-width: 160px;
            max-height: 45px;
        }
        .header-right {
            text-align: right;
        }
        .header-right h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }
        .header-right p {
            font-size: 10px;
            opacity: 0.85;
            margin: 2px 0 0 0;
        }
        .header-codigo {
            background-color: rgba(255,255,255,0.15);
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 5px;
        }

        /* ===== FRANJA ACCENT ===== */
        .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, #E8A723, #1C3146);
        }

        /* ===== CONTENIDO ===== */
        .content {
            padding: 25px 40px 20px;
        }

        /* ===== INFO BOXES ===== */
        .info-row {
            width: 100%;
            margin-bottom: 18px;
        }
        .info-row td {
            vertical-align: top;
            padding: 0;
        }
        .info-box {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 15px;
            background: #fafafa;
        }
        .info-box-title {
            font-size: 8px;
            text-transform: uppercase;
            font-weight: 700;
            color: #1C3146;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            border-bottom: 1px solid #e8e8e8;
            padding-bottom: 4px;
        }
        .info-box p {
            margin: 2px 0;
            font-size: 9.5px;
        }
        .info-box .label {
            color: #888;
            font-size: 8.5px;
        }
        .info-box .value {
            font-weight: 600;
            color: #333;
        }

        /* ===== TABLA ITEMS ===== */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #1C3146;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 2px solid #E8A723;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        .items-table thead th {
            background-color: #1C3146;
            color: #fff;
            padding: 7px 8px;
            text-align: left;
            font-size: 8px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .items-table thead th.text-center { text-align: center; }
        .items-table thead th.text-right { text-align: right; }
        .items-table tbody td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
        }
        .items-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .items-table .text-center { text-align: center; }
        .items-table .text-right { text-align: right; }
        .items-table .cat-row {
            background-color: #f0f4f8 !important;
            font-weight: 600;
            font-size: 8.5px;
            color: #1C3146;
        }
        .items-table .subtotal-row {
            background-color: #f5f5f5 !important;
            font-weight: 600;
        }

        /* ===== TOTALES ===== */
        .totales-wrapper {
            width: 100%;
            margin-bottom: 18px;
        }
        .totales-table {
            width: 260px;
            float: right;
            border-collapse: collapse;
        }
        .totales-table td {
            padding: 5px 10px;
            font-size: 9.5px;
        }
        .totales-table .label-td {
            text-align: right;
            color: #666;
        }
        .totales-table .value-td {
            text-align: right;
            font-weight: 600;
            width: 100px;
        }
        .totales-table .total-row td {
            border-top: 2px solid #1C3146;
            padding-top: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #1C3146;
        }
        .totales-table .descuento-row td {
            color: #dc3545;
        }

        /* ===== CONDICIONES ===== */
        .condiciones {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 15px;
            background: #fafafa;
        }
        .condiciones h4 {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 700;
            color: #1C3146;
            margin-bottom: 6px;
        }
        .condiciones p {
            font-size: 8.5px;
            color: #555;
            margin: 2px 0;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #1C3146;
            color: #fff;
            padding: 10px 40px;
            font-size: 7.5px;
            text-align: center;
        }
        .footer p {
            margin: 1px 0;
            opacity: 0.8;
        }

        /* ===== UTILIDADES ===== */
        .clearfix::after { content: ""; display: table; clear: both; }
        .text-accent { color: #E8A723; }
        .badge-estado {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-borrador { background: #e2e3e5; color: #41464b; }
        .badge-enviada { background: #cfe2ff; color: #084298; }
        .badge-aceptada { background: #d1e7dd; color: #0f5132; }
        .badge-rechazada { background: #f8d7da; color: #842029; }

        /* Firma */
        .firma-section {
            margin-top: 40px;
            width: 100%;
        }
        .firma-section td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 30px;
        }
        .firma-line {
            border-top: 1px solid #999;
            padding-top: 5px;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    {{-- FOOTER FIJO --}}
    <div class="footer">
        <p>Cisnergia &mdash; Soluciones en Energía Solar</p>
        <p>Este documento es una cotización referencial y está sujeta a confirmación.</p>
    </div>

    {{-- HEADER --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    @php
                        $logoPath = public_path('images/logo_v.png');
                    @endphp
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Cisnergia" class="logo-img">
                    @else
                        <span style="font-size: 20px; font-weight: 700;">CISNERGIA</span>
                    @endif
                </td>
                <td class="header-right">
                    <h1>COTIZACIÓN</h1>
                    <div class="header-codigo">{{ $cotizacion->codigo }}</div>
                    @if($cotizacion->version > 1)
                        <p>Versión {{ $cotizacion->version }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="accent-bar"></div>

    {{-- CONTENIDO --}}
    <div class="content">
        {{-- Información del Cliente y Cotización --}}
        <table class="info-row">
            <tr>
                <td style="width: 55%; padding-right: 10px;">
                    <div class="info-box">
                        <div class="info-box-title">Datos del Cliente</div>
                        @if($cotizacion->oportunidad && $cotizacion->oportunidad->prospecto)
                            @php $prospecto = $cotizacion->oportunidad->prospecto; @endphp
                            <p><span class="value">{{ $prospecto->nombre_completo }}</span></p>
                            @if($prospecto->razon_social)
                                <p><span class="label">Razón Social:</span> <span class="value">{{ $prospecto->razon_social }}</span></p>
                            @endif
                            @if($prospecto->ruc)
                                <p><span class="label">RUC:</span> <span class="value">{{ $prospecto->ruc }}</span></p>
                            @endif
                            @if($prospecto->email)
                                <p><span class="label">Email:</span> {{ $prospecto->email }}</p>
                            @endif
                            @if($prospecto->telefono)
                                <p><span class="label">Teléfono:</span> {{ $prospecto->telefono }}</p>
                            @endif
                            @if($prospecto->direccion)
                                <p><span class="label">Dirección:</span> {{ $prospecto->direccion }}</p>
                            @endif
                        @else
                            <p class="label">Sin datos de cliente</p>
                        @endif
                    </div>
                </td>
                <td style="width: 45%;">
                    <div class="info-box">
                        <div class="info-box-title">Datos de la Cotización</div>
                        <p><span class="label">Proyecto:</span> <span class="value">{{ $cotizacion->nombre_proyecto }}</span></p>
                        <p><span class="label">Oportunidad:</span> {{ $cotizacion->oportunidad->nombre ?? '-' }}</p>
                        <p><span class="label">Tipo:</span> {{ ucfirst($cotizacion->oportunidad->tipo_oportunidad ?? '-') }}</p>
                        <p><span class="label">Fecha Emisión:</span> {{ $cotizacion->fecha_emision?->format('d/m/Y') }}</p>
                        <p><span class="label">Válida Hasta:</span> <span class="value">{{ $cotizacion->fecha_vigencia?->format('d/m/Y') }}</span></p>
                        <p><span class="label">Ejecución:</span> {{ $cotizacion->tiempo_ejecucion_dias }} días</p>
                        <p><span class="label">Responsable:</span> {{ $cotizacion->usuario->persona->name ?? $cotizacion->usuario->email ?? '-' }}</p>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Tabla de Ítems --}}
        <div class="section-title">Detalle de la Cotización</div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 30px;" class="text-center">N°</th>
                    <th>Descripción</th>
                    <th style="width: 50px;" class="text-center">Cant.</th>
                    <th style="width: 45px;" class="text-center">Und.</th>
                    <th style="width: 75px;" class="text-right">P. Unit.</th>
                    <th style="width: 45px;" class="text-center">Dto.</th>
                    <th style="width: 80px;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $numero = 1;
                    $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS;
                @endphp

                @foreach($detallesPorCategoria as $categoria => $items)
                    {{-- Fila de categoría --}}
                    <tr class="cat-row">
                        <td colspan="7">{{ $catInfo[$categoria]['nombre'] ?? ucfirst($categoria) }}</td>
                    </tr>
                    @foreach($items as $item)
                        <tr>
                            <td class="text-center">{{ $numero++ }}</td>
                            <td>
                                {{ $item->descripcion }}
                                @if($item->especificaciones)
                                    <br><span style="color: #888; font-size: 8px;">{{ $item->especificaciones }}</span>
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($item->cantidad, $item->cantidad == intval($item->cantidad) ? 0 : 2) }}</td>
                            <td class="text-center">{{ $item->nombre_unidad }}</td>
                            <td class="text-right">S/ {{ number_format($item->precio_unitario, 2) }}</td>
                            <td class="text-center">
                                @if($item->descuento_porcentaje > 0)
                                    {{ number_format($item->descuento_porcentaje, 0) }}%
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">S/ {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    {{-- Subtotal por categoría --}}
                    <tr class="subtotal-row">
                        <td colspan="6" style="text-align: right; font-size: 8.5px;">Subtotal {{ $catInfo[$categoria]['nombre'] ?? '' }}:</td>
                        <td class="text-right">S/ {{ number_format($items->sum('subtotal'), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totales --}}
        <div class="totales-wrapper clearfix">
            <table class="totales-table">
                <tr>
                    <td class="label-td">Subtotal:</td>
                    <td class="value-td">S/ {{ number_format($cotizacion->subtotal, 2) }}</td>
                </tr>
                @if($cotizacion->descuento_monto > 0)
                    <tr class="descuento-row">
                        <td class="label-td">Descuento ({{ number_format($cotizacion->descuento_porcentaje, 0) }}%):</td>
                        <td class="value-td">- S/ {{ number_format($cotizacion->descuento_monto, 2) }}</td>
                    </tr>
                @endif
                @if($cotizacion->incluye_igv)
                    <tr>
                        <td class="label-td">IGV (18%):</td>
                        <td class="value-td">S/ {{ number_format($cotizacion->igv, 2) }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td class="label-td">TOTAL:</td>
                    <td class="value-td">S/ {{ number_format($cotizacion->total, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Condiciones --}}
        @if($cotizacion->condiciones_comerciales || $cotizacion->garantia_servicio || $cotizacion->observaciones)
            <div class="condiciones">
                <h4>Términos y Condiciones</h4>
                @if($cotizacion->condiciones_comerciales)
                    <p><strong>Condiciones Comerciales:</strong> {{ $cotizacion->condiciones_comerciales }}</p>
                @endif
                @if($cotizacion->garantia_servicio)
                    <p><strong>Garantía de Servicio:</strong> {{ $cotizacion->garantia_servicio }}</p>
                @endif
                @if($cotizacion->observaciones)
                    <p><strong>Observaciones:</strong> {{ $cotizacion->observaciones }}</p>
                @endif
                <p><strong>Vigencia:</strong> Esta cotización es válida hasta el {{ $cotizacion->fecha_vigencia?->format('d/m/Y') }}.</p>
                <p><strong>Tiempo de ejecución:</strong> {{ $cotizacion->tiempo_ejecucion_dias }} días hábiles después de la confirmación del pedido.</p>
            </div>
        @endif

        {{-- Firmas --}}
        <table class="firma-section">
            <tr>
                <td>
                    <div style="margin-top: 50px;">
                        <div class="firma-line">
                            {{ $cotizacion->usuario->persona->name ?? $cotizacion->usuario->email ?? 'Representante' }}<br>
                            <span style="font-size: 8px;">Cisnergia</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="margin-top: 50px;">
                        <div class="firma-line">
                            {{ $cotizacion->oportunidad?->prospecto?->nombre_completo ?? 'Cliente' }}<br>
                            <span style="font-size: 8px;">Aceptación del cliente</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
