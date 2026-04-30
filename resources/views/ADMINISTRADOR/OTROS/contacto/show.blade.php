<div class="modal fade" id="showprospecto{{ $admin_contacto->slug }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" style="max-width: min(1400px, 96vw);">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.12); max-height: 92vh;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, var(--bs-secondary) 0%, var(--bs-dark) 100%); border-radius: 16px 16px 0 0; border: none;">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-icon" 
                        style="width: 48px; 
                                height: 48px; 
                                background: rgba(251, 112, 0, 0.2); 
                                border-radius: 12px; 
                                display: flex; 
                                align-items: center; 
                                justify-content: center;">
                        <i class="bi bi-person-badge-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0" id="staticBackdropLabel">
                            {{ $admin_contacto->nombre }}
                            @if($admin_contacto->estado == 'Atendido')
                                <span class="badge bg-success ms-2" style="font-size: 0.7rem; vertical-align: middle;">
                                    <i class="bi bi-check-circle-fill me-1"></i>ATENDIDO
                                </span>
                            @else
                                <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7rem; vertical-align: middle;">
                                    <i class="bi bi-clock-fill me-1"></i>POR ATENDER
                                </span>
                            @endif
                        </h5>
                        <p class="text-white-50 small mb-0">Información del prospecto</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            @php
                $tiposContactoRaw = $admin_contacto->tipo_contacto;
                $tiposContacto = is_array($tiposContactoRaw)
                    ? $tiposContactoRaw
                    : explode(',', (string) $tiposContactoRaw);

                $tiposContactoNormalizados = collect($tiposContacto)
                    ->map(fn($tipo) => strtolower(trim((string) $tipo)))
                    ->filter()
                    ->values();

                $permiteWhatsapp = $tiposContactoNormalizados->contains('whatsapp');
                $permiteTelefono = $tiposContactoNormalizados->contains('phone')
                    || $tiposContactoNormalizados->contains('telefono')
                    || $tiposContactoNormalizados->contains('teléfono')
                    || $tiposContactoNormalizados->contains('celular');
                $permiteEmail = $tiposContactoNormalizados->contains('email')
                    || $tiposContactoNormalizados->contains('correo');

                $celularLimpio = preg_replace('/\D+/', '', (string) $admin_contacto->celular);
            @endphp

            <div class="modal-body bg-light" style="overflow-y: auto;">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <div class="card h-100 border-0" style="border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                            <div class="card-body p-3 p-lg-4">
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-person-badge text-primary fs-5"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 1rem; letter-spacing: 0.2px;">Datos del contacto</h6>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small mb-2 fw-semibold" style="color: var(--bs-primary);">
                                            <i class="bi bi-person-fill me-2"></i>Nombres
                                        </label>
                                        <div class="bg-body-tertiary p-3 rounded-3 border">
                                            <p class="mb-0 fw-semibold text-dark">{{ $admin_contacto->nombre.' '.$admin_contacto->apellido }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small mb-2 fw-semibold" style="color: var(--bs-danger);">
                                            <i class="bi bi-envelope-fill me-2"></i>Correo electrónico
                                        </label>
                                        <div class="bg-body-tertiary p-3 rounded-3 border">
                                            <p class="mb-0">
                                                <a href="mailto:{{ $admin_contacto->email }}" class="text-decoration-none fw-semibold" style="color: var(--bs-danger);">
                                                    <i class="bi bi-box-arrow-up-right me-1" style="font-size: 0.75rem;"></i>{{ $admin_contacto->email }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>

                                
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label small mb-2 fw-semibold" style="color: var(--bs-success);">
                                            <i class="bi bi-telephone-fill me-2"></i>Celular
                                        </label>
                                        <div class="bg-body-tertiary p-3 rounded-3 border">
                                            <p class="mb-0">
                                                <a href="tel:{{ $admin_contacto->telefono }}" class="text-decoration-none fw-semibold" style="color: var(--bs-success);">
                                                    <i class="bi bi-telephone-outbound me-1" style="font-size: 0.75rem;"></i>{{ $admin_contacto->telefono }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                 </div>


                                <div class="mb-3">
                                    <label class="form-label small mb-2 fw-semibold" style="color: var(--bs-info);">
                                        <i class="bi bi-chat-left-text-fill me-2"></i>Mensaje recibido
                                    </label>
                                    <div class="bg-body-tertiary p-3 rounded-3 border">
                                        <p class="mb-0 text-dark" style="line-height: 1.6;">{{ $admin_contacto->mensaje }}</p>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small mb-2 fw-semibold text-muted">
                                            <i class="bi bi-tag-fill me-1"></i>Tipo de proyecto
                                        </label>
                                        <div class="bg-body-tertiary p-3 rounded-3 border">
                                            <p class="mb-0 fw-semibold text-dark">{{ $admin_contacto->tipo_proyecto }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small mb-2 fw-semibold text-muted">
                                            <i class="bi bi-calendar-event-fill me-1"></i>Fecha de registro
                                        </label>
                                        <div class="bg-body-tertiary p-3 rounded-3 border">
                                            <p class="mb-1 fw-bold text-dark">{{ $admin_contacto->created_at->format('d/m/Y') }}</p>
                                            <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $admin_contacto->created_at->format('h:i A') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small mb-2 fw-semibold text-muted">
                                            <i class="bi bi-shield-check-fill me-1"></i>Aceptó términos
                                        </label>
                                        <div class="bg-body-tertiary p-3 rounded-3 border">
                                            @if($admin_contacto->acepto_terminos == '1')
                                                <span class="badge bg-success px-3 py-2">SÍ ACEPTÓ</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">NO ACEPTÓ</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card h-100 border-0" style="border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                            <div class="card-body p-3 p-lg-4">
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-reply-fill fs-5 text-info"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 1rem; letter-spacing: 0.2px;">Responder y gestionar</h6>
                                </div>

                                <form id="form-atender-{{ $admin_contacto->slug }}" method="POST" action="{{ route('admin-contacto.update', $admin_contacto->slug) }}">
                                    @csrf
                                    @method('put')

                                    @if($admin_contacto->estado == 'Atendido')
                                        <div class="alert alert-success mb-0 d-flex align-items-center" role="alert">
                                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                            <div>
                                                <strong>Contacto atendido</strong>
                                                <p class="mb-0 small">Este contacto ya fue marcado como atendido.</p>
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="canal_contacto_usado" id="canal_contacto_usado_{{ $admin_contacto->slug }}" value="">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold mb-2 text-dark">
                                                <i class="bi bi-chat-left-text-fill me-2"></i>Tu mensaje de respuesta
                                            </label>
                                            <textarea
                                                id="mensaje_respuesta_{{ $admin_contacto->slug }}"
                                                name="mensaje_respuesta"
                                                class="form-control"
                                                rows="7"
                                                placeholder="Escribe tu respuesta para enviarla por WhatsApp o Email"
                                                style="border-radius: 12px; border: 1px solid var(--bs-border-color);">{{ old('mensaje_respuesta') }}</textarea>
                                            <small class="text-muted d-block mt-2">
                                                Paso 1: redacta tu respuesta. Paso 2: envíala por un canal. Paso 3: marca el contacto como atendido.
                                            </small>
                                        </div>

                                        @if($permiteWhatsapp || $permiteTelefono || $permiteEmail)
                                            <div class="mb-3 p-3 rounded-3 border bg-body-tertiary">
                                                <div class="small fw-semibold mb-2 text-muted">Canales de comunicación</div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @if($permiteWhatsapp && !empty($celularLimpio))
                                                        <a
                                                            href="#"
                                                            id="btn-whatsapp-{{ $admin_contacto->slug }}"
                                                            data-celular="{{ $celularLimpio }}"
                                                            target="_bank"
                                                            rel="noopener noreferrer"
                                                            class="btn btn-success btn-sm rounded-pill px-3">
                                                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                                        </a>
                                                    @endif

                                                    @if($permiteTelefono && !empty($admin_contacto->celular))
                                                        <a href="tel:{{ $admin_contacto->celular }}" id="btn-telefono-{{ $admin_contacto->slug }}" target="_bank" rel="noopener noreferrer" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                                            <i class="bi bi-telephone-fill me-1"></i>Llamar
                                                        </a>
                                                    @endif

                                                    @if($permiteEmail && !empty($admin_contacto->correo))
                                                        <a
                                                            href="#"
                                                            id="btn-email-{{ $admin_contacto->slug }}"
                                                            data-correo="{{ $admin_contacto->correo }}"
                                                            target="_bank"
                                                            rel="noopener noreferrer"
                                                            class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                            <i class="bi bi-envelope-fill me-1"></i>Email
                                                        </a>
                                                    @endif
                                                </div>
                                                <div id="canal-seleccionado-wrap-{{ $admin_contacto->slug }}" class="mt-2 d-none">
                                                    <span class="small text-muted me-1">Canal seleccionado:</span>
                                                    <span id="canal-seleccionado-badge-{{ $admin_contacto->slug }}" class="badge"></span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-end">
                                            <button id="" type="submit" class="btn text-white px-4 py-2"  style="background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%); border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(251, 112, 0, 0.3); border: none;">
                                                <i class="bi bi-check-circle-fill me-2"></i>Marcar como atendido
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-2 text-end">Disponible cuando redactes un mensaje.</small>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(
    ($permiteWhatsapp && !empty($celularLimpio))
    || ($permiteEmail && !empty($admin_contacto->correo))
    || ($permiteTelefono && !empty($admin_contacto->celular))
)
    <script>
        (() => {
            const formAtender = document.getElementById('form-atender-{{ $admin_contacto->slug }}');
            const textarea = document.getElementById('mensaje_respuesta_{{ $admin_contacto->slug }}');
            const telefonoBtn = document.getElementById('btn-telefono-{{ $admin_contacto->slug }}');
            const whatsappBtn = document.getElementById('btn-whatsapp-{{ $admin_contacto->slug }}');
            const emailBtn = document.getElementById('btn-email-{{ $admin_contacto->slug }}');
            const canalInput = document.getElementById('canal_contacto_usado_{{ $admin_contacto->slug }}');
            const marcarAtendidoBtn = document.getElementById('btn-marcar-atendido-{{ $admin_contacto->slug }}');
            const canalSeleccionadoWrap = document.getElementById('canal-seleccionado-wrap-{{ $admin_contacto->slug }}');
            const canalSeleccionadoBadge = document.getElementById('canal-seleccionado-badge-{{ $admin_contacto->slug }}');
            const respuestacontact = document.getElementById('mensaje_respuesta_{{ $admin_contacto->slug }}');
            const actualizarEstadoBoton = () => {
                const tieneMensaje = ((textarea?.value || '').trim().length > 0);
                if (marcarAtendidoBtn) {
                    marcarAtendidoBtn.disabled = !tieneMensaje;
                }
            };

            const seleccionarCanal = (canal) => {
                if (canalInput) {
                    canalInput.value = canal;
                }

                if (canalSeleccionadoWrap && canalSeleccionadoBadge) {
                    // Mapear canal a etiqueta legible
                    const etiquetasCanal = {
                        'whatsapp': 'WhatsApp',
                        'email': 'Email',
                        'telefono': 'Teléfono'
                    };
                    const etiquetaCanal = etiquetasCanal[canal] || canal;

                    canalSeleccionadoBadge.textContent = etiquetaCanal;
                    canalSeleccionadoBadge.classList.remove('text-bg-success', 'text-bg-danger');
                    canalSeleccionadoBadge.classList.add((textarea?.value || '').trim().length > 0 ? 'text-bg-success' : 'text-bg-danger');
                    canalSeleccionadoWrap.classList.remove('d-none');
                }

                actualizarEstadoBoton();
            };

            const obtenerMensaje = () => {
                const mensaje = (textarea?.value || '').trim();
                if (!mensaje) {
                    alert('Escribe un mensaje de respuesta antes de continuar.');
                    textarea?.focus();
                    return null;
                }
                return mensaje;
            };

            if (whatsappBtn) {
                whatsappBtn.addEventListener('click', (event) => {
                    const mensaje = obtenerMensaje();
                    if (!mensaje) {
                        event.preventDefault();
                        return;
                    }

                    const celular = whatsappBtn.dataset.celular || '';
                    if (!celular) {
                        event.preventDefault();
                        return;
                    }

                    const url = `https://wa.me/${celular}?text=${encodeURIComponent(mensaje)}`;
                    whatsappBtn.href = url;
                    seleccionarCanal('whatsapp');
                });
            }

            if (emailBtn) {
                emailBtn.addEventListener('click', (event) => {
                    const mensaje = obtenerMensaje();
                    if (!mensaje) {
                        event.preventDefault();
                        return;
                    }

                    const correo = emailBtn.dataset.correo || '';
                    if (!correo) {
                        event.preventDefault();
                        return;
                    }

                    const asunto = encodeURIComponent('Respuesta a tu consulta - {{ $admin_contacto->nombre }}');
                    const cuerpo = encodeURIComponent(mensaje);
                    const url = `mailto:${correo}?subject=${asunto}&body=${cuerpo}`;
                    emailBtn.href = url;
                    seleccionarCanal('email');
                });
            }

            if (telefonoBtn) {
                telefonoBtn.addEventListener('click', () => {
                    seleccionarCanal('telefono');
                });
            }

            if (textarea) {
                textarea.addEventListener('input', actualizarEstadoBoton);
            }

            if (formAtender) {
                formAtender.addEventListener('submit', (event) => {
                    actualizarEstadoBoton();
                    if (marcarAtendidoBtn?.disabled) {
                        event.preventDefault();
                        alert('Para marcar como atendido, primero redacta un mensaje y usa un canal de contacto.');
                    }
                });
            }

            actualizarEstadoBoton();
        })();
    </script>
@endif
