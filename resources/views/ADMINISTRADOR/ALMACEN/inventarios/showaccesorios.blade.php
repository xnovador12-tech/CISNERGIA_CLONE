@php
    $sede = \App\Models\Sede::find($sede_id);
    $tipo_producto = $tipo_producto ?? null;
    $modal_suffix = \Illuminate\Support\Str::slug((string) $tipo_producto, '-');
    
    $alm_tipo_producto = App\Models\Inventario::where('sede_id',$sede->id)
        ->when($tipo_producto, function ($query) use ($tipo_producto) {
            $query->where('tipo_producto', $tipo_producto);
        })
        ->get();
    foreach($alm_tipo_producto as $alm_tipo_productos){
        $alm_tipos_sum = $alm_tipos_sum+($alm_tipo_productos?$alm_tipo_productos->cantidad:'0');
    }
@endphp
<div class="modal fade" id="showtipoproducto{{$sede->id}}_{{$modal_suffix}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white py-2">
                <span class="modal-title text-uppercase small" id="staticBackdropLabel">Almacén - Sede {{Auth::user()->persona->sede?Auth::user()->persona->sede->name:'General'}} | Tipo: <span id="tipo_producto_modal{{$sede->id}}_{{$modal_suffix}}">{{ $tipo_producto ?? 'Todos' }}</span></span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-beetween mb-3">
                    <div class="col-12 col-md-6 col-xl-3 mb-2 mb-lg-0">
                        <input hidden id="tipo_compras{{$sede->id}}" value="compras_request">
                        <input hidden id="tipo_producto_value{{$sede->id}}_{{$modal_suffix}}" value="{{ $tipo_producto }}">
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
                    <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold" id="total_registros_tipo{{$sede->id}}_{{$modal_suffix}}">{{ $alm_tipo_producto->count() }}</span></span>
                </div>
                <table id="" class="display table table-hover table-sm py-2" cellspacing="0" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="h6 text-uppercase fw-bold small">N°</th>
                            <th class="h6 text-uppercase fw-bold small">Código</th>
                            <th class="h6 text-uppercase fw-bold small">Tipo</th>
                            <th class="h6 text-uppercase fw-bold small">Categoria / Subcategoria</th>
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
                        @foreach ($alm_tipo_producto as $alm_tipo_productos)
                            @php
                                $codigo_producto = \App\Models\Producto::where('id',$alm_tipo_productos->id_producto)->first();
                            @endphp
                            <tr class="" data-tipo="{{ $alm_tipo_productos->tipo_producto }}">
                                <td class="fw-normal align-middle">{{ $contador }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $codigo_producto?$codigo_producto->codigo:'' }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $codigo_producto?$codigo_producto->tipo->name:'' }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $codigo_producto?->categorie?->name }}{{ $codigo_producto?->subcategories?->name ? ' \ ' . $codigo_producto->subcategories->name : '' }}</td>
                                <td class="fw-normal align-middle text-uppercase small">{{ $alm_tipo_productos->producto }}</td>
                                <td class="fw-normal align-middle">{{ $alm_tipo_productos->umedida }}</td>
                                <td class="fw-normal align-middle">
                                    @if($alm_tipo_productos->cantidad <= $codigo_producto->stock_critico)
                                        <span class="badge w-100 bg-danger">{{ $alm_tipo_productos->cantidad }}</span>
                                    @elseif($alm_tipo_productos->cantidad <= $codigo_producto->stock_seguro)
                                        <span class="badge w-100 bg-warning">{{ $alm_tipo_productos->cantidad }}</span>
                                    @elseif($alm_tipo_productos->cantidad >= $codigo_producto->stock_seguro)
                                        <span class="badge w-100 bg-success">{{ $alm_tipo_productos->cantidad }}</span>
                                    @endif
                                </td>
                                <td class="fw-normal align-middle text-center"><button type="button" data-bs-toggle="modal" onclick="tipoproductodetalle(this,{{$sede->id}},{{$alm_tipo_productos->id_producto}})" data-bs-target="#showtipoproducto{{$alm_tipo_productos->id_producto}}"  class="btn btn-sm btn-secondary"><i class="bi bi-eye-fill text-white"></i></button></td>
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
@foreach ($alm_tipo_producto as $alm_tipo_productos)
    @include('ADMINISTRADOR.ALMACEN.inventarios.show_dtlleaccesorios')
@endforeach
