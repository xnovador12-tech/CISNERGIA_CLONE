<div class="modal fade" id="showtipoproducto{{ $alm_tipo_productos->id_producto }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2">
                <span class="modal-title text-uppercase small" id="staticBackdropLabel">Detalles de registro</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $producto_tipo = \App\Models\Producto::where('id',$alm_tipo_productos->id_producto)->first();
                @endphp
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-2">
                        <div class="mb-3">
                            <img for="uploadImage1" id="uploadPreview1" alt="" class="img-fluid shadow-sm" style="object-fit: cover; background-color: #bfbfbf; border-radius: 20px" src="
                            @if($producto_tipo)
                                @if($producto_tipo->imagen != "image.jpg")
                                    /images/productos/{{$producto_tipo->imagen}}
                                @else
                                    /images/image.png
                                @endif
                            @else
                                /images/image.png
                            @endif
                            ">   
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-10 d-flex">
                        <div class="align-self-center">
                            <p class="text-uppercase small mb-0">{{ $alm_tipo_productos->producto }} - {{ $alm_tipo_productos->umedida }}</p>
                            <span class="border rounded px-2 fw-bold border-dark text-uppercase" style="font-size: 12px">{{$producto_tipo?$producto_tipo->tipo->name:''}}</span>
                            <p class="small text-uppercase text-primary fw-bold mb-0" style="font-size: 12px">{{$producto_tipo?$producto_tipo->tipo_costo:''}}</p>
                            <p class="float-start text-uppercase small">Stock: <span class="float-end badge bg-primary ms-2">{{$alm_tipo_productos->cantidad}}</span></p>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style=" font-size: 13.5px">
                    <table class="display_2 table table-hover w-100 mt-3">
                        <thead>
                            <tr>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 5%">N°</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 15%">Movimiento</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 50%">Motivo</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 50%">Codigo de Movimiento</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 50%">Lote</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 10%">Fecha</th>
                                <th class="align-middle fw-bold text-uppercase small text-center" style="width: 10%">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 1;
                                $mov_ingresos = DB::table('ingresos as ings')->join('detalleingresos as dtll','dtll.ingreso_id','=','ings.id')->select('ings.codigo_ocompra','dtll.lote','ings.motivo','ings.created_at','ings.fecha','dtll.cantidad')->where('dtll.id_producto',$alm_tipo_productos->id_producto)->groupby('ings.codigo_ocompra','dtll.lote','ings.motivo','ings.created_at','ings.fecha','dtll.cantidad')->get();
                            @endphp
                            @foreach($mov_ingresos as $mov_ingreso)
                            <tr>
                                <td class="align-middle text-uppercase text-center">{{$contador}}</td>
                                    @if($mov_ingreso->motivo == 'Inventario')
                                        <td class="align-middle text-uppercase text-center text-success">
                                        INGRESO</td>
                                        @else
                                        <td class="align-middle text-uppercase text-center text-danger">
                                        SALIDA</td>
                                    @endif
                                <td class="align-middle text-uppercase text-center">{{$mov_ingreso->motivo}}</td>
                                <td class="align-middle text-uppercase text-center">{{$mov_ingreso->codigo_ocompra}}</td>
                                <td class="align-middle text-uppercase text-center">{{$mov_ingreso->lote}}</td>
                                <td class="align-middle text-uppercase text-center">{{$mov_ingreso->fecha}}</td>
                                <td class="align-middle text-uppercase text-center text-sucess">{{$mov_ingreso->cantidad}}</td>
                            </tr>
                                @php
                                    $contador++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>