@extends('TEMPLATES.ecommerce')

@section('title', 'Libro de Reclamaciones | Cisnergia')

@section('css')
<style>
    :root {
        --cisnergia-dark: #1C3146;
        --cisnergia-green: #20c997;
        --cisnergia-muted: #6c757d;
    }

    .policy-header {
        background-color: #f8fafc;
        padding: 60px 0 40px;
        border-bottom: 1px solid #e2e8f0;
    }

    .policy-sidebar { position: sticky; top: 100px; }

    .policy-list-group .list-group-item {
        border: none;
        border-left: 4px solid transparent;
        border-radius: 0 !important;
        padding: 15px 20px;
        color: var(--cisnergia-muted);
        font-weight: 500;
        background: transparent;
        transition: all 0.3s ease;
        margin-bottom: 5px;
        cursor: pointer;
    }
    .policy-list-group .list-group-item:hover {
        background-color: rgba(28, 49, 70, 0.03);
        color: var(--cisnergia-dark);
    }
    .policy-list-group .list-group-item.active {
        background-color: rgba(32, 201, 151, 0.1);
        color: var(--cisnergia-dark);
        border-left-color: var(--cisnergia-green);
        font-weight: 700;
    }

    .policy-content {
        padding: 28px 36px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        min-height: 500px;
    }
    .policy-content h2 {
        color: var(--cisnergia-dark);
        font-weight: 800;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
    }

    .step-badge {
        display: inline-block;
        background: rgba(32,201,151,0.12);
        color: #0f6e56;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 4px 14px;
        margin-bottom: 14px;
        letter-spacing: 0.03em;
    }

    .progress-steps { display: flex; gap: 6px; margin-bottom: 28px; }
    .prog-step {
        flex: 1; height: 4px;
        background: #e2e8f0;
        border-radius: 999px;
        transition: background 0.3s;
    }
    .prog-step.done { background: var(--cisnergia-green); }

    .section-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: var(--cisnergia-muted);
        text-transform: uppercase;
        margin-bottom: 14px;
        margin-top: 6px;
    }

    .form-control-cis {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
        color: #334155;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control-cis:focus {
        border-color: var(--cisnergia-green);
        box-shadow: 0 0 0 3px rgba(32,201,151,0.12);
        outline: none;
    }

    .radio-option-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 10px;
    }
    .radio-option-card:hover,
    .radio-option-card.selected {
        border-color: var(--cisnergia-green);
        background-color: rgba(32,201,151,0.06);
    }
    .radio-option-card input[type="radio"] {
        accent-color: var(--cisnergia-green);
        margin-top: 3px;
    }

    /* ── FIX: todos los botones de navegación son type="button" en el CSS ── */
    .btn-cis-primary {
        background-color: var(--cisnergia-dark);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        transition: background 0.2s;
        cursor: pointer;
    }
    .btn-cis-primary:hover { background-color: #162739; }

    .btn-cis-secondary {
        background-color: #f8fafc;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        transition: background 0.2s;
        cursor: pointer;
    }
    .btn-cis-secondary:hover { background-color: #f1f5f9; }

    .info-box-green {
        background-color: #f0fdf9;
        border-left: 4px solid var(--cisnergia-green);
        border-radius: 0 10px 10px 0;
        padding: 14px 18px;
        margin: 20px 0;
        font-size: 0.93rem;
        color: #475569;
        line-height: 1.7;
    }

    .resumen-tabla td {
        padding: 8px 4px;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
    }
    .resumen-tabla td:first-child {
        color: var(--cisnergia-muted);
        width: 40%;
        font-weight: 500;
    }
    .resumen-tabla td:last-child { color: #334155; }

    .legal-note-footer {
        font-size: 0.82rem;
        color: var(--cisnergia-muted);
        line-height: 1.6;
        margin-top: 18px;
    }

    #confirmacion-exitosa { text-align: center; padding: 40px 0; }
</style>
@endsection

@section('content')

<div class="policy-header mt-5">
    <div class="container text-center">
        <h1 class="fw-bold display-5" style="color: #1C3146;">Libro de Reclamaciones</h1>
        <p class="text-muted fs-5 mt-2">Registre aquí su queja o reclamo de forma rápida y segura.</p>
        <span class="badge bg-white text-dark border px-3 py-2 mt-2">
            Conforme al D.S. N° 011-2011-PCM · Ley 29571
        </span>
    </div>
</div>

<div class="container py-5">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-lg-4 mb-4">
            <div class="policy-sidebar">
                <div class="list-group policy-list-group" id="sidebarNav">
                    <a class="list-group-item list-group-item-action active" href="javascript:void(0)" onclick="goToStep(0)">1. Identificación del consumidor</a>
                    <a class="list-group-item list-group-item-action"        href="javascript:void(0)" onclick="goToStep(1)">2. Identificación del bien / servicio</a>
                    <a class="list-group-item list-group-item-action"        href="javascript:void(0)" onclick="goToStep(2)">3. Detalle de la reclamación</a>
                    <a class="list-group-item list-group-item-action"        href="javascript:void(0)" onclick="goToStep(3)">4. Revisión y envío</a>
                </div>
            </div>
        </div>

        @php $productos_valores_recl = \App\Models\Producto::all(); @endphp

        {{-- CONTENIDO --}}
        <div class="col-lg-8">
            <div class="policy-content">

                {{-- El <form> envuelve todo pero los botones de navegación son type="button" --}}
                <form action="{{ route('ecommerce.reclamaciones.store') }}" method="POST" id="reclamoForm">
                    @csrf

                    {{-- ══════════════════════════════════════════
                         PASO 1 · Datos del consumidor
                    ══════════════════════════════════════════ --}}
                    <div class="tab-pane-cis" id="step-0">
                        <span class="step-badge">Paso 1 de 4</span>
                        <div class="progress-steps">
                            <div class="prog-step done"></div>
                            <div class="prog-step"></div>
                            <div class="prog-step"></div>
                            <div class="prog-step"></div>
                        </div>
                        <h2>1. Identificación del consumidor</h2>
                        <p class="text-muted mb-4" style="line-height:1.8;">
                            Ingrese sus datos personales. Estos serán usados exclusivamente para gestionar y responder su reclamación.
                        </p>

                        <div class="section-label">Datos personales</div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-cis" id="f_nombres" name="nombres" placeholder="Ej. Juan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-cis" id="f_apellidos" name="apellidos" placeholder="Ej. García López">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Tipo de documento <span class="text-danger">*</span></label>
                                <select class="form-select form-control-cis" id="f_tipodoc" name="tipo_documento">
                                    <option value="">Seleccionar...</option>
                                    <option>DNI</option>
                                    <option>RUC</option>
                                    <option>Carné de Extranjería</option>
                                    <option>Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">N° de documento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-cis" id="f_nrodoc" name="numero_documento" placeholder="Ej. 12345678">
                            </div>
                        </div>

                        <div class="section-label mt-3">Datos de contacto</div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Correo electrónico <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-cis" id="f_email" name="correo" placeholder="correo@ejemplo.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Teléfono / Celular <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-cis" id="f_telefono" name="telefono" placeholder="Ej. 987 654 321">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Dirección <span class="text-muted">(opcional)</span></label>
                            <input type="text" class="form-control form-control-cis" id="f_direccion" name="direccion" placeholder="Av. Ejemplo 123, Lima">
                        </div>

                        {{-- FIX: type="button" para que NO haga submit --}}
                        <button type="button" class="btn-cis-primary" onclick="goToStep(1)">Continuar →</button>
                    </div>

                    {{-- ══════════════════════════════════════════
                         PASO 2 · Bien / Servicio
                    ══════════════════════════════════════════ --}}
                    <div class="tab-pane-cis d-none" id="step-1">
                        <span class="step-badge">Paso 2 de 4</span>
                        <div class="progress-steps">
                            <div class="prog-step done"></div>
                            <div class="prog-step done"></div>
                            <div class="prog-step"></div>
                            <div class="prog-step"></div>
                        </div>
                        <h2>2. Identificación del bien / servicio</h2>
                        <p class="text-muted mb-4" style="line-height:1.8;">
                            Indique qué producto o servicio de Cisnergia está relacionado con su reclamación.
                        </p>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Producto/Servicio <span class="text-danger">*</span></label>
                            <select class="form-select form-control-cis" id="f_producto" name="producto_id">
                                <option value="">Seleccionar...</option>
                                @foreach($productos_valores_recl as $producto)
                                    <option value="{{ $producto->name }}">{{ $producto->name }}</option>
                                @endforeach
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">N° de pedido / contrato <span class="text-muted">(si tiene)</span></label>
                                <input type="text" class="form-control form-control-cis" id="f_pedido" name="nro_pedido" placeholder="Ej. PED-2025-001">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Fecha de compra / contratación</label>
                                <input type="date" class="form-control form-control-cis" id="f_fechacompra" name="fecha_compra">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Monto pagado (S/.) <span class="text-muted">(si aplica)</span></label>
                            <input type="text" class="form-control form-control-cis" id="f_monto" name="monto_pagado" placeholder="Ej. 3500.00">
                        </div>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <button type="button" class="btn-cis-secondary" onclick="goToStep(0)">← Atrás</button>
                            </div>
                            <div class="col-md-8">
                                <button type="button" class="btn-cis-primary" onclick="goToStep(2)">Continuar →</button>
                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         PASO 3 · Detalle de la reclamación
                    ══════════════════════════════════════════ --}}
                    <div class="tab-pane-cis d-none" id="step-2">
                        <span class="step-badge">Paso 3 de 4</span>
                        <div class="progress-steps">
                            <div class="prog-step done"></div>
                            <div class="prog-step done"></div>
                            <div class="prog-step done"></div>
                            <div class="prog-step"></div>
                        </div>
                        <h2>3. Detalle de la reclamación</h2>

                        <div class="section-label">Tipo de reclamación <span class="text-danger">*</span></div>

                        <label class="radio-option-card" id="opt-reclamo">
                            <input type="radio" name="tipo_reclamo" value="Reclamo" onchange="selectTipo('opt-reclamo')">
                            <div>
                                <div class="fw-semibold" style="font-size:0.95rem;">Reclamo</div>
                                <div class="text-muted" style="font-size:0.85rem; margin-top:2px;">Disconformidad relacionada a los productos o servicios prestados.</div>
                            </div>
                        </label>
                        <label class="radio-option-card" id="opt-queja">
                            <input type="radio" name="tipo_reclamo" value="Queja" onchange="selectTipo('opt-queja')">
                            <div>
                                <div class="fw-semibold" style="font-size:0.95rem;">Queja</div>
                                <div class="text-muted" style="font-size:0.85rem; margin-top:2px;">Malestar o descontento respecto a la atención al cliente o gestión interna.</div>
                            </div>
                        </label>

                        <div class="mb-3 mt-3">
                            <label class="form-label fw-semibold small">Descripción detallada <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-cis" id="f_descripcion" name="descripcion_reclamo" rows="5"
                                placeholder="Describa con detalle lo ocurrido: fecha del incidente, qué producto o servicio está involucrado y cuál es el problema..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">¿Qué solución espera recibir? <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-cis" id="f_solucion" name="solucion_esperada" rows="3"
                                placeholder="Ej: Solicito el cambio del panel defectuoso / reembolso / revisión técnica..."></textarea>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <button type="button" class="btn-cis-secondary" onclick="goToStep(1)">← Atrás</button>
                            </div>
                            <div class="col-md-8">
                                <button type="button" class="btn-cis-primary" onclick="goToStep(3)">Revisar reclamación →</button>
                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         PASO 4 · Revisión y envío
                    ══════════════════════════════════════════ --}}
                    <div class="tab-pane-cis d-none" id="step-3">
                        <span class="step-badge">Paso 4 de 4 · Revisión</span>
                        <div class="progress-steps">
                            <div class="prog-step done"></div>
                            <div class="prog-step done"></div>
                            <div class="prog-step done"></div>
                            <div class="prog-step done"></div>
                        </div>
                        <h2>4. Revisión y envío</h2>
                        <p class="text-muted mb-3" style="line-height:1.8;">
                            Verifique que la información sea correcta antes de enviar. Recibirá una confirmación en su correo electrónico.
                        </p>

                        <div id="resumen-container" class="p-3 rounded-3 mb-3" style="background:#f8fafc; border: 1px solid #e2e8f0;">
                            <table class="resumen-tabla w-100" id="resumenTabla"></table>
                        </div>

                        <div class="info-box-green">
                            <strong>Plazo de respuesta:</strong> Cisnergia Perú dará respuesta a su reclamación en un plazo máximo de
                            <strong>15 días hábiles</strong>, conforme a lo establecido por la legislación peruana (Ley N° 29571).
                        </div>

                        <div class="form-check mb-4 mt-3">
                            <input class="form-check-input" type="checkbox" id="f_acepta" style="accent-color: var(--cisnergia-green);">
                            <label class="form-check-label text-muted" for="f_acepta" style="font-size:0.88rem;">
                                He leído y acepto que los datos proporcionados serán tratados conforme a las
                                <a href="{{ route('ecommerce.politicas') }}" class="text-decoration-none" style="color: var(--cisnergia-green);">Políticas de Privacidad</a>
                                de Cisnergia Perú.
                            </label>
                        </div>

                        {{-- Mensaje de éxito (oculto hasta confirmar envío) --}}
                        <div id="confirmacion-exitosa" class="d-none text-center py-4">
                            <div style="width:64px;height:64px;background:rgba(32,201,151,0.12);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--cisnergia-green);margin:0 auto 20px;">✓</div>
                            <h5 class="fw-bold" style="color:#1C3146;">¡Reclamación registrada exitosamente!</h5>
                            <p class="text-muted mt-2">Recibirá una respuesta en su correo en un máximo de <strong>15 días hábiles</strong>.</p>
                        </div>

                        <div id="botones-envio">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <button type="button" class="btn-cis-secondary" onclick="goToStep(2)">← Atrás</button>
                                </div>
                                <div class="col-md-8">
                                    {{-- FIX: este es el único botón type="submit" real --}}
                                    <button type="button" class="btn-cis-primary" id="btnEnviar" onclick="submitForm()">
                                        Enviar reclamación
                                    </button>
                                </div>
                            </div>
                            <p class="legal-note-footer">
                                El proveedor deberá poner a disposición de los consumidores el Libro de Reclamaciones
                                conforme al Código de Protección y Defensa del Consumidor.
                            </p>
                        </div>
                    </div>

                </form>{{-- /#reclamoForm --}}

            </div>{{-- /.policy-content --}}
        </div>{{-- /.col-lg-8 --}}
    </div>{{-- /.row --}}
</div>{{-- /.container --}}

@endsection

@section('js')
<script>
    // ─── Navegación entre pasos ───────────────────────────────────────────────
    function goToStep(n) {
        document.querySelectorAll('.tab-pane-cis').forEach(el => el.classList.add('d-none'));
        document.querySelectorAll('#sidebarNav .list-group-item').forEach((el, i) => {
            el.classList.toggle('active', i === n);
        });
        document.getElementById('step-' + n).classList.remove('d-none');
        if (n === 3) buildResumen();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ─── Selección visual de tipo de reclamo ─────────────────────────────────
    function selectTipo(optId) {
        document.querySelectorAll('.radio-option-card').forEach(el => el.classList.remove('selected'));
        document.getElementById(optId).classList.add('selected');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────
    function getVal(id) {
        const el = document.getElementById(id);
        return el ? (el.value.trim() || '—') : '—';
    }

    // ─── Construir tabla de resumen en paso 4 ────────────────────────────────
    function buildResumen() {
        // FIX: el name real del radio es "tipo_reclamo", no "tipo_rec"
        const tipo = document.querySelector('input[name="tipo_reclamo"]:checked');

        const rows = [
            ['Nombre completo',    getVal('f_nombres') + ' ' + getVal('f_apellidos')],
            ['Documento',          getVal('f_tipodoc') + ' ' + getVal('f_nrodoc')],
            ['Correo',             getVal('f_email')],
            ['Teléfono',           getVal('f_telefono')],
            ['Dirección',          getVal('f_direccion')],
            ['Producto/Servicio',  getVal('f_producto')],
            ['N° de pedido',       getVal('f_pedido')],
            ['Fecha de compra',    getVal('f_fechacompra')],
            ['Monto (S/.)',        getVal('f_monto')],
            ['Tipo de reclamación', tipo ? tipo.value : '—'],
            ['Descripción',        getVal('f_descripcion')],
            ['Solución esperada',  getVal('f_solucion')],
        ];

        document.getElementById('resumenTabla').innerHTML = rows.map(([k, v]) =>
            `<tr><td class="text-muted fw-semibold">${k}</td><td>${v}</td></tr>`
        ).join('');
    }

    // ─── Envío real vía fetch (AJAX) ─────────────────────────────────────────
    function submitForm() {
        if (!document.getElementById('f_acepta').checked) {
            alert('Debe aceptar las políticas de privacidad para continuar.');
            return;
        }

        const btn = document.getElementById('btnEnviar');
        btn.textContent = 'Enviando...';
        btn.disabled = true;

        const form = document.getElementById('reclamoForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(async res => {
            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                throw err;
            }
            return res.json();
        })
        .then(data => {
            document.getElementById('botones-envio').classList.add('d-none');
            document.getElementById('resumen-container').classList.add('d-none');
            const conf = document.getElementById('confirmacion-exitosa');
            conf.classList.remove('d-none');
            // Mostrar número de registro si el controlador lo devuelve
            if (data.numero_registro) {
                conf.querySelector('p').innerHTML =
                    `Su número de registro es <strong>${data.numero_registro}</strong>. ` +
                    `Recibirá una respuesta en su correo en un máximo de <strong>15 días hábiles</strong>.`;
            }

            // Contador regresivo y redirección
            let segundos = 5;
            const countdown = document.createElement('p');
            countdown.className = 'text-muted mt-3';
            countdown.style.fontSize = '0.88rem';
            countdown.innerHTML = `Será redirigido al inicio en <strong>${segundos}</strong> segundos...`;
            conf.appendChild(countdown);

            const intervalo = setInterval(() => {
                segundos--;
                countdown.innerHTML = `Será redirigido al inicio en <strong>${segundos}</strong> segundos...`;
                if (segundos <= 0) {
                    clearInterval(intervalo);
                    window.location.href = '{{ route("ecommerce.index") }}'; // cambia por tu ruta
                }
            }, 1000);
        })
        .catch(err => {
            btn.textContent = 'Enviar reclamación';
            btn.disabled = false;

            // Si Laravel devuelve errores de validación (422)
            if (err.errors) {
                const mensajes = Object.values(err.errors).flat().join('\n');
                alert('Por favor corrija los siguientes errores:\n\n' + mensajes);
            } else {
                alert('Ocurrió un error al enviar. Intente nuevamente.');
            }
        });
    }
</script>
@endsection