<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOVIMIENTOS INGRESOS</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/administrador.css">
    <link rel="stylesheet" href="/css/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/css/datatables/select.bootstrap5.min.css">
    <link rel="stylesheet" href="/css/datatables/responsive.bootstrap.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/select2.min.css">
    <link rel="icon" href="/images/ICON-1.png">
</head>
<table id="tcompany" class="table table-hover table-sm" cellspacing="0" style="width:100%">
        <thead>
            <tr>
                <th colspan="7" rowspan="4" style="background-color:#76B82A; color:white; font-size:20px;font-weight: bold; text-align:center; vertical-align:middle;"><u>REGISTRO DE MOVIMIENTO DE INGRESO</u></th>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
            <tr>
            </tr>
        </thead>
        <thead>
            <tr>
                @if(empty($name_sucursal && $fi && $ff))
                <th colspan="6" style="background-color: #fefdfd ; color:black; font-size:20px;font-weight: bold; text-align: center;"><u>Se muestra toda la lista de movimientos registradas en todas las sucursales</u></th>
                @else
                <th colspan="7" style="background-color: #fefdfd ; color:black; font-size:20px;font-weight: bold; text-align: center;"><u>Se muestra la lista de movimientos de ingresos registradas en: {{ $name_sucursal->name }}</u></th>
                @endif
            </tr>
            <tr>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">N°</th>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">Codigo</th>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">Fecha</th>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">Motivo</th>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">Codigo de origen</th>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">Registrado por</th>
                <th class="h6" style="text-align: center;background-color:#6E7E6B; color:white;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $contador = 1;
            @endphp
            @foreach($ingresos as $item)
                <tr>
                    <td class="font-weight-light" style="text-align: center; border:2px;">{{ $contador }}</td>
                    <td class="fw-normal align-middle text-center"><span class="badge bg-secondary">{{ $item->codigo }}</span></td>
                    <td class="font-weight-light" style="text-align: center; border:2px;">{{$item->created_at->format('d-m-Y H:i:s')}}</td>
                    <td class="font-weight-light" style="text-align: center; border:2px;">{{ $item->motivo }}</td>
                    <td class="font-weight-light py-1 border-dark text-center text-uppercase" style="text-align: center; border:2px;">
                        @if($item->motivo == 'COMPRA')
                            <b>CC: </b>{{$item->codigo_ocompra}}
                        @elseif($item->motivo == 'TRASLADO')
                            <b>CS: </b>{{$item->codigo_msalida}}
                        @else
                            <b>CV: </b>{{$item->codigo_venta}}
                        @endif
                    </td>
                    <td class="font-weight-light" style="text-align: center; border:2px;">{{ $item->registrado_por}}</td>
                    <td class="font-weight-light" style="text-align: center; border:2px;">{{ $item->total }}</td>
                </tr>
                @php 
                    $contador++;
                @endphp
            @endforeach
        </tbody> 
</table>
</html>