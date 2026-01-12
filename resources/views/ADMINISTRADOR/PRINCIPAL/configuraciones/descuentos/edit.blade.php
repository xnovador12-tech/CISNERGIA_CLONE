<form method="POST" action="{{ route('admin-descuentos.update', $admin_descuento->slug) }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf  
    @method('put')     
    <div class="modal fade" id="editdescuento{{$admin_descuento->slug}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Nueva categoría</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <span class="text-danger">* <small class="text-muted py-0 my-0 text-start"> - Campos obligatorios</small></span>
                        <p class="text-muted mb-2 small text-uppercase fw-bold">Datos de producto</p>
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="pb-3">
                                    <label for="name_id" class="form-label">Título<span class="text-danger">*</span></label>
                                    <input type="text" disabled name="titulo" id="titulo_id" value="{{$admin_descuento->titulo}}" class="form-control form-control-sm" maxLength="100">
                                    @error('titulo')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="pb-3">
                                    <label for="" class="form-label">Se aplica a<span class="text-danger">*</span></label>
                                    <input type="text" disabled name="titulo" id="titulo_id" value="{{$admin_descuento->categorie->name}}" class="form-control form-control-sm" maxLength="100">
                                    @error('categoria_id')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="pb-3">
                                    <label for="" class="form-label">Porcentaje DESC.<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="number" value="{{$admin_descuento->porcentaje}}" id="porcentajes_id" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="input-group-text text-danger fw-bold" id="inputGroup-sizing-sm">%</span>
                                    </div>
                                    @error('porcentaje')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="fecha__inicio__id" class="form-label">Fecha Inicio<span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_inicio" value="{{$admin_descuento->fecha_inicio}}" autocomplete="off" id="fecha__inicio__id" class="form-control form-control-sm">
                                    @error('fecha_inicio')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="hora__inicio__id" class="form-label">Hora Inicio<span class="text-danger">*</span></label>
                                    <input type="time" name="hora_inicio" autocomplete="off" id="hora__inicio__id" class="form-control form-control-sm">
                                    @error('hora_inicio')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="fecha_fin_id" class="form-label">Fecha Fin<span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_fin" value="{{$admin_descuento->fecha_fin}}" autocomplete="off" id="fecha_fin_id" class="form-control form-control-sm">
                                    @error('fecha_fin')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="hora__fin__id" class="form-label">Hora Fin<span class="text-danger">*</span></label>
                                    <input type="time" name="hora_fin" autocomplete="off" id="hora__fin__id" class="form-control form-control-sm">
                                    @error('hora_fin')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @php
                            $dtlle_disco = \App\Models\Detaildiscount::where('discount_id',$admin_descuento->id)->get();
                        @endphp
                        <div class="mt-3">
                            <p class="text-muted mb-2 small text-uppercase fw-bold">Asignar productos a descuento</p>
                            <input type="checkbox" hidden class="form-check-input" id="option-all">
            
                            <div class="row my-3" id="subc{{$admin_descuento->id}}">
                                @foreach($dtlle_disco as $dtlles)
                                    @php
                                        $product_val = \App\Models\Producto::where('id',$dtlles->producto_id)->first();
                                    @endphp
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <input type="checkbox" disabled class="form-check-input" {{$product_val?'checked':''}}  id="producto1">
                                        <label class="form-check-label" for="producto1">{{$product_val->name}}</label>
                                        <input hidden value="{{$dtlles->producto_id}}" name="producto_id[]">
                                        <input hidden value="{{$product_val->slug}}" name="sku[]">
                                        <input hidden value="{{$product_val->precio}}" name="precio[]">
                                        <input hidden value="{{$dtlles->fecha_inicio}}" name="fecha_inicios[]" id="f_inicial">
                                        <input hidden value="{{$dtlles->fecha_fin}}" name="fecha_finales[]" id="f_final">
                                        <input hidden value="{{$dtlles->porcentaje}}" name="porcentajes[]" id="porcentaje_id">
                                    </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark text-uppercase small px-5 text-white">Registrar</button>   
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function previewImage(nb) {        
    var reader = new FileReader();         
    reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);         
    reader.onload = function (e) {             
        document.getElementById('uploadPreview'+nb).src = e.target.result;         
    };     
    }
</script>

