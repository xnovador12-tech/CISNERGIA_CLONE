<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Voucher de Pago - {{ $pedido->codigo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #2c3e50;
            line-height: 1.4;
            padding: 20px;
            background: #ffffff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* Header Mejorado */
        .header {
            width: 100%;
            border-bottom: 2px solid #1565c0;
            padding-bottom: 10px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .logo {
            width: 180px;
            max-height: 70px;
        }
        
        .company-info {
            position: absolute;
            right: 0;
            top: 0;
            text-align: right;
            width: 250px;
        }
        
        .company-info h2 {
            margin: 0 0 5px 0;
            color: #1565c0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        .company-info p {
            margin: 0;
            font-size: 9px;
            color: #555;
            line-height: 1.3;
        }
        
        /* Título Principal Mejorado */
        .title-box {
            background: #f8f9fa;
            border-left: 4px solid #1565c0;
            padding: 15px;
            text-align: left;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .title-box h1 {
            margin: 0 0 4px 0;
            font-size: 18px;
            color: #1565c0;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .title-box p {
            margin: 0;
            color: #495057;
            font-size: 12px;
            font-weight: 500;
        }
        
        /* Sección de Información General */
        .info-section {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 15px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 8px 10px;
            vertical-align: top;
        }
        
        .label {
            font-weight: 600;
            color: #495057;
            width: 130px;
            font-size: 11px;
        }
        
        .info-table td:nth-child(even) {
            font-weight: 500;
            color: #2c3e50;
        }
        
        /* Caja de Pago Mejorada */
        .payment-box {
            background: #ffffff;
            border: 1px solid #4caf50;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .payment-box h3 {
            margin: 0 0 10px 0;
            color: #2e7d32;
            font-size: 13px;
            border-bottom: 1px solid #4caf50;
            padding-bottom: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .payment-box .info-table td {
            padding: 10px;
        }
        
        .payment-box .label {
            color: #2e7d32;
            font-weight: 600;
        }
        
        .payment-amount {
            font-weight: bold;
            color: #2e7d32;
            font-size: 15px;
        }
        
        /* Sección de Cuotas Mejorada */
        .installments-section {
            width: 100%;
            margin-bottom: 15px;
            background-color: #f1f8ff;
            border: 1px solid #1565c0;
            border-radius: 4px;
            padding: 10px;
        }
        
        .installments-section h3 {
            font-size: 14px;
            color: #0d47a1;
            margin-bottom: 10px;
            border-left: 4px solid #1565c0;
            padding-left: 12px;
            font-weight: bold;
        }
        
        .installments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: white;
        }
        
        .installments-table th {
            background-color: #1565c0;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 11px;
            border: 1px solid #0d47a1;
            font-weight: bold;
        }
        
        .installments-table td {
            border: 1px solid #e3f2fd;
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }
        
        .installments-table tr:nth-child(even) {
            background-color: #e3f2fd;
        }
        
        /* Tabla de Productos Mejorada */
        .section-title {
            font-size: 13px;
            color: #1565c0;
            margin: 15px 0 10px 0;
            border-left: 4px solid #1565c0;
            padding-left: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .items-table th {
            background-color: #f1f1f1;
            color: #333;
            padding: 8px 10px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #e0e0e0;
        }
        
        .items-table td {
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            font-size: 11px;
            background-color: white;
            vertical-align: middle;
        }
        
        .items-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
        
        .items-table tr:hover td {
            background-color: #e1f5fe;
        }
        
        /* Tabla de Totales Mejorada */
        .totals-section {
            float: right;
            width: 300px;
            margin-top: 10px;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .qr-section {
            float: left;
            width: 100px;
            margin-top: 10px;
        }
        
        .qr-placeholder {
            width: 80px;
            height: 80px;
            border: 1px solid #eee;
            background-color: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #ccc;
            text-align: center;
            padding: 5px;
        }
        
        .totals-table td {
            padding: 10px 15px;
            text-align: right;
            font-size: 12px;
        }
        
        .totals-table td:first-child {
            font-weight: 600;
            color: #495057;
            text-align: left;
        }
        
        .totals-table tr {
            border-bottom: 1px solid #dee2e6;
        }
        
        .total-row {
            background-color: #1565c0;
            color: white !important;
        }
        
        .total-row td {
            font-size: 14px;
            font-weight: bold;
            padding: 8px 15px;
            color: white;
        }
        
        /* Sello de Verificación Mejorado */
        .stamp {
            margin-top: 50px;
            text-align: right;
            margin-bottom: 50px;
        }
        
        .stamp-box {
            display: inline-block;
            border: 3px solid #4caf50;
            color: #2e7d32;
            padding: 15px 30px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 12px;
            transform: rotate(-8deg);
            box-shadow: 0 4px 8px rgba(76, 175, 80, 0.3);
            background-color: rgba(76, 175, 80, 0.08);
        }
        
        .stamp-box .stamp-title {
            font-size: 16px;
            letter-spacing: 1px;
        }
        
        .stamp-box .stamp-subtitle {
            font-size: 10px;
            margin-top: 3px;
            opacity: 0.8;
        }
        
        /* Footer Mejorado */
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            line-height: 1.4;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .clear {
            clear: both;
        }
        
        /* Mejoras de impresión */
        @media print {
            body {
                padding: 20px;
            }
            .stamp-box {
                border-color: #4caf50 !important;
                color: #2e7d32 !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $venta = $pedido->venta;
            $medioPago = $venta?->mediopago?->name ?? $pedido->pago_banco ?? 'No especificado';
            $tipoComprobante = $venta?->tipocomprobante?->name ?? 'Pendiente de emisión';
            $numeroComprobante = $venta?->numero_comprobante ?? 'Pendiente de emisión';
            $montoPagado = (float)($pedido->pago_monto ?? $pedido->total);
            $saldoPendiente = max((float)$pedido->total - $montoPagado, 0);
            $path = base_path('public/images/logo_v.png');
            $logoSrc = null;
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $logoSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        @endphp
        <div class="header">
            @if($logoSrc)
                <img src="{{ $logoSrc }}" class="logo" alt="Logo Cisnergia">
            @endif
            <div class="company-info">
                <h2>CISNERGIA PERÚ</h2>
                <p><strong>RUC:</strong> 2060XXXXXXXXX</p>
                <p>Calle Ficticia 123 - Lima, Perú</p>
                <p>ventas@cisnergiaperu.com | www.cisnergiaperu.com</p>
            </div>
        </div>

        <div class="title-box">
            <h1>COMPROBANTE DE PAGO</h1>
            <p>Pedido N°: <strong>{{ $pedido->codigo }}</strong></p>
        </div>

        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td class="label">CLIENTE:</td>
                    <td>{{ $pedido->cliente->nombre_completo }}</td>
                    <td class="label">DOCUMENTO:</td>
                    <td>{{ $pedido->cliente->documento }}</td>
                </tr>
                <tr>
                    <td class="label">FECHA PEDIDO:</td>
                    <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                    <td class="label">VENDEDOR:</td>
                    <td>{{ $pedido->usuario->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">ORIGEN:</td>
                    <td>{{ ucfirst($pedido->origen) }}</td>
                    <td class="label">CONDICIÓN:</td>
                    <td><strong>{{ $pedido->condicion_pago }}</strong></td>
                </tr>
                <tr>
                    <td class="label">CÓDIGO VENTA:</td>
                    <td>{{ $venta?->codigo ?? 'Pendiente de emisión' }}</td>
                    <td class="label">MEDIO DE PAGO:</td>
                    <td><strong>{{ $medioPago }}</strong></td>
                </tr>
                <tr>
                    <td class="label">TIPO COMPROBANTE:</td>
                    <td>{{ $tipoComprobante }}</td>
                    <td class="label">N° COMPROBANTE:</td>
                    <td>{{ $numeroComprobante }}</td>
                </tr>
                @if($venta && $venta->tipoOperacion)
                <tr>
                    <td class="label">TIPO OPERACIÓN:</td>
                    <td>{{ $venta->tipoOperacion->code }} - {{ $venta->tipoOperacion->descripcion }}</td>
                    @if($venta->tipoDetraccion)
                    <td class="label">DETRACCIÓN:</td>
                    <td><strong>{{ $venta->tipoDetraccion->code }} - {{ $venta->tipoDetraccion->descripcion }} ({{ $venta->tipoDetraccion->porcentaje }}%)</strong></td>
                    @else
                    <td></td><td></td>
                    @endif
                </tr>
                @endif
            </table>
        </div>

        <div class="payment-box">
            <h3>INFORMACIÓN DE LA TRANSACCIÓN</h3>
            <table class="info-table">
                <tr>
                    <td class="label">BANCO / MEDIO:</td>
                    <td><strong>{{ $medioPago }}</strong></td>
                    <td class="label">N° OPERACIÓN:</td>
                    <td><strong>{{ $pedido->pago_operacion ?? '---' }}</strong></td>
                </tr>
                <tr>
                    <td class="label">MONTO PAGADO:</td>
                    <td class="payment-amount">S/ {{ number_format($montoPagado, 2) }}</td>
                    <td class="label">FECHA PAGO:</td>
                    <td><strong>{{ $pedido->pago_fecha ? \Carbon\Carbon::parse($pedido->pago_fecha)->format('d/m/Y') : $pedido->created_at->format('d/m/Y') }}</strong></td>
                </tr>
            </table>
        </div>

        @if($pedido->condicion_pago === 'Crédito' && $pedido->cuotas->count() > 0)
        <div class="installments-section">
            <h3>CRONOGRAMA DE PAGOS (CRÉDITO)</h3>
            <table class="installments-table">
                <thead>
                    <tr>
                        <th>CUOTA N°</th>
                        <th>FECHA DE VENCIMIENTO</th>
                        <th>IMPORTE</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->cuotas as $cuota)
                    <tr>
                        <td><strong>{{ $cuota->numero_cuota }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                        <td style="font-weight: bold;">S/ {{ number_format($cuota->importe, 2) }}</td>
                        <td style="color: #777; font-style: italic;">Pendiente</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <h3 class="section-title">DETALLE DEL PEDIDO</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 80px;">TIPO</th>
                    <th style="text-align: left;">DESCRIPCIÓN</th>
                    <th style="width: 60px;">CANT.</th>
                    <th style="width: 60px;">U.M.</th>
                    <th style="width: 100px;">P. UNITARIO</th>
                    <th style="width: 100px;">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->detalles as $detalle)
                <tr>
                    <td style="text-align: center; text-transform: uppercase;">{{ $detalle->tipo ?? 'producto' }}</td>
                    <td style="text-align: left;">{{ $detalle->descripcion }}</td>
                    <td style="text-align: center;">{{ number_format($detalle->cantidad, 2) }}</td>
                    <td style="text-align: center;">{{ $detalle->unidad ?? 'und' }}</td>
                    <td style="text-align: right;">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td style="text-align: right; font-weight: 600;">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="qr-section">
            <div class="qr-placeholder">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(url()->current()) }}" width="80" height="80" alt="QR Validation">
                <br>VALIDAR DOCUMENTO
            </div>
        </div>

        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Subtotal:</td>
                    <td>S/ {{ number_format($pedido->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>IGV (18%):</td>
                    <td>S/ {{ number_format($pedido->igv, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL:</td>
                    <td>S/ {{ number_format($pedido->total, 2) }}</td>
                </tr>
                @if($venta && $venta->monto_detraccion > 0)
                <tr>
                    <td style="color: #dc3545; font-size: 10px;">DETRACCIÓN ({{ $venta->tipoDetraccion->porcentaje ?? 0 }}%):</td>
                    <td style="font-weight: bold; color: #dc3545;">- S/ {{ number_format($venta->monto_detraccion, 2) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; font-size: 11px;">NETO A COBRAR:</td>
                    <td style="font-weight: bold; color: #2e7d32; font-size: 13px;">S/ {{ number_format($venta->monto_neto, 2) }}</td>
                </tr>
                @endif
                @if($pedido->condicion_pago === 'Crédito')
                <tr>
                    <td style="color: #666; font-size: 10px;">SALDO PENDIENTE:</td>
                    <td style="font-weight: bold; color: #dc3545;">S/ {{ number_format($saldoPendiente, 2) }}</td>
                </tr>
                @endif
            </table>
            <p style="text-align: right; font-size: 8px; color: #999; margin-top: 5px;">Moneda: Soles (PEN)</p>
        </div>

        <div class="clear"></div>

        {{-- El sello ha sido removido a petición del usuario --}}

        <div class="footer">
            <p><strong>CISNERGIA PERÚ | RUC: 20XXXXXXXXX</strong></p>
            <p>Este documento es una constancia de pago interna de Cisnergia Perú.</p>
            <p>No reemplaza al comprobante de pago electrónico (Boleta o Factura) que será emitido posteriormente.</p>
            <p>www.cisnergiaperu.com</p>
        </div>
    </div>
</body>
</html>
