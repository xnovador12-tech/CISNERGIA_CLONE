@extends('TEMPLATES.ecommerce')

@section('title', 'INSTALACIÓN')

@section('css')
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
    
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    .timeline-step {
      animation: fadeInUp 0.6s ease-out;
      animation-fill-mode: both;
    }
    
    .timeline-step:nth-child(1) { animation-delay: 0.1s; }
    .timeline-step:nth-child(2) { animation-delay: 0.2s; }
    .timeline-step:nth-child(3) { animation-delay: 0.3s; }
    .timeline-step:nth-child(4) { animation-delay: 0.4s; }
    .timeline-step:nth-child(5) { animation-delay: 0.5s; }
    .timeline-step:nth-child(6) { animation-delay: 0.6s; }
    .timeline-step:nth-child(7) { animation-delay: 0.7s; }
    
    .hero-float {
      animation: float 6s ease-in-out infinite;
    }
    
    .benefit-card {
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }
    
    .benefit-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s;
    }
    
    .benefit-card:hover::before {
      left: 100%;
    }
    
    .benefit-card:hover {
      transform: translateY(-15px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
    }
    
    .timeline-icon {
      position: relative;
      transition: all 0.3s ease;
    }
    
    .timeline-icon::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      transition: all 0.4s ease;
    }
    
    .timeline-icon:hover::after {
      width: 120%;
      height: 120%;
    }
    
    .timeline-icon:hover {
      transform: rotate(360deg) scale(1.1);
    }
    
    .card-image-wrapper {
      position: relative;
      overflow: hidden;
    }
    
    .card-image-wrapper img {
      transition: transform 0.6s ease;
    }
    
    .card-image-wrapper:hover img {
      transform: scale(1.15);
    }
    
    .card-image-wrapper::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(0,102,204,0.8), rgba(0,77,153,0.8));
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    
    .card-image-wrapper:hover::after {
      opacity: 0.7;
    }
    
    .gradient-text {
      background: linear-gradient(135deg, #0066cc, #00d4ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .glass-effect {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .floating-badge {
      animation: float 4s ease-in-out infinite;
    }
    
    .pulse-glow {
      animation: pulse 2s ease-in-out infinite;
      box-shadow: 0 0 0 0 rgba(0, 102, 204, 0.7);
    }
    
    @keyframes glowPulse {
      0%, 100% {
        box-shadow: 0 0 20px rgba(0, 102, 204, 0.5);
      }
      50% {
        box-shadow: 0 0 40px rgba(0, 102, 204, 0.8), 0 0 60px rgba(0, 102, 204, 0.6);
      }
    }
    
    .glow-on-hover {
      transition: all 0.3s ease;
    }
    
    .glow-on-hover:hover {
      animation: glowPulse 1.5s ease-in-out infinite;
    }
    
    .timeline-line {
      background: linear-gradient(180deg, #0066cc 0%, #00d4ff 50%, #0066cc 100%);
      animation: pulse 3s ease-in-out infinite;
    }
    
    .comparison-card {
      transition: all 0.3s ease;
    }
    
    .comparison-card:hover {
      transform: scale(1.02);
    }
    
    .hero-bg-animated {
      position: relative;
      overflow: hidden;
    }
    
    .hero-bg-animated::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    
    .stat-number {
      position: relative;
      display: inline-block;
    }
    
    .stat-number::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, transparent, #fff, transparent);
      animation: shimmer 2s ease-in-out infinite;
    }
    
    @keyframes shimmer {
      0%, 100% { opacity: 0; transform: translateX(-100%); }
      50% { opacity: 1; transform: translateX(100%); }
    }
    
    .step-badge {
      position: relative;
      display: inline-block;
    }
    
    .step-badge::before {
      content: '';
      position: absolute;
      top: -5px;
      left: -5px;
      right: -5px;
      bottom: -5px;
      background: inherit;
      border-radius: inherit;
      filter: blur(10px);
      opacity: 0.5;
      z-index: -1;
    }
  </style>
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="hero-section" id="inicio">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="badge bg-success bg-opacity-10 text-success border border-success mb-3 px-3 py-2">
          <i class="bi bi-tools"></i> Servicio de Instalación Profesional
        </div>
        <h1 class="hero-title mb-4 fw-bold display-4">¿Cómo funciona nuestro servicio de <span class="text-primary">instalación solar?</span></h1>
        <p class="mb-4 text-muted fs-5 lh-lg">
          Un proceso <strong class="text-success">simple, transparente y profesional</strong> de principio a fin. Desde la primera consulta hasta que generes tu propia energía limpia en solo 7-15 días.
        </p>
        <div class="d-flex flex-wrap gap-3 mb-4">
          <a href="#proceso" class="btn btn-primary btn-lg px-4 py-3">
            <i class="bi bi-play-circle-fill me-2"></i> Ver proceso completo
          </a>
          <a href="#contacto" class="btn btn-outline-primary btn-lg px-4 py-3">
            <i class="bi bi-calendar-check me-2"></i> Agendar evaluación
          </a>
        </div>
        
        <!-- Beneficios destacados -->
        <div class="row g-3 mt-4">
          <div class="col-sm-4">
            <div class="d-flex align-items-center">
              <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
              </div>
              <div>
                <small class="text-muted d-block">Evaluación</small>
                <strong class="small">100% Gratuita</strong>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                <i class="bi bi-shield-check text-primary fs-5"></i>
              </div>
              <div>
                <small class="text-muted d-block">Garantía</small>
                <strong class="small">5 años</strong>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="d-flex align-items-center">
              <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2">
                <i class="bi bi-clock-history text-info fs-5"></i>
              </div>
              <div>
                <small class="text-muted d-block">Instalación</small>
                <strong class="small">7-15 días</strong>
              </div>
            </div>
          </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row g-3 mt-4 pt-4 border-top">
          <div class="col-4">
            <h3 class="text-primary mb-0 fw-bold">500+</h3>
            <small class="text-muted">Instalaciones</small>
          </div>
          <div class="col-4">
            <h3 class="text-success mb-0 fw-bold">100%</h3>
            <small class="text-muted">Satisfacción</small>
          </div>
          <div class="col-4">
            <h3 class="text-warning mb-0 fw-bold">10 años</h3>
            <small class="text-muted">Experiencia</small>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="position-relative">
          <!-- Imagen principal con overlay -->
          <div class="rounded-4 overflow-hidden shadow-lg position-relative hero-image-container" style="height: 600px;">
            <img src="https://images.pexels.com/photos/9875415/pexels-photo-9875415.jpeg?auto=compress&cs=tinysrgb&w=1200" 
                 class="w-100 h-100 object-fit-cover hero-main-image" 
                 alt="Instalación de paneles solares">
            
            <!-- Badge flotante -->
            <div class="position-absolute top-0 end-0 m-4">
              <div class="bg-white rounded-3 shadow p-3 text-center" style="min-width: 120px;">
                <div class="text-primary mb-1">
                  <i class="bi bi-speedometer2 fs-3"></i>
                </div>
                <h4 class="mb-0 fw-bold text-success">Rápido</h4>
                <small class="text-muted">7-15 días</small>
              </div>
            </div>

            <!-- Card flotante inferior -->
            <div class="position-absolute bottom-0 start-0 m-4">
              <div class="bg-white rounded-3 shadow-lg p-3" style="max-width: 280px;">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>
                  <strong class="small">Proceso sin complicaciones</strong>
                </div>
                <p class="small text-muted mb-0">
                  Nos encargamos de <strong class="text-primary">todo el proceso</strong>, desde permisos hasta conexión final.
                </p>
              </div>
            </div>
          </div>

          <!-- Decoración de fondo -->
          <div class="position-absolute top-0 end-0 translate-middle-y" style="z-index: -1; opacity: 0.1;">
            <i class="bi bi-tools" style="font-size: 300px; color: var(--bs-primary);"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- LÍNEA DE TIEMPO VISUAL DEL PROCESO -->
<section class="py-5 bg-light">
  <div class="container py-5">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 mb-3 step-badge" style="font-size: 1.1rem;">
        <i class="bi bi-diagram-3-fill me-2"></i>Proceso Completo
      </span>
      <h2 class="display-4 fw-bold mb-3">
        Tu Viaje hacia la <span class="gradient-text">Energía Solar</span>
      </h2>
      <p class="text-muted fs-5">7 pasos simples, transparentes y profesionales</p>
      
      <!-- Línea decorativa -->
      <div class="d-flex justify-content-center mt-4">
        <div style="width: 100px; height: 4px; background: linear-gradient(90deg, transparent, #0066cc, transparent); border-radius: 2px;"></div>
      </div>
    </div>

    <!-- Timeline -->
    <div class="position-relative">
      <!-- Línea vertical central (solo en desktop) -->
      <div class="d-none d-lg-block position-absolute start-50 translate-middle-x timeline-line" style="width: 4px; height: 100%; top: 0; border-radius: 2px;"></div>

      <!-- Paso 1: Contacto Inicial -->
      <div class="row mb-5 pb-4 timeline-step">
        <div class="col-lg-5 text-lg-end mb-3 mb-lg-0">
          <div class="pe-lg-5">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 step-badge">📅 Día 1</span>
            <h3 class="fw-bold mb-3">
              <span class="text-primary me-2">01.</span>Contacto Inicial
            </h3>
            <p class="text-muted mb-3">
              Nos contactas por teléfono, WhatsApp o web. Un asesor experto te atiende inmediatamente para entender tus necesidades energéticas.
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Respuesta en menos de 2 horas</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Asesoría personalizada gratuita</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Sin compromiso</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg timeline-icon" style="width: 90px; height: 90px; box-shadow: 0 10px 30px rgba(0, 102, 204, 0.4) !important;">
              <i class="bi bi-chat-dots-fill text-white fs-1"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="ps-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;">
              <div class="card-image-wrapper">
                <img src="https://images.pexels.com/photos/7688336/pexels-photo-7688336.jpeg?auto=compress&cs=tinysrgb&w=400" 
                     class="card-img-top" style="height: 220px; object-fit: cover;" alt="Contacto">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Paso 2: Evaluación Técnica -->
      <div class="row mb-5 pb-4 flex-lg-row-reverse">
        <div class="col-lg-5 text-lg-start mb-3 mb-lg-0">
          <div class="ps-lg-5">
            <span class="badge bg-success bg-opacity-10 text-success mb-2">Días 2-3</span>
            <h3 class="fw-bold mb-3">
              <span class="text-success me-2">02.</span>Evaluación Técnica Gratuita
            </h3>
            <p class="text-muted mb-3">
              Un ingeniero certificado visita tu propiedad para evaluar el techo, medir la radiación solar y analizar tu consumo eléctrico actual.
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Análisis estructural del techo</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Estudio de sombreado</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Medición de consumo</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>100% gratuito</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
              <i class="bi bi-clipboard-check-fill text-white fs-2"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="pe-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
              <img src="https://images.pexels.com/photos/5691504/pexels-photo-5691504.jpeg?auto=compress&cs=tinysrgb&w=400" 
                   class="card-img-top" style="height: 200px; object-fit: cover;" alt="Evaluación">
            </div>
          </div>
        </div>
      </div>

      <!-- Paso 3: Propuesta Personalizada -->
      <div class="row mb-5 pb-4">
        <div class="col-lg-5 text-lg-end mb-3 mb-lg-0">
          <div class="pe-lg-5">
            <span class="badge bg-warning bg-opacity-10 text-warning mb-2">Día 4</span>
            <h3 class="fw-bold mb-3">
              <span class="text-warning me-2">03.</span>Propuesta y Diseño
            </h3>
            <p class="text-muted mb-3">
              Recibe una propuesta detallada con diseño 3D del sistema, proyección de producción energética, ahorro estimado y opciones de financiamiento.
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Diseño 3D personalizado</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Simulación de ahorro 25 años</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Cotización transparente</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Opciones de pago flexibles</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
              <i class="bi bi-file-earmark-text-fill text-white fs-2"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="ps-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
              <img src="https://images.pexels.com/photos/3861958/pexels-photo-3861958.jpeg?auto=compress&cs=tinysrgb&w=400" 
                   class="card-img-top" style="height: 200px; object-fit: cover;" alt="Propuesta">
            </div>
          </div>
        </div>
      </div>

      <!-- Paso 4: Permisos y Trámites -->
      <div class="row mb-5 pb-4 flex-lg-row-reverse">
        <div class="col-lg-5 text-lg-start mb-3 mb-lg-0">
          <div class="ps-lg-5">
            <span class="badge bg-info bg-opacity-10 text-info mb-2">Días 5-7</span>
            <h3 class="fw-bold mb-3">
              <span class="text-info me-2">04.</span>Gestión de Permisos
            </h3>
            <p class="text-muted mb-3">
              Nos encargamos de todos los trámites administrativos: permisos municipales, autorización de la distribuidora eléctrica y registro ante OSINERGMIN.
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Permisos municipales</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Autorización distribuidora</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Registro OSINERGMIN</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Tú no haces nada</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
              <i class="bi bi-file-earmark-check-fill text-white fs-2"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="pe-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
              <img src="https://images.pexels.com/photos/5668772/pexels-photo-5668772.jpeg?auto=compress&cs=tinysrgb&w=400" 
                   class="card-img-top" style="height: 200px; object-fit: cover;" alt="Permisos">
            </div>
          </div>
        </div>
      </div>

      <!-- Paso 5: Instalación -->
      <div class="row mb-5 pb-4">
        <div class="col-lg-5 text-lg-end mb-3 mb-lg-0">
          <div class="pe-lg-5">
            <span class="badge bg-danger bg-opacity-10 text-danger mb-2">Días 8-12</span>
            <h3 class="fw-bold mb-3">
              <span class="text-danger me-2">05.</span>Instalación Profesional
            </h3>
            <p class="text-muted mb-3">
              Nuestro equipo certificado instala el sistema completo: estructura, paneles, inversor y cableado. Todo en 3-5 días hábiles con las máximas medidas de seguridad.
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Equipo certificado ISO 9001</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Materiales de primera calidad</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Seguridad garantizada</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Limpieza total al finalizar</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
              <i class="bi bi-tools text-white fs-2"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="ps-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
              <img src="https://images.pexels.com/photos/9875487/pexels-photo-9875487.jpeg?auto=compress&cs=tinysrgb&w=400" 
                   class="card-img-top" style="height: 200px; object-fit: cover;" alt="Instalación">
            </div>
          </div>
        </div>
      </div>

      <!-- Paso 6: Inspección y Conexión -->
      <div class="row mb-5 pb-4 flex-lg-row-reverse">
        <div class="col-lg-5 text-lg-start mb-3 mb-lg-0">
          <div class="ps-lg-5">
            <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">Días 13-14</span>
            <h3 class="fw-bold mb-3">
              <span class="text-secondary me-2">06.</span>Inspección y Conexión
            </h3>
            <p class="text-muted mb-3">
              Realizamos inspección final de calidad, pruebas de funcionamiento y coordinamos con la distribuidora para conectar tu sistema a la red eléctrica.
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Inspección de seguridad</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Pruebas de funcionamiento</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Instalación medidor bidireccional</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Activación del sistema</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
              <i class="bi bi-plug-fill text-white fs-2"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="pe-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
              <img src="https://images.pexels.com/photos/5691550/pexels-photo-5691550.jpeg?auto=compress&cs=tinysrgb&w=400" 
                   class="card-img-top" style="height: 200px; object-fit: cover;" alt="Conexión">
            </div>
          </div>
        </div>
      </div>

      <!-- Paso 7: Capacitación y Soporte -->
      <div class="row mb-4">
        <div class="col-lg-5 text-lg-end mb-3 mb-lg-0">
          <div class="pe-lg-5">
            <span class="badge bg-success bg-opacity-10 text-success mb-2">Día 15+</span>
            <h3 class="fw-bold mb-3">
              <span class="text-success me-2">07.</span>Capacitación y Soporte
            </h3>
            <p class="text-muted mb-3">
              Te capacitamos en el uso del sistema, instalamos la app de monitoreo y activamos tu soporte técnico 24/7. ¡Empiezas a ahorrar desde el día 1!
            </p>
            <ul class="list-unstyled text-muted small">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Capacitación completa</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>App de monitoreo WiFi</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte técnico 24/7</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Mantenimiento incluido</li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-2 d-flex justify-content-center">
          <div class="position-relative">
            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px;">
              <i class="bi bi-mortarboard-fill text-white fs-2"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="ps-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
              <img src="https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=400" 
                   class="card-img-top" style="height: 200px; object-fit: cover;" alt="Capacitación">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BENEFICIOS DEL SERVICIO -->
<section class="py-5" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);">
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3">¿Por Qué Nuestro Servicio es Diferente?</h2>
      <p class="text-muted fs-5">Compromiso total con tu satisfacción</p>
    </div>

    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="card border-0 h-100 text-center p-4 shadow-sm rounded-4" style="transition: transform 0.3s ease;">
          <div class="mb-3">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="bi bi-shield-check text-primary" style="font-size: 2.5rem;"></i>
            </div>
          </div>
          <h5 class="fw-bold mb-3">Garantía Extendida</h5>
          <p class="text-muted">
            5 años de garantía en instalación y mano de obra. 25 años en paneles solares.
          </p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card border-0 h-100 text-center p-4 shadow-sm rounded-4" style="transition: transform 0.3s ease;">
          <div class="mb-3">
            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="bi bi-cash-coin text-success" style="font-size: 2.5rem;"></i>
            </div>
          </div>
          <h5 class="fw-bold mb-3">Precio Transparente</h5>
          <p class="text-muted">
            Sin costos ocultos. Todo incluido: materiales, instalación, permisos y capacitación.
          </p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card border-0 h-100 text-center p-4 shadow-sm rounded-4" style="transition: transform 0.3s ease;">
          <div class="mb-3">
            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="bi bi-clock-history text-warning" style="font-size: 2.5rem;"></i>
            </div>
          </div>
          <h5 class="fw-bold mb-3">Instalación Rápida</h5>
          <p class="text-muted">
            Completamos proyectos residenciales en 15 días. Sin interrupciones en tu rutina.
          </p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card border-0 h-100 text-center p-4 shadow-sm rounded-4" style="transition: transform 0.3s ease;">
          <div class="mb-3">
            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="bi bi-headset text-info" style="font-size: 2.5rem;"></i>
            </div>
          </div>
          <h5 class="fw-bold mb-3">Soporte 24/7</h5>
          <p class="text-muted">
            Asistencia técnica permanente. Monitoreo remoto y mantenimiento preventivo incluido.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- COMPARACIÓN ANTES/DESPUÉS -->
