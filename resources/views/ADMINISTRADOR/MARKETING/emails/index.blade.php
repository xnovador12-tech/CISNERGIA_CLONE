@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Compositor Cisnergia')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

<style>
    :root {
        --bg-surface: #f9f9ff;
        --surface-high: #f1f5f9;
        --border-color: #e2e8f0;
        --text-main: #111c2d;
        --text-muted: #64748b;
        --brand-orange: #f97316;
        --brand-orange-dark: #9d4300;
    }

    .font-headline { font-family: 'Manrope', sans-serif; }
    .font-body { font-family: 'Inter', sans-serif; }

    /* Contenedor y Tarjeta Principal */
    .composer-wrapper { max-width: 1000px; margin: 0 auto; }
    .composer-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        box-shadow: 0 24px 48px rgba(17, 28, 45, 0.06);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Sección Meta (Para, Asunto) */
    .composer-meta { background: rgba(241, 245, 249, 0.5); padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color); }
    .meta-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .meta-row:last-child { margin-bottom: 0; }
    .meta-row label { width: 60px; color: var(--text-muted); font-weight: 500; margin: 0; flex-shrink: 0; }
    
    .input-clean {
        flex: 1; background: rgba(226, 232, 240, 0.5); border: none; border-radius: 6px; 
        padding: 0.6rem 1rem; color: var(--text-main); font-size: 0.95rem; transition: 0.2s; outline: none;
    }
    .input-clean:focus { background: white; box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.3); }
    
    .subject-input { 
        background: transparent; font-family: 'Manrope', sans-serif; font-size: 1.25rem; 
        font-weight: 600; padding: 0.5rem; border-radius: 6px;
    }
    .subject-input:focus { background: white; }

    /* Galería de Logos (Active Letterhead Style) */
    .branding-row { padding: 0.75rem 2rem; background: white; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem; overflow-x: auto;}
    .branding-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; white-space: nowrap;}
    
    .logo-item {
        width: 100px; height: 40px; border: 1px solid var(--border-color); border-radius: 6px;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: 0.2s; position: relative; background: var(--bg-surface); flex-shrink: 0;
    }
    .logo-item img { max-width: 80%; max-height: 80%; object-fit: contain; }
    .logo-item:hover { border-color: #94a3b8; }
    .logo-item.selected { border-color: var(--brand-orange); background: white; box-shadow: 0 2px 8px rgba(249,115,22,0.15); }
    .logo-item.selected::after {
        content: '✓'; position: absolute; top: -6px; right: -6px; background: var(--brand-orange);
        color: white; border-radius: 50%; width: 16px; height: 16px; font-size: 10px; display: flex;
        align-items: center; justify-content: center; font-weight: bold;
    }
    .btn-delete-logo {
        position: absolute; bottom: -6px; right: -6px; background: #ef4444; color: white; border: none;
        border-radius: 50%; width: 16px; height: 16px; font-size: 10px; display: flex; align-items: center; 
        justify-content: center; opacity: 0; transition: 0.2s; cursor: pointer;
    }
    .logo-item:hover .btn-delete-logo { opacity: 1; }

    .btn-add-logo {
        width: 40px; height: 40px; border: 1px dashed #cbd5e1; border-radius: 6px; display: flex;
        align-items: center; justify-content: center; color: var(--text-muted); cursor: pointer; background: transparent;
    }
    .btn-add-logo:hover { color: var(--brand-orange); border-color: var(--brand-orange); }

    /* Editor Quill Integrado */
    .ql-toolbar.ql-snow { border: none; border-bottom: 1px solid var(--border-color); background: var(--bg-surface); padding: 12px 2rem; display: flex; gap: 5px; align-items: center;}
    .ql-container.ql-snow { border: none; font-size: 1rem; color: var(--text-main); }
    .ql-editor { min-height: 350px; padding: 2rem; }

    /* Adjuntos */
    .attachments-area { padding: 1rem 2rem; background: rgba(248, 250, 252, 0.5); border-top: 1px solid rgba(226, 232, 240, 0.5); }
    .custom-file-input::-webkit-file-upload-button {
        visibility: hidden; display: none;
    }
    .custom-file-input::before {
        content: 'Adjuntar archivos'; display: inline-block; background: white; border: 1px solid var(--border-color);
        border-radius: 6px; padding: 6px 12px; outline: none; white-space: nowrap; cursor: pointer;
        font-weight: 500; font-size: 0.85rem; color: var(--text-main); margin-right: 10px;
    }
    .custom-file-input:hover::before { border-color: #94a3b8; }

    /* Footer */
    .composer-footer { padding: 1.25rem 2rem; background: var(--bg-surface); border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; border-radius: 0 0 1rem 1rem;}
    
    .btn-gradient {
        background: linear-gradient(135deg, var(--brand-orange-dark) 0%, var(--brand-orange) 100%);
        color: white; border: none; font-weight: 700; padding: 0.6rem 2rem; border-radius: 50px;
        transition: 0.3s; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25); display: flex; align-items: center; gap: 8px;
    }
    .btn-gradient:hover { opacity: 0.9; transform: translateY(-1px); color: white;}
</style>
@endsection

@section('content')
<div class="container-fluid py-2 font-body">
    
    <div class="composer-wrapper">
        <div class="d-flex align-items-center gap-3 mb-4 px-2">
            <h2 class="font-headline fw-bold m-0" style="font-size: 1.4rem; color: var(--text-main);">Compose Proposal</h2>
            <span class="badge bg-light text-primary border px-2 py-1 rounded-pill" style="font-size: 0.65rem; letter-spacing: 1px;">DRAFT</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3"><i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3"><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}</div>
        @endif

        <div class="composer-card">
            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contenido" id="contenidoHtml">
                <input type="hidden" name="logo_path" id="selectedLogoPath">

                <div class="composer-meta">
                    <div class="meta-row">
                        <label>To:</label>
                        <input type="text" class="input-clean" name="destinatarios" placeholder="Añadir destinatario (ej. michael.chen@novaenergy.com)" required>
                    </div>
                    <div class="meta-row">
                        <label>Subject:</label>
                        <input type="text" class="input-clean subject-input" name="asunto" placeholder="Escribe el asunto aquí..." required>
                    </div>
                </div>

                <div class="branding-row">
                    <span class="branding-label">Active Letterhead</span>
                    
                    <div id="logosContainer" class="d-flex gap-2 align-items-center">
                        @foreach($logos ?? [] as $logo)
                            <div class="logo-item" id="logo-{{ $loop->index }}" onclick="toggleLogo('{{ $logo['path'] }}', 'logo-{{ $loop->index }}')">
                                <img src="{{ asset('storage/' . $logo['path']) }}" alt="Logo">
                                <button type="button" class="btn-delete-logo" onclick="deleteLogo('{{ $logo['path'] }}', event)"><i class="bi bi-x"></i></button>
                            </div>
                        @endforeach
                    </div>

                    <div class="vr mx-1" style="opacity: 0.15"></div>
                    
                    <label class="btn-add-logo mb-0" title="Subir Membrete/Logo">
                        <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
                        <input type="file" id="logoUploader" accept="image/png, image/jpeg" class="d-none" onchange="uploadNewLogo(this)">
                    </label>
                </div>

                <div id="editor-container">
                    <p>Hola,</p><p><br></p>
                    <p>Espero que este correo te encuentre muy bien.</p>
                    <p>Adjunto encontrarás la propuesta técnica y comercial solicitada. El rendimiento proyectado se alinea perfectamente con los objetivos para el próximo año fiscal.</p>
                    <p>Avísame cuando tengas un momento para revisarlo juntos.</p><p><br></p>
                    <p>Saludos cordiales,</p>
                    <p><strong style="color: var(--brand-orange-dark);">{{ Auth::user()?->persona?->name . ' ' . Auth::user()?->persona?->surnames }}</strong></p>
                    <p style="color: var(--text-muted); font-size: 14px;">Administrador | Cisnergia Perú</p>
                </div>

                <div class="attachments-area">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="material-symbols-outlined" style="color: var(--text-muted); font-size: 18px;">attach_file</span>
                        <span class="fw-semibold" style="color: var(--text-muted); font-size: 0.85rem;">Attachments</span>
                    </div>
                    <input class="form-control custom-file-input bg-transparent border-0 p-0" type="file" name="adjuntos[]" multiple accept=".pdf,.doc,.docx,.jpg,.png,.xlsx">
                </div>

                <div class="composer-footer">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm text-muted rounded-circle"><span class="material-symbols-outlined" style="font-size: 20px;">text_format</span></button>
                        <button type="button" class="btn btn-sm text-muted rounded-circle"><span class="material-symbols-outlined" style="font-size: 20px;">image</span></button>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-light fw-medium text-muted rounded-pill px-4" style="background: #e2e8f0; border:none;" onclick="document.getElementById('emailForm').reset()">Discard</button>
                        <button type="submit" class="btn-gradient" onclick="prepararEnvio(event)">
                            Send <span class="material-symbols-outlined" style="font-size: 18px; font-variation-settings: 'FILL' 1;">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    // Inicializar Quill Editor (Estilo Minimalista)
    var quill = new Quill('#editor-container', {
        modules: { 
            toolbar: [ 
                [{ 'font': [] }, { 'size': [] }],
                ['bold', 'italic', 'underline'],        
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']                                         
            ] 
        },
        theme: 'snow',
        placeholder: 'Escribe aquí...'
    });

    // Lógica Logos
    function toggleLogo(path, elementId) {
        const element = document.getElementById(elementId);
        const isSelected = element.classList.contains('selected');
        
        document.querySelectorAll('.logo-item').forEach(el => el.classList.remove('selected'));
        
        if (!isSelected) {
            element.classList.add('selected');
            document.getElementById('selectedLogoPath').value = path;
        } else {
            document.getElementById('selectedLogoPath').value = '';
        }
    }

    async function uploadNewLogo(input) {
        if (!input.files || input.files.length === 0) return;
        
        let formData = new FormData();
        formData.append('logo', input.files[0]);

        Swal.fire({ title: 'Subiendo...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });

        try {
            const res = await axios.post("{{ route('admin.marketing.emails.logo.upload') }}", formData);
            if(res.data.success) location.reload();
        } catch (error) {
            Swal.fire('Error', 'No se pudo subir la imagen.', 'error');
        }
    }

    async function deleteLogo(path, event) {
        event.stopPropagation();
        
        const result = await Swal.fire({
            title: '¿Eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Eliminar'
        });

        if (result.isConfirmed) {
            Swal.fire({ title: 'Borrando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() } });
            try {
                await axios.delete("{{ route('admin.marketing.emails.logo.delete') }}", { data: { path: path } });
                location.reload();
            } catch (error) {
                Swal.fire('Error', 'No se pudo eliminar.', 'error');
            }
        }
    }

    // Preparar envío
    function prepararEnvio(event) {
        var form = document.getElementById('emailForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            event.preventDefault();
            return;
        }

        var htmlContent = document.querySelector('.ql-editor').innerHTML;
        if(htmlContent === '<p><br></p>' || htmlContent.trim() === '') {
            event.preventDefault();
            Swal.fire('Atención', 'El correo está vacío.', 'warning');
            return;
        }
        
        document.getElementById('contenidoHtml').value = htmlContent;
        var btn = event.currentTarget;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Sending...';
        btn.classList.add('disabled');
        btn.style.pointerEvents = 'none';
    }
</script>
@endsection