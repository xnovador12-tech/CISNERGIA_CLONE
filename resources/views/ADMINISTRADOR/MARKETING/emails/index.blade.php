@extends('TEMPLATES.administrador')

@section('title', 'Email Marketing | Cisnergia')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@300..600,0..1&display=swap" rel="stylesheet"/>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root {
        --cs-dark:     #212529;
        --cs-dark-2:   #343a40;
        --cs-mid:      #495057;
        --cs-muted:    #6c757d;
        --cs-border:   #dee2e6;
        --cs-light:    #f8f9fa;
        --cs-white:    #ffffff;
        --cs-accent:   #0d6efd;
        --cs-accent-h: #0a58ca;
        --cs-accent-lt:#e7f0ff;
        --cs-success:  #198754;
        --cs-danger:   #dc3545;
        --cs-radius:   10px;
    }

    .cs-composer-wrap {
        background: #eef0f3;
        min-height: calc(100vh - 80px);
        padding: 32px 16px;
    }

    .cs-panel {
        background: var(--cs-white);
        border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius);
        box-shadow: 0 4px 24px rgba(33,37,41,.07);
        overflow: hidden;
    }

    .cs-panel-header {
        background: var(--cs-dark);
        color: var(--cs-white);
        padding: 20px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cs-panel-header h2 {
        font-family: 'Crimson Pro', Georgia, serif;
        font-size: 22px;
        font-weight: 600;
        margin: 0;
        letter-spacing: .3px;
    }
    .cs-badge-secure {
        font-family: 'DM Sans', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        color: #ced4da;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .cs-section {
        padding: 24px 32px;
        border-bottom: 1px solid var(--cs-border);
    }

    .cs-field-row {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .cs-label {
        width: 64px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--cs-muted);
        flex-shrink: 0;
    }
    .cs-input {
        flex: 1;
        border: 1px solid var(--cs-border);
        border-radius: 7px;
        padding: 9px 14px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--cs-dark);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        background: var(--cs-white);
    }
    .cs-input:focus {
        border-color: var(--cs-accent);
        box-shadow: 0 0 0 3px rgba(13,110,253,.12);
    }
    .cs-input-subject {
        font-size: 16px;
        font-weight: 600;
        color: var(--cs-dark-2);
    }

    .cs-section-label {
        font-family: 'DM Sans', sans-serif;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--cs-muted);
        margin-bottom: 12px;
    }
    .logos-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .logo-upload-btn {
        width: 52px;
        height: 52px;
        border: 2px dashed #adb5bd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        flex-shrink: 0;
        background: var(--cs-light);
    }
    .logo-upload-btn:hover {
        border-color: var(--cs-accent);
        background: var(--cs-accent-lt);
    }
    .logo-upload-btn .material-symbols-outlined { color: var(--cs-muted); font-size: 22px; }
    .logo-upload-btn:hover .material-symbols-outlined { color: var(--cs-accent); }

    .logo-divider { width: 1px; height: 40px; background: var(--cs-border); margin: 0 4px; flex-shrink: 0; }

    /* ── Logo item: SIN onclick en HTML, manejado por JS con data-path ── */
    .logo-item {
        width: 90px;
        height: 52px;
        border: 2px solid var(--cs-border);
        border-radius: 8px;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--cs-white);
        transition: all .2s;
        flex-shrink: 0;
    }
    .logo-item img { max-width: 85%; max-height: 85%; object-fit: contain; pointer-events: none; }
    .logo-item:hover { border-color: #adb5bd; }
    .logo-item.selected {
        border-color: var(--cs-accent) !important;
        background: var(--cs-accent-lt);
        box-shadow: 0 0 0 3px rgba(13,110,253,.15);
    }
    .logo-item.selected::after {
        content: '✓';
        position: absolute;
        top: -7px; right: -7px;
        background: var(--cs-accent);
        color: white;
        border-radius: 50%;
        width: 16px; height: 16px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 1px 4px rgba(13,110,253,.4);
    }
    .btn-del-logo {
        position: absolute;
        bottom: -6px; right: -6px;
        background: var(--cs-danger);
        color: white;
        border-radius: 50%;
        width: 16px; height: 16px;
        font-size: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity .2s;
        border: none;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        z-index: 10;
    }
    .logo-item:hover .btn-del-logo { opacity: 1; }

    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid var(--cs-border) !important;
        background: var(--cs-light);
        padding: 10px 32px !important;
    }
    .ql-container.ql-snow {
        border: none !important;
        font-size: 15px;
        font-family: 'DM Sans', sans-serif;
        min-height: 260px;
    }
    #editor-container { padding: 0 32px; }
    .ql-editor { padding: 24px 0 !important; }
    .ql-editor p { color: var(--cs-dark-2); line-height: 1.75; }

    .cs-form-footer {
        padding: 20px 32px;
        background: var(--cs-light);
        border-top: 1px solid var(--cs-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .cs-file-input {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: var(--cs-muted);
        cursor: pointer;
    }
    .cs-file-input::file-selector-button {
        margin-right: 12px;
        padding: 6px 14px;
        border-radius: 6px;
        border: 1px solid var(--cs-border);
        background: var(--cs-white);
        font-size: 12px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--cs-dark-2);
        cursor: pointer;
        transition: all .15s;
    }
    .cs-file-input::file-selector-button:hover {
        background: var(--cs-dark);
        color: white;
        border-color: var(--cs-dark);
    }
    .btn-actions { display: flex; gap: 12px; align-items: center; flex-shrink: 0; }

    .btn-reset {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--cs-muted);
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        transition: color .2s, background .2s;
    }
    .btn-reset:hover { color: var(--cs-dark); background: var(--cs-border); }

    .btn-send {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        background: var(--cs-dark);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 7px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 2px 8px rgba(33,37,41,.2);
    }
    .btn-send:hover {
        background: var(--cs-dark-2);
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(33,37,41,.25);
    }
    .btn-send:active { transform: translateY(0); }
    .btn-send .material-symbols-outlined { font-size: 17px; }
    .btn-send.sending { opacity: .65; pointer-events: none; }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@section('content')
