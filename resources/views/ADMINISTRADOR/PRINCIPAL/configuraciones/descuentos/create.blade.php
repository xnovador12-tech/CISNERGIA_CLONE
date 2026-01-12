<form method="POST" action="{{ route('admin-descuentos.store') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf    
    <div class="modal fade" id="createdescuento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <div class="col-12 col-md-8 col-lg-6">
                                <div class="pb-3">
                                    <label for="name_id" class="form-label">Título<span class="text-danger">*</span></label>
                                    <input type="text" name="titulo" id="titulo_id" value="{{old('titulo')}}" class="form-control form-control-sm" maxLength="100">
                                    @error('titulo')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="" class="form-label">Se aplica a<span class="text-danger">*</span></label>
                                    <select id="categoria_ids" class="form-select form-select-sm select2_bootstrap_2">
                                        <option selected hidden>Seleccione una categoria</option>
                                        @foreach($admin_categorias as $categoria)
                                            <option value="{{$categoria->id}}_{{$categoria->name}}">{{$categoria->name}}</option>                                
                                        @endforeach
                                    </select>
                                    <input hidden name="categorie_id" id="__categoria__">
                                    @error('categorie_id')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="pb-3">
                                    <label for="" class="form-label">Porcentaje DESC.<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="number" id="porcentaje_id" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
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
                                    <label for="hora__inicio__id" class="form-label">Hora Inicio<span class="text-danger">*</span></label>
                                    <input type="time" name="hora_inicio" autocomplete="off" id="hora__inicio__id" value="" class="form-control form-control-sm">
                                    @error('hora_inicio')
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

                        <div class="mt-3">
                            <p class="text-muted mb-2 small text-uppercase fw-bold">Asignar productos a descuento</p>
                            <input type="checkbox" class="form-check-input" id="option-all">
                            <label class="form-check-label" for="option-all">Seleccionar Todo</label>
            
                            <div class="row my-3" id="subc">
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

