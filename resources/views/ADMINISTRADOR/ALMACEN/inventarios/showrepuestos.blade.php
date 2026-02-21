@php
    $sede = \App\Models\Sede::find($sede_id);
    
    $alm_accesorios = App\Models\Inventario::where('tipo_producto', 'Accesorios')->where('sede_id',$sede->id)->get();
    foreach($alm_accesorios as $alm_accesorio){
        $alm_accesorios_sum = $alm_accesorios_sum+($alm_accesorio?$alm_accesorio->cantidad:'0');
    }
    $alm_repuestos = App\Models\Inventario::where('tipo_producto', 'Repuestos')->where('sede_id',$sede->id)->get();
    foreach($alm_repuestos as $alm_repuestos){
        $alm_repuestos_sum = $alm_repuestos_sum+($alm_repuestos?$alm_repuestos->cantidad:'0');
    }
    $alm_modulo_solar = App\Models\Inventario::where('tipo_producto', 'Modulo Solar')->where('sede_id',$sede->id)->get();
    foreach($alm_modulo_solar as $alm_modulo_solares){
        $alm_modulo_solares_sum = $alm_modulo_solares_sum+($alm_modulo_solares?$alm_modulo_solares->cantidad:'0');
    }
@endphp
<div class="modal fade" id="showrepuestos{{$sede->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white py-2">
                <span class="modal-title text-uppercase small" id="staticBackdropLabel">Almacén de repuestos - Sede {{Auth::user()->persona->sede?Auth::user()->persona->sede->name:'General'}}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-beetween mb-3">
                    <div class="col-12 col-md-6 col-xl-3 mb-2 mb-lg-0">
                        <input hidden id="tipo_compras{{$sede->id}}" value="compras_request">
                    </div>
                    <div class="col-12 col-md-1 col-xl-8"></div>
                    <div class="col-12 col-md-6 col-lg-3 col-xl-1 mb-2 mb-lg-0">
                        <button type="button" class="btn btn-dark btn-sm w-100" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-download"></i></button>
                        <ul class="dropdown-menu">      
                            <li class="dropdown-item">
                                <button class="bg-transparent border-0 px-0 mx-0" data-bs-toggle="modal" data-bs-target="#reporte_Excel"><i class="bi bi-file-excel me-2"></i><small>EXCEL</small></button>
                            </li>                                            
                            <li class="dropdown-item">
                                <button class="bg-transparent border-0 px-0 mx-0" id="pdf_almacen" data-bs-toggle="modal" data-bs-target="#reporte_PDF"><i class="bi bi-file-pdf me-2"></i><small>PDF</small></button>
                            </li>                                                    
                        </ul>
                    </div>
                </div>
                <div class="mb-2">
                    <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold">{{--$admin_formulas->count()--}}</span></span>
                </div>
                <table id="" class="display table table-hover table-sm py-2" cellspacing="0" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="h6 text-uppercase fw-bold small">N°</th>
                            <th class="h6 text-uppercase fw-bold small">Código</th>
                            <th class="h6 text-uppercase fw-bold small">Tipo</th>
                            <th class="h6 text-uppercase fw-bold small">Descripción</th>
                            <th class="h6 text-uppercase fw-bold small">U.M.</th>
                            <th class="h6 text-uppercase fw-bold small">Cantidad</th>
                            <th class="h6 text-uppercase fw-bold small text-center">Acciones</th>
                        </tr>
                    </thead>
                    @php
                        $contador = 1;
                    @endphp  
                    <tbody id="inventario_table">
                        @foreach ($al_repuestos as $al_repuesto)
                            @php
                                $codigo_producto = \App\Models\Producto::where('id',$al_repuesto->id_producto)->first();
                            @endphp
                            <tr class="">
                                <td class="fw-normal align-middle">{{ $contador }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $codigo_producto?$codigo_producto->codigo:'' }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $codigo_producto?$codigo_producto->tipo->name:'' }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $al_repuesto->producto }}</td>
                                <td class="fw-normal align-middle">{{ $al_repuesto->umedida }}</td>
                                <td class="fw-normal align-middle">
                                    @if($al_repuesto->cantidad <= 10)
                                        <span class="badge w-100 bg-danger">{{ $al_repuesto->cantidad }}</span>
                                    @elseif($al_repuesto->cantidad <= 20)
                                        <span class="badge w-100 bg-warning">{{ $al_repuesto->cantidad }}</span>
                                    @elseif($al_repuesto->cantidad >= 21)
                                        <span class="badge w-100 bg-success">{{ $al_repuesto->cantidad }}</span>
                                    @endif
                                </td>
                                <td class="fw-normal align-middle text-center"><button type="button" data-bs-toggle="modal" onclick="repuestosdetalle(this,{{$sede->id}},{{$al_repuesto->id_producto}})" data-bs-target="#showrepuesto{{$al_repuesto->id_producto}}"  class="btn btn-sm btn-secondary"><i class="bi bi-eye-fill text-white"></i></button></td>
                            </tr>
                        @php
                            $contador++;
                        @endphp  
                        @endforeach  
                </table>
            </div>
            <div class="modal-footer bg-transparent py-2">
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($al_repuestos as $al_repuesto)
    @include('ADMINISTRADOR.ALMACEN.inventarios.show_dtllerepuestos')
@endforeach
