<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CISNERGIA | MOVIMIENTO DE INGRESO - {{ $admin_ingreso->codigo }} - PDF</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">
    <style>
       
        @font-face {
            font-family: 'Roboto', sans-serif;
            font-style: normal;
            font-weight: normal;
            src: local('Roboto'), url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap') format('truetype');
        }
    
        @page {
            margin: 0cm 0cm;
        }

        .page-break {
            page-break-after: always;
        }
        
        body{
            font-family: 'Roboto', sans-serif;
            margin-top: 2.9cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 1.5cm;
            background-image: url({{ public_path('images/wallpaper_document.png') }});
            background-repeat: no-repeat;
            background-size: 100% auto;
            background-attachment: fixed;
            background-position: center;
        }
    
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2.7cm;
            background-color: transparent;
        }

        header .contenedor{
            display: flex;
            justify-content: center;
            align-items: center;
        }
    
        footer {
            position: fixed; 
            bottom: 0.2cm; 
            left: 0cm; 
            right: 0cm;
            height: 2cm;
        }   



        .bg-primary{
            background-color: #76B82A;
        }

        .bg-success{
            background-color: #009929;
        }

        .bg-danger{
            background-color: #CD0C36;
        }

        .contenido
        {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0.5cm;
        }

        .bg-encabezado{
            background-color: #e0e0e0;
        }

        .border-encabezado{
            border-color: #bfbfbf !important;
        }

        /* .bg-cuerpo{
            background-color: #eeeeee;
        } */

        .texto-11{
            font-size: 11px;
        }

        .no-page-break {
            page-break-inside: avoid;
        }

        .tabla-detalle {
            border-collapse: collapse;
            width: 100%;
        }

        .tabla-detalle th,
        .tabla-detalle td {
            border: 1px solid #bfbfbf !important;
        }
    </style>
