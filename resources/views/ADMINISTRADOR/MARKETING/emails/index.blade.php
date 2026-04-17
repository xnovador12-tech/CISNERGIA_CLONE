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
    }
    .btn-energy:hover {
        background-color: var(--cisnergia-sun);
        color: var(--cisnergia-dark);
    }
</style>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-cisnergia-dark">
                <i class="bi bi-envelope-paper-fill text-primary me-2"></i> Envío de Cotizaciones y Promociones
            </h2>
            <p class="text-muted mb-0">Fidelización directa a prospectos captados.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-solar-gradient py-3" style="border-radius: 12px 12px 0 0;">
            <h5 class="mb-0 fw-bold"><i class="bi bi-send me-2"></i> Nueva Campaña de Email</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm">
                @csrf
                <input type="hidden" name="contenido" id="contenidoHtml">

                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-cisnergia-dark">Destinatarios (Separados por coma)</label>
                        <textarea class="form-control bg-light" name="destinatarios" rows="2" placeholder="ejemplo: cliente1@empresa.com, juan.perez@gmail.com" required></textarea>
                        <div class="form-text">Pega aquí los correos de los prospectos extraídos del Radar Orgánico de Facebook/Instagram.</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold text-cisnergia-dark">Asunto del Correo</label>
                        <input type="text" class="form-control bg-light" name="asunto" placeholder="Ej: Catálogo de Paneles Solares Industriales - Cisnergia" required>
                    </div>

                    <div class="col-md-12 mb-5">
                        <label class="form-label fw-bold text-cisnergia-dark">Cuerpo del Correo</label>
                        <div id="editor-container" style="height: 250px; border-radius: 0 0 8px 8px;">
                            <p>Hola,</p>
                            <p>Gracias por tu interés en nuestros proyectos de <strong>Energía Solar</strong>.</p>
                            <p>Adjunto encontrarás nuestra información...</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3">Cancelar</button>
                    <button type="submit" class="btn btn-energy px-5" onclick="prepararEnvio()">
                        <i class="bi bi-rocket-takeoff-fill me-2"></i> Despachar Campaña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Redacta el contenido de la cotización o promoción aquí...'
    });

    // Función para pasar el HTML del editor al input oculto antes de enviar el formulario
    function prepararEnvio() {
        var htmlContent = document.querySelector('.ql-editor').innerHTML;
        document.getElementById('contenidoHtml').value = htmlContent;
    }
</script>
@endsection