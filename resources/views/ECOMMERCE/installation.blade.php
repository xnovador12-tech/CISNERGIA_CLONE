@extends('TEMPLATES.ecommerce')

@section('title', 'INSTALACIÓN')

@section('content')

{{-- ══ HERO ══ --}}
<section class="ip-hero" id="inicio">
  <div class="ip-hero__glow"></div>
  <div class="container position-relative">
    <div class="row align-items-center g-5">

      {{-- Texto --}}
      <div class="col-lg-6">
        <div class="ip-badge">
          <span class="ip-badge__dot"></span>
          Servicio de Instalación
        </div>

        <h1 class="ip-hero__title">
          Tu energía solar lista<br>
          en <span class="ip-hero__hl">7–15 días</span>
        </h1>

        <p class="ip-hero__lead">
          Un proceso simple, transparente y profesional. Desde la primera consulta hasta que generes tu propia energía limpia.
        </p>

        <div class="ip-hero__btns">
          <a href="#proceso" class="ip-btn ip-btn--solid">
            <i class="bi bi-play-circle-fill"></i> Ver proceso
          </a>
          <a href="#contacto" class="ip-btn ip-btn--outline">
            <i class="bi bi-calendar2-check"></i> Agendar evaluación
          </a>
        </div>

        <div class="ip-hero__stats">
          <div class="ip-stat">
            <div class="ip-stat__num">500<sup>+</sup></div>
            <div class="ip-stat__lbl">Instalaciones</div>
          </div>
          <div class="ip-stat__sep"></div>
          <div class="ip-stat">
            <div class="ip-stat__num">100<sup>%</sup></div>
            <div class="ip-stat__lbl">Satisfacción</div>
          </div>
          <div class="ip-stat__sep"></div>
          <div class="ip-stat">
            <div class="ip-stat__num">10</div>
            <div class="ip-stat__lbl">Años de exp.</div>
          </div>
        </div>
      </div>

      {{-- Imagen --}}
      <div class="col-lg-6">
        <div class="ip-hero__media">
          <img src="https://images.pexels.com/photos/9875415/pexels-photo-9875415.jpeg?auto=compress&cs=tinysrgb&w=1200"
               alt="Instalación profesional de paneles solares">

          <div class="ip-hero__chip ip-hero__chip--tr">
            <i class="bi bi-lightning-charge-fill ip-hero__chip-icon"></i>
            <div>
              <div class="ip-hero__chip-val">Rápido</div>
              <div class="ip-hero__chip-sub">7–15 días</div>
            </div>
          </div>

          <div class="ip-hero__chip ip-hero__chip--bl">
            <i class="bi bi-check-circle-fill ip-hero__chip-icon ip-hero__chip-icon--green"></i>
            <div>
              <div class="ip-hero__chip-val">Sin complicaciones</div>
              <div class="ip-hero__chip-sub">Permisos, instalación y conexión incluidos</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ TRUST BAR ══ --}}
<div class="ip-trust">
  <div class="container">
    <div class="ip-trust__row">
      <div class="ip-trust__item">
        <div class="ip-trust__icon"><i class="bi bi-shield-check"></i></div>
        <span>Garantía 5 años</span>
      </div>
      <div class="ip-trust__div"></div>
      <div class="ip-trust__item">
        <div class="ip-trust__icon"><i class="bi bi-cash-coin"></i></div>
        <span>Precio transparente</span>
      </div>
      <div class="ip-trust__div"></div>
      <div class="ip-trust__item">
        <div class="ip-trust__icon"><i class="bi bi-person-check"></i></div>
        <span>Técnicos certificados</span>
      </div>
      <div class="ip-trust__div"></div>
      <div class="ip-trust__item">
        <div class="ip-trust__icon"><i class="bi bi-headset"></i></div>
        <span>Soporte 24/7</span>
      </div>
    </div>
  </div>
</div>

