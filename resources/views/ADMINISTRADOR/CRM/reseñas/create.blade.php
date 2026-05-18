<form method="POST" action="{{ route('admin-crm-reseñas.store') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
    @csrf    
    <div class="modal fade" id="createreseñas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white py-2">
                    <span class="modal-title text-uppercase small" id="staticBackdropLabel">Nueva Reseña</span>
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
                            <div class="mb-3 text-center">
                                <label class="form-label mb-1">Valoracion<span class="text-danger">*</span></label>
                                <div id="rating-stars" class="d-flex justify-content-center align-items-center gap-1" role="radiogroup" aria-label="Seleccionar valoracion">
                                    <button type="button" class="btn btn-link p-0 rating-star" data-value="1" aria-label="1 estrella">
                                        <i class="bi bi-star fs-4 text-warning"></i>
                                    </button>
                                    <button type="button" class="btn btn-link p-0 rating-star" data-value="2" aria-label="2 estrellas">
                                        <i class="bi bi-star fs-4 text-warning"></i>
                                    </button>
                                    <button type="button" class="btn btn-link p-0 rating-star" data-value="3" aria-label="3 estrellas">
                                        <i class="bi bi-star fs-4 text-warning"></i>
                                    </button>
                                    <button type="button" class="btn btn-link p-0 rating-star" data-value="4" aria-label="4 estrellas">
                                        <i class="bi bi-star fs-4 text-warning"></i>
                                    </button>
                                    <button type="button" class="btn btn-link p-0 rating-star" data-value="5" aria-label="5 estrellas">
                                        <i class="bi bi-star fs-4 text-warning"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="valoracion" id="valoracion_id" value="{{ old('valoracion') }}" required>
                                @error('valoracion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback d-block" id="valoracion_feedback" style="display:none !important;">
                                    Selecciona una valoracion entre 1 y 5 estrellas.
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="mb-3">
                                <label for="name_id">Cliente<span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm select2 @error('cliente_id') is-invalid @enderror" name="cliente_id" id="cliente_id" required>
                                    <option value="{{ old('cliente_id') }}" selected="selected" disabled>{{ old('cliente_id', 'Seleccione un cliente') }}</option>
                                    @foreach($clientes as $cliente) 
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre.' '.$cliente->apellidos }}</option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">
                                    El campo no puede estar vacío
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <textarea name="comentarios" id="comentario_id" class="form-control form-control-sm" rows="3" maxLength="500" placeholder="Comentario">{{ old('comentarios') }}</textarea>
                            @error('comentarios')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

    document.addEventListener('DOMContentLoaded', function () {
        var stars = document.querySelectorAll('.rating-star');
        var input = document.getElementById('valoracion_id');
        var feedback = document.getElementById('valoracion_feedback');

        function paintStars(value) {
            stars.forEach(function (btn) {
                var current = parseInt(btn.getAttribute('data-value'));
                var icon = btn.querySelector('i');
                if (!icon) return;
                if (current <= value) {
                    icon.classList.remove('bi-star');
                    icon.classList.add('bi-star-fill');
                } else {
                    icon.classList.remove('bi-star-fill');
                    icon.classList.add('bi-star');
                }
            });
        }

        var initialValue = parseInt(input.value || '0');
        if (initialValue >= 1 && initialValue <= 5) {
            paintStars(initialValue);
        }

        stars.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var selected = parseInt(this.getAttribute('data-value'));
                input.value = selected;
                paintStars(selected);
                if (feedback) {
                    feedback.style.display = 'none';
                }
            });
        });

        var form = document.querySelector('#createreseñas form') || document.querySelector('form[action*="admin-crm-reseñas"]');
        if (!form) return;

        form.addEventListener('submit', function (event) {
            var selected = parseInt(input.value || '0');
            if (selected < 1 || selected > 5) {
                event.preventDefault();
                if (feedback) {
                    feedback.style.display = 'block';
                }
            }
        });
    });
    
    
</script>