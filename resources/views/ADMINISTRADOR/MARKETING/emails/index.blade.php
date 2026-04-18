@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Campañas de Email')

@section('styles')
<style>
    :root {
        --cisnergia-dark: #1e293b;
        --cisnergia-sun: #f59e0b;
        --cisnergia-energy: #f97316;
    }
    
    .bg-solar-gradient { background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #334155 100%); color: white; }
    .btn-energy { background-color: var(--cisnergia-energy); color: white; font-weight: bold; transition: 0.3s; border: none; }
    .btn-energy:hover { background-color: var(--cisnergia-sun); color: var(--cisnergia-dark); transform: translateY(-2px); }

    /* Estilos del Editor Quill (Estilo Gmail) */
    .ql-toolbar.ql-snow { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px 8px 0 0; }
    .ql-container.ql-snow { border: 1px solid #e2e8f0; border-radius: 0 0 8px 8px; background-color: white; font-size: 1rem; }
    .ql-editor { min-height: 250px; }

    /* Galería de Logos */
    .logo-gallery { display: flex; gap: 15px; overflow-x: auto; padding-bottom: 10px; }
    .logo-item { 
        position: relative; width: 80px; height: 80px; border-radius: 10px; border: 2px solid #e2e8f0; 
        cursor: pointer; transition: 0.2s; background: white; display: flex; align-items: center; justify-content: center;
    }
    .logo-item img { max-width: 90%; max-height: 90%; object-fit: contain; }
    .logo-item:hover { border-color: #94a3b8; }
    .logo-item.selected { border-color: var(--cisnergia-energy); box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2); }
    .logo-item.selected::after {
        content: '✓'; position: absolute; top: -8px; right: -8px; background: var(--cisnergia-energy);
        color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex;
        align-items: center; justify-content: center; font-weight: bold;
    }
    
    /* Botón eliminar logo */
    .btn-delete-logo {
        position: absolute; bottom: -8px; right: -8px; background: #ef4444; color: white;
        border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; 
        justify-content: center; font-size: 10px; cursor: pointer; border: none; opacity: 0; transition: 0.2s;
    }
    .logo-item:hover .btn-delete-logo { opacity: 1; }

    .upload-logo-box {
        width: 80px; height: 80px; border-radius: 10px; border: 2px dashed #cbd5e1;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b; font-size: 0.8rem; text-align: center; background: #f8fafc;
    }
    .upload-logo-box:hover { border-color: var(--cisnergia-sun); color: var(--cisnergia-sun); }
</style>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-envelope-paper-fill text-primary me-2"></i> Compositor Corporativo</h2>
            <p class="text-muted mb-0">Envía propuestas formales con el branding de Cisnergia.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 alert-dismissible fade show"><i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-4 alert-dismissible fade show"><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-solar-gradient py-3 border-0">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pen-fill me-2"></i> Redactar Mensaje</h5>
        </div>
        <div class="card-body p-4 bg-white">
            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contenido" id="contenidoHtml">
                <input type="hidden" name="logo_path" id="selectedLogoPath">

                <div class="mb-4 bg-light p-3 rounded-4 border">
                    <label class="form-label fw-bold text-dark mb-2"><i class="bi bi-image text-muted me-1"></i> Seleccionar Membrete / Logo (Opcional)</label>
                    <div class="form-text mb-3">Haz clic en un logo para incluirlo en la cabecera del correo. Haz clic de nuevo para enviarlo sin logo.</div>
                    
                    <div class="logo-gallery align-items-center">
                        <label class="upload-logo-box mb-0" title="Subir nuevo logo">
                            <i class="bi bi-cloud-arrow-up-fill fs-4"></i>
                            <span>Subir</span>
                            <input type="file" id="logoUploader" accept="image/*" class="d-none" onchange="uploadNewLogo(this)">
                        </label>
                        <div class="vr mx-2"></div>

                        <div id="logosContainer" class="d-flex gap-3">
                            @foreach($logos ?? [] as $logo)
                                <div class="logo-item" onclick="toggleLogo('{{ $logo['path'] }}', this)">
                                    <img src="{{ asset('storage/' . $logo['path']) }}" alt="Logo">
                                    <button type="button" class="btn-delete-logo" onclick="deleteLogo('{{ $logo['path'] }}', event)"><i class="bi bi-x"></i></button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Destinatarios (Para:)</label>
                        <input type="text" class="form-control bg-light border-0" name="destinatarios" placeholder="cliente1@empresa.com, juan@gmail.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark">Asunto</label>
                        <input type="text" class="form-control bg-light border-0" name="asunto" placeholder="Propuesta de Paneles Solares - Cisnergia" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Cuerpo del Mensaje</label>
                    <div id="editor-container">
                        <p>Hola,</p><p><br></p>
                        <p>Gracias por contactar con <strong>Cisnergia Perú</strong>.</p><p><br></p>
                        <p>Atentamente,</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark"><i class="bi bi-paperclip text-muted me-1"></i> Adjuntar Archivos (PDF, Imágenes, etc.)</label>
                    <input class="form-control bg-light border-0" type="file" name="adjuntos[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <div class="form-text">Puedes seleccionar varios archivos al mismo tiempo.</div>
                </div>

                <hr class="my-4 text-muted">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-energy rounded-pill px-5 py-2" onclick="prepararEnvio(event)">
                        <i class="bi bi-send-fill me-2"></i> Enviar Correo Oficial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Configurar Axios
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    // Inicializar Quill (Editor)
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Escribe tu correo aquí (presiona Enter para saltar de línea)...',
        modules: { toolbar: [ ['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['link'], ['clean'] ] }
    });

    // Lógica para Seleccionar/Deseleccionar Logo
    function toggleLogo(path, element) {
        const isSelected = element.classList.contains('selected');
        
        // Quitar selección a todos
        document.querySelectorAll('.logo-item').forEach(el => el.classList.remove('selected'));
        
        if (!isSelected) {
            // Si no estaba seleccionado, lo seleccionamos
            element.classList.add('selected');
            document.getElementById('selectedLogoPath').value = path;
        } else {
            // Si ya estaba seleccionado, lo deseleccionamos (enviar sin logo)
            document.getElementById('selectedLogoPath').value = '';
        }
    }

    // Subir Nuevo Logo (AJAX)
    async function uploadNewLogo(input) {
        if (!input.files || input.files.length === 0) return;
        
        let formData = new FormData();
        formData.append('logo', input.files[0]);

        try {
            const res = await axios.post("{{ route('admin.marketing.emails.logo.upload') }}", formData);
            if(res.data.success) {
                location.reload(); // Recargamos para ver el nuevo logo en la galería
            }
        } catch (error) {
            alert('Error al subir el logo. Asegúrate de que sea una imagen (PNG/JPG).');
        }
    }

    // Eliminar Logo
    async function deleteLogo(path, event) {
        event.stopPropagation(); // Evita que se seleccione al hacer clic en borrar
        if(confirm('¿Eliminar este logo de la galería?')) {
            try {
                await axios.delete("{{ route('admin.marketing.emails.logo.delete') }}", { data: { path: path } });
                location.reload();
            } catch (error) {
                alert('Error al eliminar el logo.');
            }
        }
    }

    // Preparar envío de formulario
    function prepararEnvio(event) {
        var form = document.getElementById('emailForm');
        if (!form.checkValidity()) return; // Deja que el navegador pida los campos requeridos
        
        var htmlContent = document.querySelector('.ql-editor').innerHTML;
        if(htmlContent === '<p><br></p>' || htmlContent.trim() === '') {
            event.preventDefault();
            alert('El cuerpo del correo no puede estar vacío.');
            return;
        }
        
        document.getElementById('contenidoHtml').value = htmlContent;
        event.currentTarget.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Enviando...';
        event.currentTarget.classList.add('disabled');
    }
</script>
@endsection