{{-- ══ PROCESO ══ --}}
<section class="ip-section" id="proceso">
  <div class="container">

    <div class="ip-section__hd text-center">
      <div class="ip-chip"><i class="bi bi-diagram-3-fill"></i>&nbsp;Proceso</div>
      <h2 class="ip-section__title">Tu camino hacia la energía solar</h2>
      <p class="ip-section__sub">7 pasos simples y transparentes, de principio a fin</p>
    </div>

    <div class="ip-steps">

      {{-- Paso 1 --}}
      <div class="ip-step">
        <div class="ip-step__top">
          <span class="ip-step__n">01</span>
          <span class="ip-step__day">Día 1</span>
        </div>
        <div class="ip-step__icon"><i class="bi bi-chat-dots-fill"></i></div>
        <h5 class="ip-step__title">Contacto Inicial</h5>
        <p class="ip-step__body">Un asesor experto te atiende por teléfono, WhatsApp o web para entender tus necesidades energéticas.</p>
        <ul class="ip-step__list">
          <li>Respuesta en menos de 2 horas</li>
          <li>Asesoría personalizada gratuita</li>
          <li>Sin compromiso</li>
        </ul>
      </div>

      {{-- Paso 2 --}}
      <div class="ip-step">
        <div class="ip-step__top">
          <span class="ip-step__n">02</span>
          <span class="ip-step__day">Días 2–3</span>
        </div>
        <div class="ip-step__icon"><i class="bi bi-clipboard-check-fill"></i></div>
        <h5 class="ip-step__title">Evaluación Técnica</h5>
        <p class="ip-step__body">Un ingeniero certificado visita tu propiedad para evaluar el techo y analizar tu consumo eléctrico.</p>
        <ul class="ip-step__list">
          <li>Análisis estructural del techo</li>
          <li>Estudio de sombreado solar</li>
          <li>100% gratuito</li>
        </ul>
      </div>

      {{-- Paso 3 --}}
      <div class="ip-step">
        <div class="ip-step__top">
          <span class="ip-step__n">03</span>
          <span class="ip-step__day">Día 4</span>
        </div>
        <div class="ip-step__icon"><i class="bi bi-file-earmark-text-fill"></i></div>
        <h5 class="ip-step__title">Propuesta y Diseño</h5>
        <p class="ip-step__body">Diseño 3D personalizado con proyección de ahorro a 25 años y opciones de financiamiento.</p>
        <ul class="ip-step__list">
          <li>Diseño 3D personalizado</li>
          <li>Simulación de ahorro 25 años</li>
          <li>Opciones de pago flexibles</li>
        </ul>
      </div>

      {{-- Paso 4 --}}
      <div class="ip-step">
        <div class="ip-step__top">
          <span class="ip-step__n">04</span>
          <span class="ip-step__day">Días 5–7</span>
        </div>
        <div class="ip-step__icon"><i class="bi bi-file-earmark-check-fill"></i></div>
        <h5 class="ip-step__title">Gestión de Permisos</h5>
        <p class="ip-step__body">Nos encargamos de todos los trámites: permisos municipales y autorización de la distribuidora.</p>
        <ul class="ip-step__list">
          <li>Permisos municipales</li>
          <li>Autorización distribuidora</li>
          <li>Tú no haces nada</li>
        </ul>
      </div>

      {{-- Paso 5 --}}
      <div class="ip-step">
        <div class="ip-step__top">
          <span class="ip-step__n">05</span>
          <span class="ip-step__day">Días 8–12</span>
        </div>
        <div class="ip-step__icon"><i class="bi bi-tools"></i></div>
        <h5 class="ip-step__title">Instalación Profesional</h5>
        <p class="ip-step__body">Equipo certificado instala estructura, paneles, inversor y cableado con máximas medidas de seguridad.</p>
        <ul class="ip-step__list">
          <li>Equipo certificado ISO 9001</li>
          <li>Materiales de primera calidad</li>
          <li>Limpieza total al finalizar</li>
        </ul>
      </div>

      {{-- Paso 6 --}}
      <div class="ip-step">
        <div class="ip-step__top">
          <span class="ip-step__n">06</span>
          <span class="ip-step__day">Días 13–14</span>
        </div>
        <div class="ip-step__icon"><i class="bi bi-plug-fill"></i></div>
        <h5 class="ip-step__title">Inspección y Conexión</h5>
        <p class="ip-step__body">Pruebas finales y coordinación con la distribuidora para conectar el sistema a la red eléctrica.</p>
        <ul class="ip-step__list">
          <li>Inspección de seguridad</li>
          <li>Medidor bidireccional</li>
          <li>Activación del sistema</li>
        </ul>
      </div>

      {{-- Paso 7 --}}
      <div class="ip-step ip-step--accent">
        <div class="ip-step__top">
          <span class="ip-step__n ip-step__n--green">07</span>
          <span class="ip-step__day">Día 15+</span>
        </div>
        <div class="ip-step__icon ip-step__icon--green"><i class="bi bi-mortarboard-fill"></i></div>
        <h5 class="ip-step__title">Capacitación y Soporte</h5>
        <p class="ip-step__body">Instalamos la app de monitoreo, te capacitamos y activamos soporte 24/7. ¡Empiezas a ahorrar!</p>
        <ul class="ip-step__list">
          <li>Capacitación completa</li>
          <li>App de monitoreo WiFi</li>
          <li>Mantenimiento incluido</li>
        </ul>
      </div>

    </div>
  </div>
