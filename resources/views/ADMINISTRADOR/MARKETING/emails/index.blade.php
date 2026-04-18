@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Compositor Cisnergia')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        corePlugins: {
            preflight: false, // ESTO ES LA MAGIA: Evita que Tailwind rompa Bootstrap
        },
        theme: {
            extend: {
                colors: {
                    background: "#f9f9ff",
                    surface: "#f9f9ff",
                    "on-surface": "#111c2d",
                    "surface-variant": "#d8e3fb",
                    "on-surface-variant": "#584237",
                    primary: "#9d4300",
                    "primary-container": "#f97316",
                    "on-primary": "#ffffff",
                    "surface-container-low": "#f0f3ff",
                    "surface-container-high": "#dee8ff",
                    "surface-container-highest": "#d8e3fb",
                    secondary: "#855300",
                    error: "#ba1a1a",
                    "outline-variant": "#e0c0b1",
                },
                fontFamily: {
                    headline: ["Manrope", "sans-serif"],
                    body: ["Inter", "sans-serif"],
                }
            }
        }
    }
</script>

<style>
    /* Estilos mínimos para que Quill y el Glassmorphism funcionen en Tailwind */
    .glass-panel {
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .energy-gradient { background: linear-gradient(135deg, #9d4300 0%, #f97316 100%); }
    .ambient-shadow { box-shadow: 0 24px 48px rgba(17, 28, 45, 0.06); }
    
    .ql-toolbar.ql-snow { border: none; border-bottom: 1px solid #e0c0b1; padding: 10px; }
    .ql-container.ql-snow { border: none; font-size: 16px; font-family: 'Inter', sans-serif; }
    .ql-editor { min-height: 300px; }
    
    /* Galería Logos */
    .logo-item.selected { border-color: #f97316; box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.2); }
</style>
@endsection

@section('content')
<div class="flex-1 flex flex-col h-full relative bg-[#cfdaf2] overflow-hidden rounded-3 shadow" style="min-height: 85vh;">
    
    <header class="h-16 flex-shrink-0 flex items-center justify-between px-8 bg-surface-container-low z-10 transition-colors">
        <div class="flex items-center gap-4">
            <h2 class="font-headline font-bold text-on-surface text-xl tracking-tight m-0">Compositor Cisnergia</h2>
            <span class="px-3 py-1 rounded-full bg-surface-variant text-primary text-xs font-semibold uppercase tracking-wider">Draft</span>
        </div>
    </header>

    @if(session('success'))
        <div class="m-4 alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}</div>
    @endif

    <div class="flex-1 overflow-hidden p-6 lg:p-8 flex items-start justify-center relative">
        <div class="w-full max-w-5xl h-full flex flex-col glass-panel rounded-[1rem] ambient-shadow overflow-hidden relative z-10">
            
            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data" class="flex flex-col h-full m-0">
                @csrf
                <input type="hidden" name="contenido" id="contenidoHtml">
                <input type="hidden" name="logo_path" id="selectedLogoPath">

                <div class="px-8 py-6 bg-surface-container-high/50 flex-shrink-0 space-y-4">
                    <div class="flex items-center gap-4 group">
                        <label class="font-medium text-on-surface-variant w-16 flex-shrink-0 m-0">Para:</label>
                        <input class="flex-1 bg-surface-variant/50 border-none rounded-md px-4 py-2 text-on-surface focus:ring-2 focus:ring-secondary/50 outline-none" type="text" name="destinatarios" placeholder="cliente@empresa.com, juan@gmail.com" required/>
                    </div>
                    <div class="flex items-center gap-4 group">
                        <label class="font-medium text-on-surface-variant w-16 flex-shrink-0 m-0">Asunto:</label>
                        <input class="flex-1 bg-surface-variant/50 border-none rounded-md px-4 py-2.5 text-on-surface text-lg font-headline font-semibold focus:ring-2 focus:ring-secondary/50 outline-none" name="asunto" type="text" placeholder="Propuesta Oficial - Cisnergia" required/>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto px-10 py-4 bg-transparent relative">
                    
                    <div class="absolute top-4 right-10 flex flex-col items-end opacity-80 group z-20">
                        <div class="text-xs font-semibold text-on-surface-variant mb-1 uppercase tracking-widest">Membrete / Logo</div>
                        
                        <div class="flex gap-2">
                            <label class="h-12 w-12 bg-white rounded-md flex items-center justify-center border border-dashed border-primary cursor-pointer hover:bg-surface-variant transition-colors">
                                <span class="material-symbols-outlined text-primary text-[20px]">upload</span>
                                <input type="file" id="logoUploader" accept="image/*" class="hidden" onchange="uploadNewLogo(this)">
                            </label>

                            @foreach($logos ?? [] as $logo)
                                <div id="logo-{{ $loop->index }}" class="logo-item h-12 w-24 bg-white rounded-md flex items-center justify-center border border-outline-variant/50 cursor-pointer relative overflow-visible" onclick="toggleLogo('{{ $logo['path'] }}', 'logo-{{ $loop->index }}')">
                                    <img src="{{ asset('storage/' . $logo['path']) }}" class="max-h-full max-w-full object-contain p-1" alt="Logo">
                                    <button type="button" class="absolute -bottom-2 -right-2 bg-error text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 hover:opacity-100 transition-opacity" onclick="deleteLogo('{{ $logo['path'] }}', event)">
                                        <span class="material-symbols-outlined text-[12px]">close</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="editor-container" class="mt-16 text-on-surface">
                        <p class="text-lg mb-6">Hola,</p>
                        <p>Espero que este email te encuentre muy bien.</p>
                        <p>Adjunto encontrarás la propuesta comercial. El rendimiento proyectado se alinea perfectamente con los objetivos para el próximo año.</p>
                        <p class="mt-8 mb-2">Saludos cordiales,</p>
                        <div class="font-headline font-bold text-primary">{{ Auth::user()?->persona?->name . ' ' . Auth::user()?->persona?->surnames }}</div>
                        <div class="text-sm text-on-surface-variant">Administrador | Cisnergia Perú</div>
                    </div>
                </div>

                <div class="flex-shrink-0 px-8 py-4 bg-surface/50 border-t border-outline-variant/10">
                    <div class="text-sm font-semibold text-on-surface-variant mb-2">Archivos Adjuntos (PDF, Excel, IMG)</div>
                    <input class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-surface-variant file:text-primary hover:file:bg-surface-container-high cursor-pointer" type="file" name="adjuntos[]" multiple accept=".pdf,.doc,.docx,.jpg,.png,.xlsx">
                </div>

                <div class="flex-shrink-0 px-8 py-5 bg-surface-container-low flex justify-between items-center rounded-b-[1rem]">
                    <div class="flex gap-2">
                        <span class="text-sm text-on-surface-variant font-medium"><i class="bi bi-shield-check text-success"></i> Servidor Listo</span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <button type="button" class="px-6 py-2 rounded-full bg-surface-container-highest text-primary font-medium hover:bg-surface-variant transition-colors" onclick="document.getElementById('emailForm').reset()">Descartar</button>
                        
                        <button type="submit" class="px-8 py-2.5 rounded-full energy-gradient text-on-primary font-bold shadow-md hover:opacity-90 transition-opacity flex items-center gap-2 border-0" onclick="prepararEnvio(event)">
                            Enviar Oficial
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    // 1. Inicializar Editor Quill en la caja de texto
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Redacta tu propuesta...',
        modules: { toolbar: [ ['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['link', 'clean'] ] }
    });

    // 2. Lógica Logos Tailwind
    function toggleLogo(path, elementId) {
        const element = document.getElementById(elementId);
        const isSelected = element.classList.contains('selected');
        
        document.querySelectorAll('.logo-item').forEach(el => {
            el.classList.remove('selected', 'border-primary', 'shadow-md');
            el.classList.add('border-outline-variant/50');
        });
        
        if (!isSelected) {
            element.classList.remove('border-outline-variant/50');
            element.classList.add('selected', 'border-primary', 'shadow-md');
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
            Swal.fire('Error', 'No se pudo subir. Verifica que sea JPG/PNG.', 'error');
        }
    }

    async function deleteLogo(path, event) {
        event.stopPropagation();
        const result = await Swal.fire({ title: '¿Eliminar logo?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Sí, borrar' });

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

    // 3. Preparar Envio
    function prepararEnvio(event) {
        var form = document.getElementById('emailForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            event.preventDefault(); return;
        }

        var htmlContent = document.querySelector('.ql-editor').innerHTML;
        if(htmlContent === '<p><br></p>' || htmlContent.trim() === '') {
            event.preventDefault();
            Swal.fire('Atención', 'El correo está vacío.', 'warning'); return;
        }
        
        document.getElementById('contenidoHtml').value = htmlContent;
        var btn = event.currentTarget;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span> Enviando...';
        btn.classList.add('opacity-50', 'pointer-events-none');
    }
</script>
@endsection