<section class="py-5 bg-light">
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3">Antes y Después de Instalar Paneles Solares</h2>
      <p class="text-muted fs-5">El cambio que experimentarás</p>
    </div>

    <div class="row g-4">
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
          <div class="card-header bg-danger bg-opacity-10 border-0 p-4">
            <h4 class="fw-bold text-danger mb-0">
              <i class="bi bi-x-circle-fill me-2"></i>Sin Paneles Solares
            </h4>
          </div>
          <div class="card-body p-4">
            <ul class="list-unstyled mb-0">
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-x-lg text-danger me-3 mt-1"></i>
                <div>
                  <strong>Recibos de luz altos</strong>
                  <p class="text-muted small mb-0">Gastos mensuales de S/300-500 o más</p>
                </div>
              </li>
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-x-lg text-danger me-3 mt-1"></i>
                <div>
                  <strong>Dependencia total de la red</strong>
                  <p class="text-muted small mb-0">Vulnerable a cortes y tarifas crecientes</p>
                </div>
              </li>
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-x-lg text-danger me-3 mt-1"></i>
                <div>
                  <strong>Huella de carbono alta</strong>
                  <p class="text-muted small mb-0">Energía de combustibles fósiles</p>
                </div>
              </li>
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-x-lg text-danger me-3 mt-1"></i>
                <div>
                  <strong>Sin control de gastos</strong>
                  <p class="text-muted small mb-0">Precios determinados por terceros</p>
                </div>
              </li>
              <li class="mb-0 d-flex align-items-start">
                <i class="bi bi-x-lg text-danger me-3 mt-1"></i>
                <div>
                  <strong>Pérdida de valor inmobiliario</strong>
                  <p class="text-muted small mb-0">Propiedad menos atractiva</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-success" style="border-width: 2px !important;">
          <div class="card-header bg-success bg-opacity-10 border-0 p-4">
            <h4 class="fw-bold text-success mb-0">
              <i class="bi bi-check-circle-fill me-2"></i>Con Paneles Solares
            </h4>
          </div>
          <div class="card-body p-4">
            <ul class="list-unstyled mb-0">
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-check-lg text-success me-3 mt-1 fs-5"></i>
                <div>
                  <strong>Ahorro del 60-90%</strong>
                  <p class="text-muted small mb-0">Recibos de solo S/30-100 mensuales</p>
                </div>
              </li>
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-check-lg text-success me-3 mt-1 fs-5"></i>
                <div>
                  <strong>Independencia energética</strong>
                  <p class="text-muted small mb-0">Genera tu propia electricidad limpia</p>
                </div>
              </li>
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-check-lg text-success me-3 mt-1 fs-5"></i>
                <div>
                  <strong>Energía 100% renovable</strong>
                  <p class="text-muted small mb-0">Reduce 4 toneladas de CO₂ al año</p>
                </div>
              </li>
              <li class="mb-3 d-flex align-items-start">
                <i class="bi bi-check-lg text-success me-3 mt-1 fs-5"></i>
                <div>
                  <strong>Monitoreo en tiempo real</strong>
                  <p class="text-muted small mb-0">Control total de tu producción energética</p>
                </div>
              </li>
              <li class="mb-0 d-flex align-items-start">
                <i class="bi bi-check-lg text-success me-3 mt-1 fs-5"></i>
                <div>
                  <strong>Aumenta el valor de tu propiedad</strong>
                  <p class="text-muted small mb-0">Incremento del 15-20% en valuación</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- CTA FINAL -->