</section>

{{-- ══ POR QUÉ SOMOS DIFERENTES ══ --}}
<section class="ip-section ip-section--alt" id="beneficios">
  <div class="container">

    <div class="ip-section__hd text-center">
      <div class="ip-chip"><i class="bi bi-star-fill"></i>&nbsp;Diferenciadores</div>
      <h2 class="ip-section__title">¿Por qué nuestro servicio es diferente?</h2>
      <p class="ip-section__sub">Compromiso total con tu satisfacción, desde el día 1</p>
    </div>

    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="ip-card">
          <div class="ip-card__icon"><i class="bi bi-shield-check"></i></div>
          <h5 class="ip-card__title">Garantía Extendida</h5>
          <p class="ip-card__body">5 años en instalación y mano de obra. 25 años en paneles solares.</p>
          <div class="ip-card__metric">5 años</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="ip-card">
          <div class="ip-card__icon"><i class="bi bi-cash-coin"></i></div>
          <h5 class="ip-card__title">Precio Transparente</h5>
          <p class="ip-card__body">Sin costos ocultos. Todo incluido: materiales, instalación, permisos y capacitación.</p>
          <div class="ip-card__metric">0 sorpresas</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="ip-card">
          <div class="ip-card__icon"><i class="bi bi-lightning-charge-fill"></i></div>
          <h5 class="ip-card__title">Instalación Rápida</h5>
          <p class="ip-card__body">Completamos proyectos residenciales en 15 días sin interrumpir tu rutina.</p>
          <div class="ip-card__metric">15 días</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="ip-card">
          <div class="ip-card__icon"><i class="bi bi-headset"></i></div>
          <h5 class="ip-card__title">Soporte 24/7</h5>
          <p class="ip-card__body">Asistencia permanente, monitoreo remoto y mantenimiento preventivo incluido.</p>
          <div class="ip-card__metric">24/7</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ COMPARACIÓN ══ --}}
