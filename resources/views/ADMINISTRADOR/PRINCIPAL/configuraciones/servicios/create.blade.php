<form method="POST" action="{{ route('admin-servicios.store') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf    
    <div class="modal fade" id="createservicios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Nueva servicios</span>
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
                                <input type="text" name="name" id="name_id" class="form-control form-control-sm" value="{{ old('name') }}"  maxLength="100" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tipos__servicio_id" class="">Tipo<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm @error('tipo_servicio') is-invalid @enderror" required name="tipo_servicio" id="tipos__servicio_id" >
                                    <option value="{{old('tipo_servicio')}}" disabled="disabled" selected="selected" hidden="hidden">{{ old('tipo_servicio') }}</option>
                                    <option value="Servicio Publico">Servicio Publico</option>
                                    <option value="Servicio Privado">Servicio Privado</option>
                                </select>
                                @error('tipo_servicio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3" id="view_proveedor_id">
                                <label for="proveedor__id" class="">Proveedor<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2 @error('proveedor_id') is-invalid @enderror" required name="proveedor_id" id="proveedor__id" >
                                    <option value="{{ old('proveedor_id') }}" selected="selected" disabled>{{ old('proveedor_id') }}</option>
                                    @foreach($proveedores as $proveedore)
                                        <option value="{{$proveedore->id}}">{{$proveedore->name_contacto}}</option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                            <label for="descripcion_id" class="">Descripción</label>
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" placeholder="Escribe una descripción" style="height: 150px">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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