<form method="POST" action="{{ route('admin-cupones.store') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf    
    <div class="modal fade" id="createcupons" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Nuevo cupón</span>
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
                                    <input type="text" name="titulo" id="titulo_id" value="{{old('titulo')}}" class="form-control form-control-sm" maxLength="100">
                                    @error('titulo')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-5 col-lg-5">
                                <div class="pb-3">
                                    <label for="" class="form-label">Generar codigo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm mb-3">
                                        <button type="button" class="input-group-text" id="search_cupons_id"><i class="bi bi-search"></i></button>
                                        <input type="text" id="codigo_cupon_id" name="codigo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    @error('codigo')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-3 col-lg-3">
                                <div class="pb-3">
                                    <label for="" class="form-label">Porcentaje DESC.<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="number" name="porcentaje" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">%</span>
                                    </div>
                                    @error('porcentaje')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="fecha__inicio__id" class="form-label">Fecha Inicio<span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_inicio" autocomplete="off" id="fecha__inicio__id" value="" class="form-control form-control-sm">
                                    @error('fecha_inicio')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="fecha_fin_id" class="form-label">Fecha Fin<span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_fin" autocomplete="off" id="fecha_fin_id" class="form-control form-control-sm">
                                    @error('fecha_fin')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
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