<section class="ip-section" id="comparacion">
  <div class="container">

    <div class="ip-section__hd text-center">
      <div class="ip-chip"><i class="bi bi-arrow-left-right"></i>&nbsp;Comparación</div>
      <h2 class="ip-section__title">Antes y Después</h2>
      <p class="ip-section__sub">El cambio real que experimentarás en tu hogar</p>
    </div>

    <div class="ip-compare">
      <div class="ip-compare__row">
        <div class="ip-compare__cell ip-compare__cell--bad"><i class="bi bi-x-circle-fill me-2"></i>Sin Paneles Solares</div>
        <div class="ip-compare__cell ip-compare__cell--good"><i class="bi bi-check-circle-fill me-2"></i>Con Paneles Solares</div>
      </div>
      <div class="ip-compare__row">
        <div class="ip-compare__cell">
          <i class="bi bi-x-circle ip-compare__ico ip-compare__ico--bad"></i>
          <div><strong>Recibos de luz altos</strong><span>S/300–500 o más al mes</span></div>
        </div>
        <div class="ip-compare__cell">
          <i class="bi bi-check-circle ip-compare__ico ip-compare__ico--good"></i>
          <div><strong>Ahorro del 60–90%</strong><span>Solo S/30–100 mensuales</span></div>
        </div>
      </div>
      <div class="ip-compare__row">
        <div class="ip-compare__cell">
          <i class="bi bi-x-circle ip-compare__ico ip-compare__ico--bad"></i>
          <div><strong>Dependencia de la red</strong><span>Vulnerable a cortes y tarifas crecientes</span></div>
        </div>
        <div class="ip-compare__cell">
          <i class="bi bi-check-circle ip-compare__ico ip-compare__ico--good"></i>
          <div><strong>Independencia energética</strong><span>Genera tu propia electricidad limpia</span></div>
        </div>
      </div>
      <div class="ip-compare__row">
        <div class="ip-compare__cell">
          <i class="bi bi-x-circle ip-compare__ico ip-compare__ico--bad"></i>
          <div><strong>Huella de carbono alta</strong><span>Energía de combustibles fósiles</span></div>
        </div>
        <div class="ip-compare__cell">
          <i class="bi bi-check-circle ip-compare__ico ip-compare__ico--good"></i>
          <div><strong>Energía 100% renovable</strong><span>Reduce 4 toneladas de CO₂ al año</span></div>
        </div>
      </div>
      <div class="ip-compare__row">
        <div class="ip-compare__cell">
          <i class="bi bi-x-circle ip-compare__ico ip-compare__ico--bad"></i>
          <div><strong>Sin control de gastos</strong><span>Precios determinados por terceros</span></div>
        </div>
        <div class="ip-compare__cell">
          <i class="bi bi-check-circle ip-compare__ico ip-compare__ico--good"></i>
          <div><strong>Monitoreo en tiempo real</strong><span>Control total de tu producción</span></div>
        </div>
      </div>
      <div class="ip-compare__row">
        <div class="ip-compare__cell">
          <i class="bi bi-x-circle ip-compare__ico ip-compare__ico--bad"></i>
          <div><strong>Pérdida de valor inmobiliario</strong><span>Propiedad menos competitiva</span></div>
        </div>
        <div class="ip-compare__cell">
          <i class="bi bi-check-circle ip-compare__ico ip-compare__ico--good"></i>
          <div><strong>Mayor valor de propiedad</strong><span>+15–20% en valuación</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ CTA FINAL ══ --}}
<section class="ip-cta" id="contacto">
  <div class="ip-cta__glow-1"></div>
  <div class="ip-cta__glow-2"></div>
  <div class="container position-relative">

    <div class="text-center mb-5">
      <p class="ip-cta__eyebrow">¿Tienes dudas?</p>
      <h2 class="ip-cta__title">¡Listo para tu transformación energética?</h2>
      <p class="ip-cta__sub">Obtén una cotización gratuita en menos de 24 horas, sin ningún compromiso.</p>
    </div>

    <div class="row g-3 justify-content-center mb-5">
      <div class="col-sm-6 col-lg-3">
        <div class="ip-contact-card">
          <div class="ip-contact-card__icon"><i class="bi bi-geo-alt-fill"></i></div>
          <div>
            <div class="ip-contact-card__lbl">Dirección</div>
            <div class="ip-contact-card__val">Av. Principal 123, San Isidro<br>Lima, Perú</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="ip-contact-card">
          <div class="ip-contact-card__icon"><i class="bi bi-telephone-fill"></i></div>
          <div>
            <div class="ip-contact-card__lbl">Teléfono</div>
            <div class="ip-contact-card__val">+51 999 999 999<br>+51 (01) 234-5678</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="ip-contact-card">
          <div class="ip-contact-card__icon"><i class="bi bi-envelope-fill"></i></div>
          <div>
            <div class="ip-contact-card__lbl">Email</div>
            <div class="ip-contact-card__val">ventas@cisnergia.pe<br>soporte@cisnergia.pe</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="ip-contact-card">
          <div class="ip-contact-card__icon ip-contact-card__icon--green"><i class="bi bi-clock-fill"></i></div>
          <div>
            <div class="ip-contact-card__lbl">Horario</div>
            <div class="ip-contact-card__val">Lun–Vie: 9 AM – 6 PM<br>Sáb: 9 AM – 1 PM</div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="{{ route('ecommerce.contact') }}" class="ip-cta__btn ip-cta__btn--light">
        <i class="bi bi-envelope-fill me-2"></i>Ir al formulario de contacto
      </a>
      <a href="tel:+51999999999" class="ip-cta__btn ip-cta__btn--ghost">
        <i class="bi bi-telephone-fill me-2"></i>Llamar ahora
      </a>
    </div>

  </div>
</section>

@endsection

@section('js')
@endsection
