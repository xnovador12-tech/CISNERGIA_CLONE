@extends('TEMPLATES.ecommerce')

@section('title', 'CONTACTO')

@section('content')
<!-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ -->
<section class="cp-hero" id="contacto">
  <div class="cp-hero__accent"></div>
  <div class="container position-relative py-5">
    <div class="row align-items-center g-5">

      <!-- ── Col. izquierda: texto + quick cards + stats ── -->
      <div class="col-lg-6">
        <div class="cp-badge">
          <span class="cp-badge__dot"></span> Estamos aquí para ayudarte
        </div>
        <h1 class="cp-title">
          Contacta con<br><span class="cp-title__hl">Nuestros Expertos</span>
        </h1>
        <p class="cp-lead">
          ¿Tienes dudas sobre paneles solares?
          <strong>Agenda una consulta gratuita</strong>
          con nuestros especialistas certificados.
        </p>

        <!-- Quick cards -->
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <a href="tel:+51999999999" class="cp-quick-card">
              <div class="cp-quick-card__icon cp-quick-card__icon--phone">
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div>
                <span class="cp-quick-card__lbl">Llámanos ahora</span>
                <span class="cp-quick-card__val">+51 999 999 999</span>
              </div>
            </a>
          </div>
          <div class="col-md-6">
            <a href="https://wa.me/51999999999" target="_blank" class="cp-quick-card">
              <div class="cp-quick-card__icon cp-quick-card__icon--wa">
                <i class="bi bi-whatsapp"></i>
              </div>
              <div>
                <span class="cp-quick-card__lbl">WhatsApp</span>
                <span class="cp-quick-card__val">Chat en vivo</span>
              </div>
            </a>
          </div>
        </div>

        <!-- Stats strip -->
        <div class="cp-stats">
          <div class="row g-3">
            <div class="col-4 text-center">
              <div class="cp-stat__num">9–18h</div>
              <div class="cp-stat__lbl">Horario</div>
            </div>
            <div class="col-4 text-center">
              <div class="cp-stat__num">&lt; 2h</div>
              <div class="cp-stat__lbl">Respuesta</div>
            </div>
            <div class="col-4 text-center">
              <div class="cp-stat__num">4.9★</div>
              <div class="cp-stat__lbl">Valoración</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── Col. derecha: formulario ── -->
      <div class="col-lg-6">
        <div class="cp-form-card">
          <div class="cp-form-head">
            <div class="cp-form-head__icon">
              <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <div>
              <p class="cp-form-head__title">Solicita tu Cotización Gratuita</p>
              <p class="cp-form-head__sub">Sin compromiso · Respuesta en 24 h</p>
            </div>
          </div>
          <div class="cp-form-body">
            <form>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="cp-label">Nombre <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Juan" required>
                </div>
                <div class="col-md-6">
                  <label class="cp-label">Apellido <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Pérez" required>
                </div>
                <div class="col-md-6">
                  <label class="cp-label">Teléfono <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control" placeholder="+51 999 999 999" required>
                </div>
                <div class="col-md-6">
                  <label class="cp-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" placeholder="tu@email.com" required>
                </div>
                <div class="col-md-6">
                  <label class="cp-label">Departamento</label>
                  <select class="form-select">
                    <option selected>Seleccionar...</option>
                    <option>Lima</option>
                    <option>Arequipa</option>
                    <option>Cusco</option>
                    <option>Trujillo</option>
                    <option>Piura</option>
                    <option>Chiclayo</option>
                    <option>Otro</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="cp-label">Tipo de proyecto</label>
                  <select class="form-select">
                    <option selected>Seleccionar...</option>
                    <option>Residencial (Casa/Depto)</option>
                    <option>Comercial (Oficina/Tienda)</option>
                    <option>Industrial (Fábrica)</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="cp-label">Consumo mensual aproximado (S/)</label>
                  <input type="number" class="form-control" placeholder="Ej: 350">
                  <small class="text-muted">Revisa tu último recibo de luz</small>
                </div>
                <div class="col-12">
                  <label class="cp-label">Mensaje (opcional)</label>
                  <textarea class="form-control" rows="2" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                </div>
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terminos" required>
                    <label class="form-check-label small text-muted" for="terminos">
                      Acepto la <a href="#" class="cp-link">política de privacidad</a> y el tratamiento de mis datos.
                    </label>
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="cp-submit-btn">
                    <i class="bi bi-send-fill me-2"></i>Enviar Solicitud
                  </button>
                  <p class="text-center text-muted small mt-3 mb-0">
                    <i class="bi bi-shield-check me-1" style="color:var(--cp-success);"></i>Respuesta garantizada en menos de 24 horas
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     CANALES DE CONTACTO
════════════════════════════════════════ -->
<section class="py-5" style="background: var(--cp-light);">
  <div class="container">
    <div class="text-center mb-5">
      <p class="cp-eyebrow">Canales disponibles</p>
      <h2 class="cp-section-title">Múltiples Formas de Contactarnos</h2>
      <p class="cp-section-sub">Elige el canal que más te convenga</p>
    </div>

    <div class="row g-4">
      <!-- Teléfono -->
      <div class="col-lg-3 col-md-6">
        <div class="cp-channel">
          <div class="cp-channel__icon cp-channel__icon--primary">
            <i class="bi bi-telephone-fill"></i>
          </div>
          <h5 class="cp-channel__title">Teléfono</h5>
          <p class="cp-channel__info">Lun-Vie: 9AM–6PM<br>Sáb: 9AM–1PM</p>
          <a href="tel:+51999999999" class="cp-channel__btn cp-channel__btn--solid">
            <i class="bi bi-telephone"></i>+51 999 999 999
          </a>
        </div>
      </div>

      <!-- WhatsApp -->
      <div class="col-lg-3 col-md-6">
        <div class="cp-channel">
          <div class="cp-channel__icon cp-channel__icon--success">
            <i class="bi bi-whatsapp"></i>
          </div>
          <h5 class="cp-channel__title">WhatsApp</h5>
          <p class="cp-channel__info">Respuesta inmediata<br>24/7 disponible</p>
          <a href="https://wa.me/51999999999" target="_blank" class="cp-channel__btn cp-channel__btn--outline">
            <i class="bi bi-whatsapp"></i>Chatear ahora
          </a>
        </div>
      </div>

      <!-- Email -->
      <div class="col-lg-3 col-md-6">
        <div class="cp-channel">
          <div class="cp-channel__icon cp-channel__icon--mid">
            <i class="bi bi-envelope-fill"></i>
          </div>
          <h5 class="cp-channel__title">Email</h5>
          <p class="cp-channel__info">Respuesta en 24 h<br>Consultas detalladas</p>
          <a href="mailto:ventas@cisnergia.pe" class="cp-channel__btn cp-channel__btn--outline">
            <i class="bi bi-envelope"></i>Enviar email
          </a>
        </div>
      </div>

      <!-- Oficina -->
      <div class="col-lg-3 col-md-6">
        <div class="cp-channel">
          <div class="cp-channel__icon cp-channel__icon--warning">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
          <h5 class="cp-channel__title">Oficina</h5>
          <p class="cp-channel__info">Visítanos<br>Cita previa</p>
          <button class="cp-channel__btn cp-channel__btn--outline" data-bs-toggle="modal" data-bs-target="#mapaModal">
            <i class="bi bi-map"></i>Ver ubicación
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     PREGUNTAS FRECUENTES
════════════════════════════════════════ -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-start g-5">
      <!-- Encabezado pegajoso -->
      <div class="col-lg-4">
        <div class="sticky-top" style="top:90px;">
          <p class="cp-eyebrow">FAQ</p>
          <h2 class="cp-section-title">Preguntas Frecuentes</h2>
          <p class="cp-section-sub mb-4">Resuelve tus dudas antes de contactarnos. Si no encuentras tu respuesta, escríbenos.</p>
          <a href="#contacto" class="cp-channel__btn cp-channel__btn--solid">
            <i class="bi bi-chat-dots me-1"></i>Pregúntanos
          </a>
        </div>
      </div>

      <!-- Acordeón -->
      <div class="col-lg-8">
        <div class="accordion cp-accordion" id="faqAccordion">

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                ¿Cuánto tiempo tarda la cotización?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Recibirás una cotización preliminar en menos de <strong>24 horas</strong>. Para una cotización detallada con visita técnica gratuita, coordinamos contigo en 48–72 horas. Sin ningún compromiso.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                ¿La evaluación técnica tiene costo?
              </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <strong>No</strong>, la evaluación técnica es completamente gratuita y sin compromiso. Nuestros ingenieros visitarán tu propiedad y diseñarán una propuesta personalizada sin costo alguno.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                ¿Ofrecen financiamiento?
              </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                <strong>Sí</strong>, trabajamos con diversas entidades financieras. Puedes financiar tu sistema solar con cuotas desde 12 hasta 60 meses. Consúltanos por las opciones disponibles.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                ¿Dan servicio en todo el Perú?
              </button>
            </h2>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Sí, ofrecemos instalación en todo el territorio peruano: Lima, Arequipa, Cusco, Trujillo, Piura, Chiclayo y principales ciudades. Contáctanos para confirmar cobertura en tu zona.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                ¿Qué incluye el servicio de instalación?
              </button>
            </h2>
            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Evaluación técnica, diseño del sistema, gestión de permisos, instalación completa, conexión a red eléctrica, capacitación, app de monitoreo y garantía de 5 años. Todo llave en mano.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     OFICINA Y MAPA
