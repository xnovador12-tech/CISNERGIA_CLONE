@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Compositor Cisnergia')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root {
        --c-dark: #1e293b;
        --c-sun: #f59e0b;
        --c-energy: #f97316;
        --surface-bg: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --border-color: #e2e8f0;
    }

    body { font-family: 'Inter', sans-serif; background-color: #f0f3ff; }
    h1, h2, h3, h4, h5, h6 { font-family: 'Manrope', sans-serif; }

    /* Contenedor Principal Glassmorphic */
    .composer-panel {
        background-color: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 1rem;
        box-shadow: 0 24px 48px rgba(17, 28, 45, 0.06);
        border: 1px solid rgba(255,255,255,0.5);
        overflow: hidden;
    }

    /* Cabecera del formulario (To, Subject) */
    .composer-header { background-color: rgba(241, 245, 249, 0.5); padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color); }
    
    .input-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .input-row label { font-weight: 600; color: #64748b; width: 70px; flex-shrink: 0; margin: 0; }
    
    .custom-input {
        flex: 1; background: #e2e8f0; border: none; border-radius: 0.5rem; padding: 0.6rem 1rem;
        color: var(--c-dark); font-size: 0.95rem; transition: all 0.2s;
    }
    .custom-input:focus { outline: none; box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.3); background: white; }
    
    .subject-input { font-family: 'Manrope', sans-serif; font-size: 1.1rem; font-weight: 600; }

    /* Galería de Logos */
    .logo-section { padding: 1rem 2rem; border-bottom: 1px solid var(--border-color); background: white; }
    .logo-gallery { display: flex; gap: 12px; overflow-x: auto; padding: 10px 0; align-items: center; }
    
    .upload-logo-box {
        width: 65px; height: 65px; border-radius: 10px; border: 2px dashed #cbd5e1;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        cursor: pointer; color: #64748b; font-size: 0.75rem; background: #f8fafc; flex-shrink: 0; transition: 0.2s;
    }
    .upload-logo-box:hover { border-color: var(--c-energy); color: var(--c-energy); }

    .logo-item { 
        position: relative; width: 65px; height: 65px; border-radius: 10px; border: 2px solid #e2e8f0; 
        cursor: pointer; transition: 0.2s; background: white; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .logo-item img { max-width: 85%; max-height: 85%; object-fit: contain; }
    .logo-item:hover { border-color: #94a3b8; transform: translateY(-2px); }
    
    /* Estado Seleccionado */
    .logo-item.selected { border-color: var(--c-energy); box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2); }
    .logo-item.selected::after {
        content: '✓'; position: absolute; top: -6px; right: -6px; background: var(--c-energy);
        color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; display: flex;
        align-items: center; justify-content: center; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    /* Botón eliminar logo */
    .btn-delete-logo {
        position: absolute; bottom: -6px; right: -6px; background: #ef4444; color: white;
        border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; 
        justify-content: center; font-size: 10px; cursor: pointer; border: none; opacity: 0; transition: 0.2s;
    }
    .logo-item:hover .btn-delete-logo { opacity: 1; }

    /* Quill Editor */
    .ql-toolbar.ql-snow { border: none; border-bottom: 1px solid var(--border-color); background: #f8fafc; padding: 10px 2rem; }
    .ql-container.ql-snow { border: none; font-size: 1rem; font-family: 'Inter', sans-serif; }
    .ql-editor { min-height: 350px; padding: 2rem; color: #334155; }

    /* Adjuntos y Footer */
    .attachments-area { padding: 1.5rem 2rem; background: rgba(248, 250, 252, 0.7); border-top: 1px solid var(--border-color); }
    .composer-footer { padding: 1.5rem 2rem; background: #f1f5f9; display: flex; justify-content: space-between; align-items: center; }

    /* Botón Gradient Energy */
    .btn-gradient {
        background: linear-gradient(135deg, var(--c-dark) 0%, var(--c-energy) 100%);
        color: white; border: none; font-weight: 700; padding: 0.6rem 2rem; border-radius: 50px;
        transition: 0.3s; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3); font-family: 'Manrope', sans-serif;
    }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249, 115, 22, 0.4); color: white; }
</style>
@endsection

@section('content')
<div class="container py-4 max-w-5xl">
    
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <div>
            <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">Compositor Cisnergia</h2>
            <p class="text-muted mb-0 small">Envíos oficiales, cotizaciones y marketing directo.</p>
        </div>
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-shield-check me-1"></i> Envío Seguro</span>
    </div>

    <div id="alert-container"></div>

    <div class="composer-panel">
        <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="contenido" id="contenidoHtml">
            <input type="hidden" name="logo_path" id="selectedLogoPath">

            <div class="composer-header">
                <div class="input-row">
                    <label>Para:</label>
                    <input type="text" class="custom-input" name="destinatarios" placeholder="cliente1@empresa.com, juan.perez@gmail.com" required>
                </div>
                <div class="input-row mb-0">
                    <label>Asunto:</label>
                    <input type="text" class="custom-input subject-input" name="asunto" placeholder="Propuesta Oficial - Cisnergia" required>
                </div>
            </div>

            <div class="logo-section">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-bold text-dark small"><i class="bi bi-image me-1 text-muted"></i> Membrete / Logo</span>
                    <span class="text-muted" style="font-size: 0.75rem;">Haz clic para incluirlo en el correo.</span>
                </div>
                
                <div class="logo-gallery">
                    <label class="upload-logo-box mb-0" title="Subir nuevo logo">
                        <i class="bi bi-cloud-arrow-up-fill fs-5 mb-1"></i>
                        <input type="file" id="logoUploader" accept="image/png, image/jpeg, image/jpg" class="d-none" onchange="uploadNewLogo(this)">
                    </label>
                    
                    <div style="width: 2px; height: 40px; background: #e2e8f0; margin: 0 5px;"></div>

                    <div id="logosContainer" class="d-flex gap-2">
                        @foreach($logos ?? [] as $logo)
                            <div class="logo-item" id="logo-{{ $loop->index }}" onclick="toggleLogo('{{ $logo['path'] }}', 'logo-{{ $loop->index }}')">
                                <img src="{{ asset('storage/' . $logo['path']) }}" alt="Logo">
                                <button type="button" class="btn-delete-logo" onclick="deleteLogo('{{ $logo['path'] }}', event)"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="editor-container">
                <p>Hola,</p><p><br></p>
                <p>Espero que este correo te encuentre muy bien.</p>
                <p>Adjunto encontrarás la propuesta técnica y comercial de los servicios de <strong>Energía Solar</strong> solicitados.</p><p><br></p>
                <p>Quedo a tu entera disposición para cualquier duda.</p><p><br></p>
                <p>Saludos cordiales,</p>
                <p><strong>Equipo Comercial | Cisnergia Perú</strong></p>
            </div>

            <div class="attachments-area">
                <label class="fw-bold text-dark small d-block mb-2"><i class="bi bi-paperclip me-1 text-muted"></i> Archivos Adjuntos (Opcional)</label>
                <input class="form-control bg-white border-0 shadow-sm" type="file" name="adjuntos[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls" style="font-size: 0.85rem;">
                <div class="form-text mt-2" style="font-size: 0.75rem;">Puedes seleccionar varios PDFs, documentos o imágenes al mismo tiempo. Max 10MB por archivo.</div>
            </div>

            <div class="composer-footer">
                <div class="text-muted small">
                    <i class="bi bi-check2-all text-success"></i> Sistema listo
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" onclick="document.getElementById('emailForm').reset()">Descartar</button>
                    <button type="submit" class="btn-gradient d-flex align-items-center" onclick="prepararEnvio(event)">
                        Enviar Mensaje <i class="bi bi-send-fill ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Axios Config
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    // 1. Inicializar Quill Editor
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],        
        [{ 'color': [] }, { 'background': [] }],          
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'align': [] }],
        ['link', 'image'],
        ['clean']                                         
    ];

    var quill = new Quill('#editor-container', {
        modules: { toolbar: toolbarOptions },
        theme: 'snow',
        placeholder: 'Escribe tu propuesta aquí...'
    });

    // 2. Lógica de Selección de Logos (Toggle)
    function toggleLogo(path, elementId) {
        const element = document.getElementById(elementId);
        const isSelected = element.classList.contains('selected');
        
        // Deseleccionamos todos primero
        document.querySelectorAll('.logo-item').forEach(el => el.classList.remove('selected'));
        
        if (!isSelected) {
            // Seleccionar este
            element.classList.add('selected');
            document.getElementById('selectedLogoPath').value = path;
        } else {
            // Deseleccionar (Enviar sin logo)
            document.getElementById('selectedLogoPath').value = '';
        }
    }

    // 3. Subir nuevo logo al servidor
    async function uploadNewLogo(input) {
        if (!input.files || input.files.length === 0) return;
        
        let formData = new FormData();
        formData.append('logo', input.files[0]);

        // Feedback visual
        Swal.fire({ title: 'Subiendo logo...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

        try {
            const res = await axios.post("{{ route('admin.marketing.emails.logo.upload') }}", formData);
            if(res.data.success) {
                location.reload(); // Recarga para ver la galería actualizada
            }
        } catch (error) {
            Swal.fire('Error', 'No se pudo subir. Verifica que sea JPG/PNG y pese menos de 2MB.', 'error');
        }
    }

    // 4. Eliminar Logo
    async function deleteLogo(path, event) {
        event.stopPropagation(); // IMPORTANTE: Evita que se seleccione al hacer clic en borrar
        
        const result = await Swal.fire({
            title: '¿Eliminar logo?',
            text: "Desaparecerá de tu galería",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Sí, eliminar'
        });

        if (result.isConfirmed) {
            Swal.fire({ title: 'Eliminando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });
            try {
                await axios.delete("{{ route('admin.marketing.emails.logo.delete') }}", { data: { path: path } });
                location.reload();
            } catch (error) {
                Swal.fire('Error', 'No se pudo eliminar el logo.', 'error');
            }
        }
    }

    // 5. Preparar y Validar antes de Enviar
    function prepararEnvio(event) {
        var form = document.getElementById('emailForm');
        
        // Validación nativa HTML5
        if (!form.checkValidity()) {
            form.reportValidity();
            event.preventDefault();
            return;
        }

        // Obtener HTML de Quill
        var htmlContent = document.querySelector('.ql-editor').innerHTML;
        
        if(htmlContent === '<p><br></p>' || htmlContent.trim() === '') {
            event.preventDefault();
            Swal.fire('Atención', 'No puedes enviar un correo vacío.', 'warning');
            return;
        }
        
        // Inyectar HTML al input oculto
        document.getElementById('contenidoHtml').value = htmlContent;
        
        // Efecto visual en el botón
        var btn = event.currentTarget;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Enviando...';
        btn.classList.add('disabled');
        btn.style.pointerEvents = 'none';
    }
</script>
@endsection