<div class="cs-composer-wrap">
    <div style="max-width:820px;margin:0 auto;">

        {{-- Título --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div>
                <h1 style="font-family:'Crimson Pro',serif;font-size:26px;font-weight:700;color:#212529;margin:0 0 2px;">
                    Email Marketing
                </h1>
                <p style="font-family:'DM Sans',sans-serif;font-size:13px;color:#6c757d;margin:0;">
                    Compositor de correos corporativos
                </p>
            </div>
            <a href="{{ route('admin.marketing.metricas') }}"
               style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:#6c757d;text-decoration:none;display:flex;align-items:center;gap:6px;">
                <i class="bi bi-arrow-left"></i> Volver a Métricas
            </a>
        </div>

        <div class="cs-panel">

            <div class="cs-panel-header">
                <h2><i class="bi bi-envelope-paper me-2" style="font-size:18px;opacity:.8;"></i>Nuevo mensaje</h2>
                <span class="cs-badge-secure">Envío seguro</span>
            </div>

            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data">
                @csrf
                {{-- Estos dos hidden son los que viajan al controller --}}
                <input type="hidden" name="contenido"  id="contenidoHtml">
                <input type="hidden" name="logo_path"  id="selectedLogoPath">

                {{-- Para + Asunto --}}
                <div class="cs-section" style="background:#fafafa;">
                    <div class="cs-field-row" style="margin-bottom:14px;">
                        <span class="cs-label">Para</span>
                        <input type="text" name="destinatarios" class="cs-input"
                               placeholder="cliente@empresa.com, otro@correo.com" required>
                    </div>
                    <div class="cs-field-row">
                        <span class="cs-label">Asunto</span>
                        <input type="text" name="asunto" class="cs-input cs-input-subject"
                               placeholder="Escribe el asunto del correo…" required>
                    </div>
                </div>

                {{-- Logos --}}
                <div class="cs-section">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <p class="cs-section-label" style="margin:0;">Membrete / Logo</p>
                        <span style="font-family:'DM Sans',sans-serif;font-size:10px;color:#adb5bd;">
                            Clic para seleccionar · clic de nuevo para deseleccionar
                        </span>
                    </div>
                    <div class="logos-row">
                        {{-- Botón subir --}}
                        <label class="logo-upload-btn" title="Subir logo">
                            <span class="material-symbols-outlined">add_photo_alternate</span>
                            <input type="file" class="d-none" id="logoInput" accept="image/*">
                        </label>
                        <div class="logo-divider"></div>

                        {{-- Contenedor logos: usa data-path, SIN onclick en HTML --}}
                        <div id="logosContainer" style="display:flex;gap:10px;flex-wrap:wrap;">
                            @forelse($logos ?? [] as $logo)
                                <div class="logo-item" data-path="{{ $logo['path'] }}">
                                    <img src="{{ $logo['url'] }}" alt="logo">
                                    <button type="button" class="btn-del-logo"
                                            data-path="{{ $logo['path'] }}">✕</button>
                                </div>
                            @empty
                                <span id="logoPlaceholder"
                                      style="font-family:'DM Sans',sans-serif;font-size:12px;color:#adb5bd;align-self:center;">
                                    Sin logos guardados — sube uno con el botón +
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Editor Quill --}}
                <div>
                    <div id="editor-container" style="background:#fff;">
                        <p>Hola,</p>
                        <p>Adjunto encontrarás la cotización solicitada de <strong>Cisnergia Perú</strong>.</p>
                        <p>Quedamos atentos a cualquier consulta.</p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="cs-form-footer">
                    <div>
                        <p class="cs-section-label" style="margin:0 0 6px;">Archivos adjuntos</p>
                        <input type="file" name="adjuntos[]" multiple class="cs-file-input">
                    </div>
                    <div class="btn-actions">
                        <button type="button" class="btn-reset" onclick="location.reload()">
                            Limpiar
                        </button>
                        <button type="submit" class="btn-send" id="btnSend">
                            Enviar propuesta
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <p style="font-family:'DM Sans',sans-serif;font-size:11px;color:#adb5bd;text-align:center;margin-top:14px;">
            <i class="bi bi-info-circle me-1"></i>
            Separa múltiples destinatarios con coma. Los detalles de envío quedan registrados en los logs del sistema.
        </p>

    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    // ── Quill ────────────────────────────────────────────────────────────
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Escribe el cuerpo del correo…',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': [1, 2, 3, false] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote', 'clean']
            ]
        }
    });

    // ── SELECCIÓN DE LOGO ────────────────────────────────────────────────
    // Usamos delegación de eventos desde el contenedor.
    // Esto funciona tanto para logos cargados desde PHP (blade)
    // como para los subidos dinámicamente vía Ajax.
    // NO usamos onclick en el HTML para evitar conflictos con jQuery/Bootstrap.
    document.getElementById('logosContainer').addEventListener('click', function(e) {

        // Si el clic fue en el botón de eliminar, no hacemos nada aquí
        // (lo maneja el listener de abajo)
        if (e.target.closest('.btn-del-logo')) return;

        // Buscar el .logo-item más cercano al elemento clickeado
        const item = e.target.closest('.logo-item');
        if (!item) return;

        const path = item.dataset.path;
        const isSelected = item.classList.contains('selected');

        // Deseleccionar todos primero
        document.querySelectorAll('.logo-item').forEach(el => el.classList.remove('selected'));

        if (!isSelected) {
            // Seleccionar este
            item.classList.add('selected');
            document.getElementById('selectedLogoPath').value = path;
            console.log('[Logo] Seleccionado:', path); // debug — verifica en consola
        } else {
            // Era el mismo, deseleccionar
            document.getElementById('selectedLogoPath').value = '';
            console.log('[Logo] Deseleccionado');
        }
    });

    // ── ELIMINAR LOGO ────────────────────────────────────────────────────
    document.getElementById('logosContainer').addEventListener('click', async function(e) {
        const btn = e.target.closest('.btn-del-logo');
        if (!btn) return;

        // Detener propagación para que el listener de selección no se active
        e.stopPropagation();
        e.preventDefault();

        const path = btn.dataset.path;
        if (!confirm('¿Eliminar este logo?')) return;

        try {
            await axios.delete("{{ route('admin.marketing.emails.logo.delete') }}", {
                data: { path: path }
            });
            btn.closest('.logo-item').remove();

            // Si era el logo seleccionado, limpiar el hidden
            if (document.getElementById('selectedLogoPath').value === path) {
                document.getElementById('selectedLogoPath').value = '';
            }

            // Mostrar placeholder si no quedan logos
            if (document.querySelectorAll('.logo-item').length === 0) {
                document.getElementById('logosContainer').innerHTML =
                    '<span id="logoPlaceholder" style="font-family:\'DM Sans\',sans-serif;font-size:12px;color:#adb5bd;align-self:center;">Sin logos guardados — sube uno con el botón +</span>';
            }
        } catch (err) {
            console.error('[Logo] Error al eliminar:', err);
            alert('Error al eliminar el logo.');
        }
    });

    // ── SUBIR LOGO VÍA AJAX ──────────────────────────────────────────────
    document.getElementById('logoInput').addEventListener('change', async function() {
        if (!this.files.length) return;

        const formData = new FormData();
        formData.append('logo', this.files[0]);

        try {
            const res = await axios.post("{{ route('admin.marketing.emails.logo.upload') }}", formData);
            console.log('[Logo] Respuesta del servidor:', res.data); // debug

            if (res.data.success) {
                // Quitar placeholder si existe
                const placeholder = document.getElementById('logoPlaceholder');
                if (placeholder) placeholder.remove();

                // Crear el elemento con data-path (NO onclick)
                const div = document.createElement('div');
                div.className = 'logo-item';
                div.dataset.path = res.data.path; // <-- aquí se guarda el path
                div.innerHTML = `
                    <img src="${res.data.url}" alt="logo">
                    <button type="button" class="btn-del-logo" data-path="${res.data.path}">✕</button>
                `;
                document.getElementById('logosContainer').prepend(div);

                console.log('[Logo] Añadido con path:', res.data.path); // debug
            }
        } catch (err) {
            console.error('[Logo] Error al subir:', err);
            alert('No se pudo subir la imagen. Verifica el formato y tamaño (máx. 5 MB).');
        }

        this.value = ''; // limpiar input para permitir subir el mismo archivo de nuevo
    });

    // ── ENVÍO DEL FORMULARIO ─────────────────────────────────────────────
    document.getElementById('btnSend').addEventListener('click', function(e) {
        const form = document.getElementById('emailForm');

        // Validación nativa HTML5
        if (!form.checkValidity()) {
            form.reportValidity();
            e.preventDefault();
            return;
        }

        // Validar que Quill no esté vacío
        const contenido = quill.root.innerHTML.trim();
        if (contenido === '<p><br></p>' || contenido === '') {
            alert('El cuerpo del correo no puede estar vacío.');
            e.preventDefault();
            return;
        }

        // Inyectar el HTML de Quill en el hidden input
        document.getElementById('contenidoHtml').value = contenido;

        // Log de diagnóstico — verifica en consola antes del submit
        const logoPath = document.getElementById('selectedLogoPath').value;
        console.log('[Envío] logo_path que se mandará al servidor:', logoPath || '(ninguno)');
        console.log('[Envío] Contenido Quill (primeros 100 chars):', contenido.substring(0, 100));

        // Deshabilitar botón para evitar doble envío
        const btn = this;
        btn.classList.add('sending');
        btn.innerHTML = '<span class="material-symbols-outlined" style="animation:spin 1s linear infinite;font-size:17px;">progress_activity</span> Enviando…';
    });
</script>
@endsection