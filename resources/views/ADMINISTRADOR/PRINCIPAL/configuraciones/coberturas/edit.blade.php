<form method="POST" action="{{ route('admin-coberturas.update', $admin_cobertura->slug) }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf  
    @method('put')  
    <div class="modal fade" id="editcoberturas{{ $admin_cobertura->slug }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Actualizar categoria</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 rounded-0 border-start border-3 border-info bg-light mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px;">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>Importante:
                            <ul class="list-unstyled mb-0 pb-0">
                                <li class="mb-0 pb-0">
                                    <small class="text-muted py-0 my-0 text-start"> Se consideran campos obligatorios los campos que tengan este simbolo: <span class="text-danger">*</small></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="mb-3">
                                <label for="name_id">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name_id" class="form-control" value="{{ $admin_cobertura->name }}"  maxLength="100" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="precio_id">Precio<span class="text-danger">*</span></label>
                                <input type="number" name="precio" id="precio_id" class="form-control @error('precio') is-invalid @enderror" value="{{$admin_cobertura->precio}}"  required>
                                @error('precio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tipos_id" class=" d-block">Departamento - Provincia - Distrito<span class="text-danger">*</span></label>
                                <select id="ubigeos__ids{{ $admin_cobertura->slug }}" class="ubigeos__ids_edit form-select form-select-sm select2 @error('distrito_id') is-invalid @enderror" data-slug="{{ $admin_cobertura->slug }}">
                                    <option selected="selected" hidden="hidden"></option>
                                    @foreach($ubigeos as $ubigeo) 
                                        <option value="{{ $ubigeo->departamento_ids }}_{{ $ubigeo->provincia_ids }}_{{ $ubigeo->distrito_ids }}">{{ $ubigeo->departamento_name.'/'.$ubigeo->provincia_name.'/'.$ubigeo->distrito_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="departamento_ids{{ $admin_cobertura->slug }}" name="departamento_id" value="{{ $admin_cobertura->departamento_id }}">
                                <input type="hidden" id="provincias_ids{{ $admin_cobertura->slug }}" name="provincia_id" value="{{ $admin_cobertura->provincia_id }}">
                                <input type="hidden" id="distritos_ids{{ $admin_cobertura->slug }}" name="distrito_id" value="{{ $admin_cobertura->distrito_id }}">
                                @error('tipo_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror    
                            </div>
                            <div class="mb-3">
                                <label for="estado_id">Estado<span class="text-danger">*</span></label>
                                <select name="estado" id="estado_id" class="form-select text-uppercase" required>
                                    <option value="{{ $admin_cobertura->estado }}" selected="selected" hidden="hidden">{{ $admin_cobertura->estado }}</option>
                                    <option value="Activo">ACTIVO</option>
                                    <option value="Inactivo">INACTIVO</option>
                                </select>
                                @error('estado')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                        </div>    
                    </div>                           
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark text-uppercase small px-5 text-white">Actualizar</button>   
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