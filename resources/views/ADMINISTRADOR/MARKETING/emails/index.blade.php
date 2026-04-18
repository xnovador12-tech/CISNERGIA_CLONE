@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Campañas de Email')

@section('styles')
<style>
    :root {
        --cisnergia-dark: #1e293b;
        --cisnergia-sun: #f59e0b;
        --cisnergia-energy: #f97316;
        --cisnergia-light: #f8fafc;
    }
    
    .bg-solar-gradient {
        background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #334155 100%);
        color: white;
    }
    
    .btn-energy {
        background-color: var(--cisnergia-energy);
        color: white;
        font-weight: bold;
        transition: 0.3s;
        border: none;
    }
    .btn-energy:hover {
        background-color: var(--cisnergia-sun);
        color: var(--cisnergia-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    /* Estilos personalizados para el editor Quill */
    .ql-toolbar.ql-snow {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px 8px 0 0;
        font-family: inherit;
    }
    .ql-container.ql-snow {
        border: 1px solid #e2e8f0;
        border-radius: 0 0 8px 8px;
        background-color: white;
        font-size: 1rem;
    }
    .ql-editor {
        min-height: 300px;
    }

    /* Input Focus Styles */
    .form-control:focus {
        border-color: var(--cisnergia-sun);
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
    }
    
    .tips-card {
        background-color: #fffbeb;
        border-left: 4px solid var(--cisnergia-sun);
    }
</style>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">
                <i class="bi bi-envelope-paper-fill text-primary me-2"></i> Campañas Directas (Email)
            </h2>
            <p class="text-muted mb-0">Fidelización y envío de propuestas a prospectos captados.</p>
        </div>
        <div>
            <a href="{{ route('admin.marketing.metricas') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Volver al Radar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i> 
            <strong>¡Excelente!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i> 
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-solar-gradient py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-send me-2"></i> Redactor de Campaña</h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="contenido" id="contenidoHtml">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="bi bi-people-fill text-muted me-1"></i> Destinatarios</label>
                            <textarea class="form-control bg-light border-0" name="destinatarios" rows="2" placeholder="ejemplo: gerente@empresa.com, logistica@mina.com" required></textarea>
                            <div class="form-text mt-2">
                                <span class="badge bg-secondary text-white rounded-pill px-2 py-1">Tip</span> 
                                Separa los correos con comas (,). Ideal para copiar y pegar desde un Excel.
                            </div>
                            <div class="invalid-feedback">Por favor ingresa al menos un correo válido.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="bi bi-bookmark-fill text-muted me-1"></i> Asunto del Correo</label>
                            <input type="text" class="form-control bg-light border-0 form-control-lg fs-6" name="asunto" placeholder="Ej: Propuesta de Ahorro Energético con Paneles Solares - Cisnergia" required>
                            <div class="invalid-feedback">El asunto es obligatorio para que el correo no caiga en Spam.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="bi bi-file-richtext-fill text-muted me-1"></i> Contenido del Mensaje</label>
                            <div id="editor-container">
                                <h3>Hola,</h3>
                                <p>Gracias por tu interés en nuestros servicios de <strong>Energía Solar e Ingeniería</strong>.</p>
                                <p><br></p>
                                <p>Adjunto a este correo encontrarás nuestra propuesta técnico-comercial detallada. En <em>Cisnergia Perú</em> estamos comprometidos con...</p>
                                <p><br></p>
                                <p>Saludos cordiales,</p>
                                <p><strong>Equipo Comercial | Cisnergia Perú</strong></p>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-light text-muted fw-bold me-3 rounded-pill px-4" onclick="document.getElementById('emailForm').reset()">Limpiar Todo</button>
                            <button type="submit" class="btn btn-energy rounded-pill px-5 py-2 shadow-sm" onclick="prepararEnvio(event)">
                                <i class="bi bi-rocket-takeoff-fill me-2"></i> Iniciar Envío
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 tips-card rounded-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-lightbulb-fill text-warning fs-5 align-middle me-2"></i> Buenas Prácticas de Envío</h6>
                    <ul class="text-secondary small mb-0 ps-3" style="line-height: 1.8;">
                        <li><strong>Asuntos claros:</strong> Evita palabras como "GRATIS" o usar puras MAYÚSCULAS para no caer en Spam.</li>
                        <li><strong>Personalización:</strong> Aunque el envío sea masivo, mantén un tono profesional e institucional.</li>
                        <li><strong>Límites:</strong> Recuerda que el sistema está configurado para un envío prudente. No superes los 100 correos por tanda.</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 bg-light rounded-4 text-center">
                    <div class="bg-white rounded-circle d-inline-flex justify-content-center align-items-center shadow-sm mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check text-success fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Envíos Seguros</h6>
                    <p class="small text-muted mb-0">Los correos se despachan a través del SMTP verificado de Cisnergia, garantizando la entrega a la bandeja de entrada principal.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Inicialización del Editor Quill con Toolbar completa
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // Toggled buttons
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],               // Custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // Outdent/indent
        [{ 'size': ['small', false, 'large', 'huge'] }],  // Custom dropdown
        [{ 'color': [] }, { 'background': [] }],          // Dropdown with defaults from theme
        [{ 'align': [] }],
        ['clean']                                         // Remove formatting button
    ];

    var quill = new Quill('#editor-container', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow',
        placeholder: 'Redacta el contenido de la cotización o promoción aquí...'
    });

    // Función para pasar el HTML al input oculto y validar formulario
    function prepararEnvio(event) {
        var form = document.getElementById('emailForm');
        
        // Validación de Bootstrap
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Si el formulario es válido, pasamos el HTML de Quill al input oculto
            var htmlContent = document.querySelector('.ql-editor').innerHTML;
            
            // Validamos que el editor no esté vacío (Quill pone <p><br></p> cuando está vacío)
            if(htmlContent === '<p><br></p>' || htmlContent.trim() === '') {
                event.preventDefault();
                Swal.fire('Atención', 'El cuerpo del correo no puede estar vacío.', 'warning');
                return;
            }
            
            document.getElementById('contenidoHtml').value = htmlContent;
            
            // Cambiamos el texto del botón para que el usuario sepa que está cargando
            var btnSubmit = event.currentTarget;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Enviando...';
            btnSubmit.classList.add('disabled');
        }
        
        form.classList.add('was-validated');
    }
</script>
@endsection