</head>
<body>
    <header class="">
        <div class="container contenedor">
            <table class="w-100 mt-3">
                <tr>
                    <td style="width: 15%">
                        <img src="{{ public_path('images/logo_v.png') }}" style="width: 150px; border-radius: 10px 0 10px 0" alt="">
                    </td>
                    <td style="width: 85%">
                        <table class="w-100 mt-3">
                            <tr>
                                <td style="width: 45%" class="border-0 border-bottom border-1 border-dark">
                                    <p class="text-uppercase mb-2 text-start fw-bold">Movimiento de ingreso</p>
                                </td>
                                <td style="width: 35%" class="border-0 border-bottom border-1 border-dark">
                                    <span class="float-end text-uppercase fecha" style="font-size: 11px">
                                        {{$now->isoFormat('dddd D \d\e MMMM \d\e\l Y'.' | '.$now->format('H:i:s'))}}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </header>
    <div class="contenido">
        <table class="mt-2 mb-3" style="width: 100%; font-size: 10px">
            <thead class="bg-encabezado">
                <tr>
                    <th class="text-uppercase border border-encabezado text-center py-1 fw-bold small" style=" width: 10%">Código</th>
                    <th class="text-uppercase border border-encabezado text-center py-1 fw-bold small" style=" width: 10%">Motivo</th>
                    <th class="text-uppercase border border-encabezado text-center py-1 fw-bold small" style=" width: 10%">Fecha</th>
                    <th class="text-uppercase border border-encabezado text-center py-1 fw-bold small" style=" width: 35%">Ingresa a</th>
                    @if($admin_ingreso->motivo == 'COMPRA')
                        <th class="text-uppercase border border-encabezado text-center py-1 fw-bold small" style=" width: 35%">Compra de Origen</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-cuerpo">
                @php
                    $sede_almacen = \App\Models\Sede::where('id',$admin_ingreso->almacen->sede_id)->first();
                @endphp
                <tr>
                    <td class="text-uppercase border border-encabezado text-center py-2 fw-normal small">
                        {{ $admin_ingreso->codigo }}
                    </td>
                    <td class="text-uppercase border border-encabezado text-center py-2 fw-normal small">{{ $admin_ingreso->motivo }}</td>
                    <td class="text-uppercase border border-encabezado text-center py-2 fw-normal small">{{ \Carbon\Carbon::parse($admin_ingreso->created_at)->format('d-m-Y') }}</td>
                    <td class="text-uppercase border border-encabezado text-center py-2 fw-normal small">{{$admin_ingreso->almacen->name}}</td>
                    @if($admin_ingreso->motivo == 'COMPRA')
                        <td class="text-uppercase border border-encabezado text-center py-2 fw-normal small">{{$admin_ingreso->codigo_ocompra}}</td>
                    @endif
                </tr>
            </tbody>
        </table>

        <table class="my-2" style="width: 100%; font-size: 10px;">
            <thead class="bg-encabezado">
                <tr>
                    <th class="text-uppercase border border-encabezado text-center py-1 fw-bold small" style="width: 50%">Registrado por</th>
                </tr>
            </thead>
            <tbody class="bg-cuerpo">
                <tr>
                    <td class="text-uppercase border border-encabezado text-center py-2 fw-normal small">{{ $admin_ingreso->registrado_por }}</td>
                </tr>
            </tbody>
        </table>

        <table class="w-100 mt-3 tabla-detalle" style="font-size: 11px;">
            <thead class="">
                <tr>
                    <th class="border border-encabezado py-1 text-uppercase small text-center" style="width: 5%">N°</th>
                    <th class="border border-encabezado py-1 text-uppercase small text-center" style="width: 14%">Tipo</th>
                    <th class="border border-encabezado py-1 text-uppercase small text-center" style="width: 44%">Descripción</th>
                    <th class="border border-encabezado py-1 text-uppercase small text-center" style="width: 5%">Lote</th>
                    <th class="border border-encabezado py-1 text-uppercase small text-center" style="width: 7%">Cant.</th>
                    <th class="border border-encabezado py-1 text-uppercase small text-center" style="width: 10%">Precio</th>
                </tr>
            </thead>
                <tbody>
                    @php
                        $contador = 1;
                    @endphp
                    @foreach($dtlle_ingreso as $item)
                        @php
                            $tipo_ = \App\Models\Tipo::where('name',$item->tipo_producto)->first();
                        @endphp
                        <tr class="text-uppercase">
                            <td class="border-0 border-end border-start py-1 border-encabezado text-center">{{ $contador }}</td>
                            <td class="border-0 border-end py-1 border-encabezado text-center">{{ $tipo_->name }}</td>
                            <td class="border-0 border-end py-1 border-encabezado text-center">{{ $item->producto.' - '.$item->umedida }}</td>
                            <td class="border-0 border-end py-1 border-encabezado text-center">{{ $item->lote }}</td>
                            <td class="border-0 border-end py-1 border-encabezado text-center">{{ $item->cantidad }}</td>
                            <td class="border-0 border-end py-1 border-encabezado text-end pe-2">
                                @if($item->precio == NULL)
                                    -
                                @else
                                    {{ number_format($item->precio, 2, '.', ',') }}
                                @endif
                            </td>
                        </tr> 
                        @php
                            $contador++;
                        @endphp
                    @endforeach
                    @php
                        $filas_totales = 20;
                        $filas_vacias = max($filas_totales - $dtlle_ingreso->count(), 0);
                    @endphp
                    @for($i = 0; $i < $filas_vacias; $i++)
                        <tr>
                            <td class="py-1 border-0 border-end border-start border-encabezado"><span style="opacity: 0;">0</span></td>
                            <td class="py-1 border-0 border-end border-encabezado"><span style="opacity: 0;">0</span></td>
                            <td class="py-1 border-0 border-end border-encabezado"><span style="opacity: 0;">0</span></td>
                            <td class="py-1 border-0 border-end border-encabezado"><span style="opacity: 0;">0</span></td>
                            <td class="py-1 border-0 border-end border-encabezado"><span style="opacity: 0;">0</span></td>
                            <td class="py-1 border-0 border-end border-encabezado"><span style="opacity: 0;">0</span></td>
                        </tr>
                    @endfor
                        <tr class="text-uppercase">
                            <td colspan="2" class="border-0 border-top border-end py-1 border-encabezado text-center fw-bold"></td>
                            <td colspan="3" class="border-0 border-top border-end border-bottom px-2 py-1 border-encabezado fw-bold">
                                CANTIDAD TOTAL 
                            </td>
                            <td class="border-0 border-top border-end border-bottom  py-1 border-encabezado text-end px-2 fw-bold">{{ number_format($admin_ingreso->total ?? 0, 2, '.', ',') }}</td>
                        </tr>
                </tbody>
        </table>

        <div class="card border-encabezado mt-3 no-page-break" style="font-size: 11px;">
            <div class="card-body p-1">
                <p class="fw-bold mb-1">Observaciones:</p>
                <p>- {{$admin_ingreso->descripcion?$admin_ingreso->descripcion:'Sin observaciones'}}</p>
            </div>
        </div>
    </div>

    <footer>
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Roboto, sans-serif", "normal");
                    $pdf->text(270, 820, "PÁGINA $PAGE_NUM DE $PAGE_COUNT", $font, 8);
                ');
            }
        </script>
    </footer>
    
</body>
</html>