@extends('TEMPLATES.administrador')

@section('title', 'INFORMACION DE LA EMPRESA')

@section('css')

@endsection

@section('content')
<!-- Encabezado -->
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div class="" data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">INFORMACIÓN DE LA EMPRESA</h1>
            <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-informacion') }}">Información</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- fin encabezado -->

{{-- Contenido --}}
<div class="container-fluid">
    <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
        <div class="card-header bg-transparent">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-9">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-building text-primary me-2"></i>
                        Datos generales de la empresa
                    </h5>
                    <small class="text-muted">Esta información se muestra automáticamente en el ecommerce (footer y página de contacto).</small>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="card border-0 rounded-0 border-start border-3 border-info bg-light mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px;">
                <div class="card-body py-2">
                    <i class="bi bi-info-circle text-info me-2"></i>Importante:
                    <ul class="list-unstyled mb-0 pb-0">
                        <li class="mb-0 pb-0">
                            <small class="text-muted py-0 my-0 text-start">Se consideran campos obligatorios los campos que tengan este símbolo: <span class="text-danger">*</span></small>
                        </li>
                        <li class="mb-0 pb-0">
                            <small class="text-muted py-0 my-0 text-start">Cualquier cambio se reflejará inmediatamente en el ecommerce.</small>
                        </li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('admin-informacion.update') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                @csrf
                @method('put')

                <div class="row g-4">

                    {{-- ───────── COLUMNA IZQUIERDA: LOGO ───────── --}}
                    <div class="col-12 col-lg-4">
                        <div class="card border-1 shadow-sm h-100">
                            <div class="card-header bg-transparent">
                                <span class="fw-bold text-uppercase small">Logo de la empresa</span>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <img src="{{ $info->logo_url }}" alt="Logo {{ $info->razon_social }}" id="preview_logo" class="img-fluid border rounded p-2 bg-light" style="max-height: 200px; max-width: 100%;">
                                </div>
                                <div class="mb-2">
                                    <label for="logo_id" class="form-label small">Cambiar logo</label>
                                    <input type="file" name="logo" id="logo_id" class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.webp,.svg" onchange="previewLogo(event)">
                                    @error('logo')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <small class="text-muted d-block">Formatos: JPG, PNG, WEBP, SVG. Máx. 2 MB.</small>
                            </div>
                        </div>
                    </div>

                    {{-- ───────── COLUMNA DERECHA: DATOS ───────── --}}
                    <div class="col-12 col-lg-8">

                        {{-- ─── Datos generales ─── --}}
                        <div class="card border-1 shadow-sm mb-4">
                            <div class="card-header bg-transparent">
                                <span class="fw-bold text-uppercase small">
                                    <i class="bi bi-card-text me-2"></i>Datos generales
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-8 mb-3">
                                        <label for="razon_social_id">Razón social <span class="text-danger">*</span></label>
                                        <input type="text" name="razon_social" id="razon_social_id" class="form-control" value="{{ old('razon_social', $info->razon_social) }}" maxlength="255" required>
                                        @error('razon_social')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="ruc_id">RUC <span class="text-danger">*</span></label>
                                        <input type="text" name="ruc" id="ruc_id" class="form-control" value="{{ old('ruc', $info->ruc) }}" maxlength="11" minlength="11" pattern="[0-9]{11}" required>
                                        @error('ruc')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="nombre_comercial_id">Nombre comercial</label>
                                        <input type="text" name="nombre_comercial" id="nombre_comercial_id" class="form-control" value="{{ old('nombre_comercial', $info->nombre_comercial) }}" maxlength="255">
                                        @error('nombre_comercial')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ─── Datos de contacto ─── --}}
                        <div class="card border-1 shadow-sm mb-4">
                            <div class="card-header bg-transparent">
                                <span class="fw-bold text-uppercase small">
                                    <i class="bi bi-telephone me-2"></i>Datos de contacto
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="direccion_id">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" name="direccion" id="direccion_id" class="form-control" value="{{ old('direccion', $info->direccion) }}" maxlength="255" required>
                                        @error('direccion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="telefono_id">Teléfono fijo</label>
                                        <input type="text" name="telefono" id="telefono_id" class="form-control" value="{{ old('telefono', $info->telefono) }}" maxlength="50">
                                        @error('telefono')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="celular_id">Celular</label>
                                        <input type="text" name="celular" id="celular_id" class="form-control" value="{{ old('celular', $info->celular) }}" maxlength="50">
                                        @error('celular')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="whatsapp_id">WhatsApp</label>
                                        <input type="text" name="whatsapp" id="whatsapp_id" class="form-control" value="{{ old('whatsapp', $info->whatsapp) }}" maxlength="50">
                                        @error('whatsapp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-7 mb-3">
                                        <label for="email_id">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email_id" class="form-control" value="{{ old('email', $info->email) }}" maxlength="255" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-5 mb-3">
                                        <label for="horario_atencion_id">Horario de atención</label>
                                        <input type="text" name="horario_atencion" id="horario_atencion_id" class="form-control" value="{{ old('horario_atencion', $info->horario_atencion) }}" maxlength="255" placeholder="Ej. Lun-Vie: 9AM-6PM">
                                        @error('horario_atencion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ─── Redes sociales ─── --}}
                        <div class="card border-1 shadow-sm mb-4">
                            <div class="card-header bg-transparent">
                                <span class="fw-bold text-uppercase small">
                                    <i class="bi bi-share me-2"></i>Redes sociales
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Puedes pegar la URL completa o solo <code>www.ejemplo.com</code> — el sistema completará el protocolo automáticamente.
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="facebook_id"><i class="bi bi-facebook text-primary me-1"></i> Facebook</label>
                                        <input type="text" name="facebook" id="facebook_id" class="form-control" value="{{ old('facebook', $info->facebook) }}" placeholder="www.facebook.com/...">
                                        @error('facebook')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="instagram_id"><i class="bi bi-instagram text-danger me-1"></i> Instagram</label>
                                        <input type="text" name="instagram" id="instagram_id" class="form-control" value="{{ old('instagram', $info->instagram) }}" placeholder="www.instagram.com/...">
                                        @error('instagram')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="linkedin_id"><i class="bi bi-linkedin text-info me-1"></i> LinkedIn</label>
                                        <input type="text" name="linkedin" id="linkedin_id" class="form-control" value="{{ old('linkedin', $info->linkedin) }}" placeholder="www.linkedin.com/...">
                                        @error('linkedin')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="youtube_id"><i class="bi bi-youtube text-danger me-1"></i> YouTube</label>
                                        <input type="text" name="youtube" id="youtube_id" class="form-control" value="{{ old('youtube', $info->youtube) }}" placeholder="www.youtube.com/@...">
                                        @error('youtube')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ───────── BOTONES ───────── --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ url('admin-configuraciones') }}" class="btn btn-secondary text-uppercase">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary text-uppercase">
                        <i class="bi bi-check-circle me-1"></i> Guardar cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Vista previa del logo seleccionado
    function previewLogo(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_logo').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Aviso al guardar correctamente
    @if(session('update_registration') == 'ok')
        Swal.fire({
            icon: 'success',
            title: '¡Información actualizada!',
            text: 'Los datos de la empresa se guardaron correctamente.',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
