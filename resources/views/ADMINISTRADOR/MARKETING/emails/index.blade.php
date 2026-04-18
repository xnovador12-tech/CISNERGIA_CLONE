@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Compositor Cisnergia')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        corePlugins: { preflight: false },
        theme: {
            extend: {
                colors: {
                    background: "#f9f9ff",
                    primary: "#9d4300",
                    "primary-container": "#f97316",
                    "surface-container-low": "#f0f3ff",
                    "surface-container-high": "#dee8ff",
                    "outline-variant": "#e0c0b1",
                }
            }
        }
    }
</script>

<style>
    .glass-panel { background-color: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); }
    .energy-gradient { background: linear-gradient(135deg, #9d4300 0%, #f97316 100%); }
    .ambient-shadow { box-shadow: 0 24px 48px rgba(17, 28, 45, 0.08); }
    .ql-toolbar.ql-snow { border: none !important; border-bottom: 1px solid #e2e8f0 !important; }
    .ql-container.ql-snow { border: none !important; min-height: 300px; font-size: 16px; }
    
    /* Estilo para logo seleccionado */
    .logo-item { transition: all 0.2s; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; position: relative; width: 100px; height: 50px; display: flex; align-items: center; justify-content: center; background: white;}
    .logo-item img { max-width: 90%; max-height: 90%; object-fit: contain; }
    .logo-item.selected { border-color: #f97316 !important; background: #fff7ed; box-shadow: 0 0 10px rgba(249, 115, 22, 0.2); }
    .logo-item.selected::after { content: '✓'; position: absolute; top: -8px; right: -8px; background: #f97316; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .btn-del-logo { position: absolute; bottom: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 16px; height: 16px; font-size: 10px; display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.2s; border:none; }
    .logo-item:hover .btn-del-logo { opacity: 1; }
</style>
@endsection

@section('content')
<div class="p-4" style="background-color: #e2e8f0; min-height: 90vh;">
    <div class="max-w-5xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Compositor Cisnergia</h2>
            <span class="bg-orange-100 text-orange-600 px-4 py-1 rounded-full text-xs font-bold shadow-sm">ENVÍO SEGURO</span>
        </div>

        <div class="glass-panel rounded-2xl ambient-shadow overflow-hidden">
            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contenido" id="contenidoHtml">
                <input type="hidden" name="logo_path" id="selectedLogoPath">

                <div class="p-8 bg-slate-50/50 border-b border-slate-100 space-y-4">
                    <div class="flex items-center gap-4">
                        <label class="w-16 font-semibold text-slate-500">Para:</label>
                        <input type="text" name="destinatarios" class="flex-1 bg-white border border-slate-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-orange-500/20" placeholder="cliente@correo.com" required>
                    </div>
                    <div class="flex items-center gap-4">
                        <label class="w-16 font-semibold text-slate-500">Asunto:</label>
                        <input type="text" name="asunto" class="flex-1 bg-white border border-slate-200 rounded-lg px-4 py-2 text-lg font-bold outline-none focus:ring-2 focus:ring-orange-500/20" placeholder="Escribe el asunto..." required>
                    </div>
                </div>

                <div class="px-8 py-4 bg-white border-b border-slate-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Membrete / Logo del correo</span>
                        <span class="text-[10px] text-slate-400">Haz clic para marcar/desmarcar</span>
                    </div>
                    <div class="flex gap-3 items-center overflow-x-auto py-2">
                        <label class="w-12 h-12 border-2 border-dashed border-orange-300 rounded-lg flex items-center justify-center cursor-pointer hover:bg-orange-50 transition-colors flex-shrink-0">
                            <span class="material-symbols-outlined text-orange-500">add_photo_alternate</span>
                            <input type="file" class="hidden" id="logoInput" accept="image/*" onchange="ajaxUploadLogo(this)">
                        </label>

                        <div class="h-8 w-px bg-slate-200 mx-1"></div>

                        <div id="logosContainer" class="flex gap-3">
                            @foreach($logos ?? [] as $logo)
                                <div class="logo-item" onclick="toggleLogo('{{ $logo['path'] }}', this)">
                                    <img src="{{ asset('storage/' . $logo['path']) }}">
                                    <button type="button" class="btn-del-logo" onclick="deleteLogo('{{ $logo['path'] }}', this, event)">✕</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="editor-container" class="bg-white">
                    <p>Hola,</p>
                    <p>Adjunto encontrarás la cotización solicitada de <strong>Cisnergia Perú</strong>.</p>
                </div>

                <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                    <div class="flex-1">
                        <input type="file" name="adjuntos[]" multiple class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200 cursor-pointer">
                    </div>
                    <div class="flex gap-4">
                        <button type="button" onclick="location.reload()" class="px-6 py-2 text-slate-400 font-bold hover:text-slate-600 transition-colors">Limpiar</button>
                        <button type="submit" onclick="prepararEnvio(event)" class="energy-gradient text-white px-10 py-2.5 rounded-full font-bold shadow-lg shadow-orange-500/30 flex items-center gap-2 hover:scale-105 transition-transform border-0">
                            Enviar Propuesta <span class="material-symbols-outlined text-sm">send</span>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: { toolbar: [['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['link', 'clean']] }
    });

    // SELECCIÓN / DESELECCIÓN
    function toggleLogo(path, element) {
        const isSelected = element.classList.contains('selected');
        document.querySelectorAll('.logo-item').forEach(el => el.classList.remove('selected'));
        
        if (!isSelected) {
            element.classList.add('selected');
            document.getElementById('selectedLogoPath').value = path;
        } else {
            document.getElementById('selectedLogoPath').value = '';
        }
    }

    // SUBIDA SIN RECARGAR
    async function ajaxUploadLogo(input) {
        if (!input.files.length) return;
        let formData = new FormData();
        formData.append('logo', input.files[0]);

        try {
            const res = await axios.post("{{ route('admin.marketing.emails.logo.upload') }}", formData);
            if (res.data.success) {
                const newLogoHtml = `
                    <div class="logo-item" onclick="toggleLogo('${res.data.path}', this)">
                        <img src="${res.data.url}">
                        <button type="button" class="btn-del-logo" onclick="deleteLogo('${res.data.path}', this, event)">✕</button>
                    </div>
                `;
                document.getElementById('logosContainer').insertAdjacentHTML('afterbegin', newLogoHtml);
            }
        } catch (e) { Swal.fire('Error', 'No se pudo subir la imagen', 'error'); }
    }

    // ELIMINAR SIN RECARGAR
    async function deleteLogo(path, element, event) {
        event.stopPropagation();
        if(!confirm('¿Eliminar logo?')) return;
        try {
            await axios.delete("{{ route('admin.marketing.emails.logo.delete') }}", { data: { path: path } });
            element.closest('.logo-item').remove();
            if(document.getElementById('selectedLogoPath').value === path) document.getElementById('selectedLogoPath').value = '';
        } catch (e) { alert('Error al borrar'); }
    }

    function prepararEnvio(event) {
        const form = document.getElementById('emailForm');
        if (!form.checkValidity()) { form.reportValidity(); event.preventDefault(); return; }
        
        document.getElementById('contenidoHtml').value = quill.root.innerHTML;
        const btn = event.currentTarget;
        btn.innerHTML = 'Enviando...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
    }
</script>
@endsection