<section class="py-5" style="background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);">
  <div class="container py-5">
    <div class="row align-items-center g-5">
      <div class="col-lg-7 text-white">
        <h2 class="display-5 fw-bold mb-4">¿Listo para Comenzar tu Transformación Energética?</h2>
        <p class="lead mb-4">
          Solicita tu evaluación técnica gratuita hoy y recibe una cotización personalizada en 24 horas.
        </p>
        
        <div class="row g-3 mb-4">
          <div class="col-sm-4">
            <div class="d-flex align-items-center">
              <div class="bg-white bg-opacity-25 rounded-circle p-2 me-2">
                <i class="bi bi-check-lg text-white fs-5"></i>
              </div>
              <div>
                <strong>Evaluación gratis</strong>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="d-flex align-items-center">
              <div class="bg-white bg-opacity-25 rounded-circle p-2 me-2">
                <i class="bi bi-check-lg text-white fs-5"></i>
              </div>
              <div>
                <strong>Sin compromiso</strong>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="d-flex align-items-center">
              <div class="bg-white bg-opacity-25 rounded-circle p-2 me-2">
                <i class="bi bi-check-lg text-white fs-5"></i>
              </div>
              <div>
                <strong>Respuesta 24h</strong>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex flex-wrap gap-3">
          <button class="btn btn-light btn-lg px-5 shadow">
            <i class="bi bi-calendar-check me-2"></i>Solicitar Evaluación Gratuita
          </button>
          <button class="btn btn-outline-light btn-lg px-4">
            <i class="bi bi-whatsapp me-2"></i>+51 999 999 999
          </button>
        </div>
      </div>
      
      <div class="col-lg-5">
        <div class="card border-0 shadow-lg rounded-4">
          <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Contacto Rápido</h5>
            <form>
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="Nombre completo">
              </div>
              <div class="mb-3">
                <input type="tel" class="form-control" placeholder="Teléfono">
              </div>
              <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email">
              </div>
              <div class="mb-3">
                <select class="form-select">
                  <option>Tipo de instalación</option>
                  <option>Residencial</option>
                  <option>Comercial</option>
                  <option>Industrial</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="bi bi-send-fill me-2"></i>Enviar Solicitud
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
@endsection