<form method="POST" action="{{ route('admin-categorias.store') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf    
    <div class="modal fade" id="createcategorias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Nueva categoria</span>
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
                                <label for="tipos_id" class=" d-block">Tipos<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2 @error('tipo_id') is-invalid @enderror" name="tipo_id" id="tipos_id" required>
                                    <option value="{{ old('tipo_id') }}" selected="selected" hidden="hidden">{{ old('tipo_id') }}</option>
                                    @foreach($tipos as $tipo) 
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror    
                            </div>
                            <p class="fw-bold text-uppercase small text-secondary mb-1" style="font-size: 14px">Sub - Categorias</p>
                            <div class="row g-2">
                                <div class="col-6 col-md-7 col-lg-8 col-xl-8">
                                    <label for="sub_categoria_id">Sub Categoria</label>
                                    <input type="text" id="sub_categoria_id" class="form-control form-control-sm">
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4 d-flex align-items-end">
                                    <button type="button" id="btnasignar_subc" class="btn btn-grey btn-sm w-100 py-1 px-2">
                                        <i class="bi bi-plus-circle"></i> Agregar
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive mt-3" style="min-height: 150px">
                                <table class="table table-sm table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th class="bg-primary text-white align-middle fw-bold text-uppercase small text-center" style="width: 5%">N°</th>
                                            <th class="bg-primary text-white align-middle fw-bold text-uppercase small text-center" style="width: 30%">Descripción</th>
                                            <th class="bg-primary text-white align-middle fw-bold text-uppercase small text-center" style="width: 5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="dt_sbcate" class="text-center">
                                    </tbody>
                                </table>
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