════════════════════════════════════════ -->
<section class="py-5" style="background: var(--cp-light);">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5">
        <p class="cp-eyebrow">Encuéntranos</p>
        <h2 class="cp-section-title">Visita Nuestra Oficina</h2>
        <p class="cp-section-sub mb-4">
          Te esperamos para mostrarte productos en funcionamiento y resolver todas tus dudas en persona.
        </p>

        <div class="cp-office-item">
          <div class="cp-office-item__icon cp-office-item__icon--primary">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
          <div>
            <p class="cp-office-item__title">Dirección</p>
            <p class="cp-office-item__body">Av. Principal 123, Oficina 501<br>San Isidro, Lima 15047</p>
          </div>
        </div>

        <div class="cp-office-item">
          <div class="cp-office-item__icon cp-office-item__icon--green">
            <i class="bi bi-clock-fill"></i>
          </div>
          <div>
            <p class="cp-office-item__title">Horario de Atención</p>
            <p class="cp-office-item__body">
              Lunes a Viernes: 9:00 AM – 6:00 PM<br>
              Sábados: 9:00 AM – 1:00 PM<br>
              Domingos: Cerrado
            </p>
          </div>
        </div>

        <div class="cp-office-item">
          <div class="cp-office-item__icon cp-office-item__icon--blue">
            <i class="bi bi-info-circle-fill"></i>
          </div>
          <div>
            <p class="cp-office-item__title">Nota</p>
            <p class="cp-office-item__body">Se recomienda agendar cita previa para una mejor atención.</p>
          </div>
        </div>

        <a href="https://maps.google.com" target="_blank" class="cp-channel__btn cp-channel__btn--solid mt-2">
          <i class="bi bi-map me-1"></i>Abrir en Google Maps
        </a>
      </div>

      <div class="col-lg-7">
        <div class="cp-map-wrap">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.3154584480846!2d-77.03674668515497!3d-12.095868791446845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b6b8b6b8b7%3A0x1234567890abcdef!2sSan%20Isidro%2C%20Lima!5e0!3m2!1ses!2spe!4v1234567890123!5m2!1ses!2spe"
            width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     CTA FINAL
════════════════════════════════════════ -->
<section class="cp-cta">
  <div class="cp-cta__glow-1"></div>
  <div class="cp-cta__glow-2"></div>
  <div class="container position-relative text-center py-3">
    <p class="cp-cta__eyebrow">¿Todo listo?</p>
    <h2 class="cp-cta__title">¿Listo para tu Proyecto Solar?</h2>
    <p class="cp-cta__sub mb-5 mx-auto">
      Contáctanos hoy y recibe una cotización personalizada gratuita, sin ningún compromiso.
    </p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a href="#contacto" class="cp-cta__btn cp-cta__btn--light">
        <i class="bi bi-send-fill me-2"></i>Solicitar Cotización
      </a>
      <a href="https://wa.me/51999999999" target="_blank" class="cp-cta__btn cp-cta__btn--ghost">
        <i class="bi bi-whatsapp me-2"></i>WhatsApp
      </a>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     MODAL MAPA
════════════════════════════════════════ -->
<div class="modal fade" id="mapaModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 overflow-hidden">
      <div class="modal-header border-0" style="background:var(--cp);">
        <h5 class="modal-title fw-bold text-white">
          <i class="bi bi-geo-alt-fill me-2"></i>Nuestra Ubicación
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.3154584480846!2d-77.03674668515497!3d-12.095868791446845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8b6b8b6b8b7%3A0x1234567890abcdef!2sSan%20Isidro%2C%20Lima!5e0!3m2!1ses!2spe!4v1234567890123!5m2!1ses!2spe"
          width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
      </div>
      <div class="modal-footer border-0">
        <a href="https://maps.google.com" target="_blank" class="btn btn-primary rounded-pill px-4">
          <i class="bi bi-map me-2"></i>Abrir en Google Maps
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
@endsection