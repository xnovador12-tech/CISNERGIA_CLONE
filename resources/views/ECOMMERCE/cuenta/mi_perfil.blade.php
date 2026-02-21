@extends('TEMPLATES.ecommerce')

@section('title', 'MI PERFIL')

@section('css')
  <style>
    /* Sidebar Menu Mejorado */
    .sidebar-menu {
      position: sticky;
      top: 80px;
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid rgba(0, 86, 163, 0.1);
    }

    .user-avatar {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--bs-primary) 0%, #0052a3 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      transition: all 0.3s ease;
    }

    .user-avatar:hover {
      transform: scale(1.05) rotate(5deg);
      box-shadow: 0 8px 20px rgba(0, 86, 163, 0.3);
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.875rem 1rem;
      color: #495057;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
      position: relative;
      overflow: hidden;
    }

    .menu-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 3px;
      background: var(--bs-primary);
      transform: scaleY(0);
      transition: transform 0.3s ease;
    }

    .menu-item:hover::before {
      transform: scaleY(1);
    }

    .menu-item i {
      font-size: 1.25rem;
      width: 24px;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .menu-item:hover {
      color: var(--bs-primary);
      transform: translateX(8px);
      background: rgba(0, 86, 163, 0.05);
    }

    .menu-item:hover i {
      transform: scale(1.15);
    }

    .menu-item.active {
      background: linear-gradient(135deg, var(--bs-primary), #0052a3);
      color: white;
      box-shadow: 0 4px 12px rgba(0, 86, 163, 0.3);
      transform: translateX(5px);
    }

    .menu-item.active::before {
      display: none;
    }

    .menu-item.danger {
      color: var(--bs-danger);
    }

    .menu-item.danger:hover {
      background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(231, 76, 60, 0.05));
      color: var(--bs-danger);
    }

    .menu-item.danger:hover::before {
      background: var(--bs-danger);
    }

    /* Info Cards Modernizadas */
    .profile-card {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.8) 100%);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 86, 163, 0.1) !important;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .profile-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(0, 86, 163, 0.05), transparent);
      transition: left 0.6s ease;
    }

    .profile-card:hover::before {
      left: 100%;
    }

    .profile-card:hover {
      border-color: var(--bs-primary) !important;
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 86, 163, 0.15);
    }

    .info-label {
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      opacity: 0.7;
    }

    .info-value {
      font-size: 1rem;
      font-weight: 600;
      color: #212529;
    }

    .btn-edit-all {
      background: linear-gradient(135deg, var(--bs-primary), #0052a3);
      color: white;
      border: none;
      padding: 0.75rem 2rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 86, 163, 0.2);
    }

    .btn-edit-all:hover {
      background: linear-gradient(135deg, #0052a3, var(--bs-primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 86, 163, 0.3);
      color: white;
    }

    .btn-edit-all i {
      transition: transform 0.3s ease;
    }

    .btn-edit-all:hover i {
      transform: rotate(90deg);
    }

    /* Address Cards */
    .address-card {
      position: relative;
      transition: all 0.3s ease;
    }

    .address-card:hover {
      border-color: var(--bs-primary) !important;
      box-shadow: 0 4px 12px rgba(0, 86, 163, 0.1);
    }

    .address-card.default {
      border-color: var(--bs-success) !important;
      background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    }

    .default-badge {
      position: absolute;
      top: -12px;
      right: 16px;
      background: linear-gradient(135deg, var(--bs-success), #20a038);
      color: white;
      padding: 0.35rem 1rem;
      font-size: 0.75rem;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
    }

    /* Security Items */
    .security-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: all 0.3s ease;
    }

    .security-item:hover {
      border-color: var(--bs-primary) !important;
      box-shadow: 0 4px 12px rgba(0, 86, 163, 0.1);
    }

    .security-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, rgba(0, 86, 163, 0.1), rgba(0, 86, 163, 0.05));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: var(--bs-primary);
    }

    /* Toggle Switch */
    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 30px;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 30px;
    }

    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 22px;
      width: 22px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    .toggle-switch input:checked + .toggle-slider {
      background-color: var(--bs-success);
    }

    .toggle-switch input:checked + .toggle-slider:before {
      transform: translateX(30px);
    }

    /* Content Sections */
    .content-section {
      display: none;
    }

    .content-section.active {
      display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar-menu {
        position: relative;
        top: 0;
      }
    }
  </style>
@endsection

@section('content')
<!-- CONTENIDO PRINCIPAL -->
<section class="py-5">
  <div class="container">
    <!-- Hero / Breadcrumb -->
    <div class="mb-4">
      <h1 class="fw-bold mb-2" style="font-size: 2rem;">Mi Perfil</h1>
      <p class="text-muted">Administra tu información personal y preferencias de cuenta</p>
    </div>

    <div class="row">
      <!-- SIDEBAR -->
      <div class="col-lg-3 mb-4">
        <div class="sidebar-menu rounded-4 p-4 shadow-sm">
          <div class="text-center mb-4 pb-4 border-bottom">
            <div class="position-relative d-inline-block">
              <div class="user-avatar rounded-circle mb-3 overflow-hidden" id="profile-avatar">
                <img src="https://ui-avatars.com/api/?name=Alexander+De+La+Cruz&size=200&background=0056A3&color=fff&bold=true" 
                     alt="Foto de perfil" 
                     class="w-100 h-100 object-fit-cover"
                     id="avatar-image">
              </div>
              <button class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 shadow-sm" 
                      style="width: 36px; height: 36px; padding: 0;"
                      onclick="document.getElementById('avatar-upload').click()"
                      title="Cambiar foto de perfil">
                <i class="bi bi-camera-fill"></i>
              </button>
              <input type="file" 
                     id="avatar-upload" 
                     accept="image/*" 
                     style="display: none;" 
                     onchange="updateAvatar(event)">
            </div>
            <h5 class="fw-bold mb-1">Alexander De La Cruz</h5>
            <p class="text-muted small mb-0">gilbertodelacruzsaravia@gmail.com</p>
            <span class="badge bg-success-subtle text-success border border-success-subtle mt-2">
              <i class="bi bi-patch-check-fill me-1"></i>Verificado
            </span>
          </div>

          <a href="#" class="menu-item active rounded-3 mb-2" data-section="datos-personales">
            <i class="bi bi-person-fill"></i>
            <span>Datos personales</span>
          </a>
          
          <a href="#" class="menu-item rounded-3 mb-2" data-section="direcciones">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Direcciones</span>
          </a>
          
          <a href="#" class="menu-item rounded-3 mb-2" data-section="seguridad">
            <i class="bi bi-shield-lock-fill"></i>
            <span>Seguridad</span>
          </a>
          
          <a href="#" class="menu-item rounded-3 mb-2" data-section="notificaciones">
            <i class="bi bi-bell-fill"></i>
            <span>Notificaciones</span>
          </a>

          <hr class="my-3">
          
          <a href="#" class="menu-item danger rounded-3 mb-2" onclick="logout(event)">
            <i class="bi bi-box-arrow-right"></i>
            <span>Cerrar sesión</span>
          </a>
        </div>
      </div>

      <!-- CONTENIDO -->
      <div class="col-lg-9">
        
        <!-- DATOS PERSONALES -->
        <div class="content-section active" id="datos-personales">
          <!-- Vista de Lectura -->
          <div id="profile-view" class="bg-white rounded-4 p-4 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="fs-4 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-person-fill text-primary"></i>
                Datos personales
              </h2>
              <button class="btn btn-edit-all rounded-pill" onclick="toggleEditMode()">
                <i class="bi bi-pencil-square me-2"></i>Editar todo
              </button>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-person me-1"></i>Nombre completo
                  </div>
                  <div class="info-value">Alexander De La Cruz</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-card-text me-1"></i>Documento
                  </div>
                  <div class="info-value">DNI 75850297</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-telephone me-1"></i>Celular
                  </div>
                  <div class="info-value">+51 9 37040520</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-envelope me-1"></i>Correo electrónico
                  </div>
                  <div class="info-value" style="font-size: 0.9rem;">gilbertodelacruzsaravia@gmail.com</div>
                  <small class="text-success mt-1 d-block">
                    <i class="bi bi-patch-check-fill me-1"></i>Verificado
                  </small>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-calendar-event me-1"></i>Fecha de nacimiento
                  </div>
                  <div class="info-value">15 de marzo, 1990</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-gender-ambiguous me-1"></i>Género
                  </div>
                  <div class="info-value">Masculino</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Vista de Edición (Formulario Único) -->
          <div id="profile-edit" class="bg-white rounded-4 p-4 shadow-sm mb-4" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="fs-4 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-primary"></i>
                Editar datos personales
              </h2>
            </div>

            <form id="profile-form" onsubmit="saveProfile(event)">
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-person text-primary me-2"></i>Nombres
                  </label>
                  <input type="text" class="form-control form-control-lg" value="Alexander" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-person text-primary me-2"></i>Apellidos
                  </label>
                  <input type="text" class="form-control form-control-lg" value="De La Cruz" required>
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-card-text text-primary me-2"></i>Tipo de documento
                  </label>
                  <select class="form-select form-select-lg" required>
                    <option value="DNI" selected>DNI</option>
                    <option value="CE">Carnet de Extranjería</option>
                    <option value="Pasaporte">Pasaporte</option>
                  </select>
                </div>

                <div class="col-md-8">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-hash text-primary me-2"></i>Número de documento
                  </label>
                  <input type="text" class="form-control form-control-lg" value="75850297" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-telephone text-primary me-2"></i>Celular
                  </label>
                  <input type="tel" class="form-control form-control-lg" value="+51 9 37040520" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-calendar-event text-primary me-2"></i>Fecha de nacimiento
                  </label>
                  <input type="date" class="form-control form-control-lg" value="1990-03-15" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-gender-ambiguous text-primary me-2"></i>Género
                  </label>
                  <select class="form-select form-select-lg" required>
                    <option value="Masculino" selected>Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                    <option value="Prefiero no decir">Prefiero no decir</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-envelope text-primary me-2"></i>Correo electrónico
                  </label>
                  <input type="email" class="form-control form-control-lg" value="gilbertodelacruzsaravia@gmail.com" disabled>
                  <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle me-1"></i>El correo no puede ser modificado
                  </small>
                </div>
              </div>

              <div class="d-flex gap-3 mt-4 pt-3 border-top">
                <button type="button" class="btn btn-lg btn-outline-secondary rounded-pill px-4" onclick="toggleEditMode()">
                  <i class="bi bi-x-lg me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-lg btn-edit-all rounded-pill px-4">
                  <i class="bi bi-check-lg me-2"></i>Guardar cambios
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- DIRECCIONES -->
        <div class="content-section" id="direcciones">
          <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h2 class="fs-4 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-primary"></i>
                Mis direcciones
              </h2>
              <button class="btn btn-primary" onclick="openAddressModal()">
                <i class="bi bi-plus-lg me-2"></i>Nueva dirección
              </button>
            </div>

            <!-- Dirección Principal -->
            <div class="address-card default bg-white border-2 rounded-3 p-3 mb-3">
              <span class="default-badge rounded-pill">
                <i class="bi bi-star-fill me-1"></i>Principal
              </span>
              <div class="mb-3">
                <h5 class="fw-bold mb-2">Casa - Alexander De La Cruz</h5>
                <p class="mb-1 text-muted">
                  <i class="bi bi-geo-alt me-2"></i>
                  Av. Los Jardines 458, Dpto 302
                </p>
                <p class="mb-1 text-muted">
                  San Isidro, Lima, Lima
                </p>
                <p class="mb-0 text-muted">
                  <i class="bi bi-telephone me-2"></i>+51 9 37040520
                </p>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil me-1"></i>Editar
                </button>
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash me-1"></i>Eliminar
                </button>
              </div>
            </div>

            <!-- Dirección 2 -->
            <div class="address-card bg-white border-2 border rounded-3 p-3 mb-3">
              <div class="mb-3">
                <h5 class="fw-bold mb-2">Oficina - Alexander De La Cruz</h5>
                <p class="mb-1 text-muted">
                  <i class="bi bi-geo-alt me-2"></i>
                  Av. Javier Prado Este 2465, Piso 8
                </p>
                <p class="mb-1 text-muted">
                  San Borja, Lima, Lima
                </p>
                <p class="mb-0 text-muted">
                  <i class="bi bi-telephone me-2"></i>+51 9 37040520
                </p>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-star me-1"></i>Hacer principal
                </button>
                <button class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil me-1"></i>Editar
                </button>
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash me-1"></i>Eliminar
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- SEGURIDAD -->
        <div class="content-section" id="seguridad">
          <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
            <h2 class="fs-4 fw-bold text-dark mb-4 d-flex align-items-center gap-2">
              <i class="bi bi-shield-lock-fill text-primary"></i>
              Seguridad y contraseña
            </h2>

            <div class="security-item border-2 border rounded-3 p-3 mb-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="security-icon rounded-3">
                  <i class="bi bi-key-fill"></i>
                </div>
                <div>
                  <h5 class="mb-1 fw-bold">Contraseña</h5>
                  <p class="mb-0 text-muted small">Última actualización: hace 3 meses</p>
                </div>
              </div>
              <button class="btn btn-outline-primary" onclick="openPasswordModal()">
                <i class="bi bi-pencil me-2"></i>Cambiar
              </button>
            </div>

            <div class="security-item border-2 border rounded-3 p-3 mb-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="security-icon rounded-3">
                  <i class="bi bi-phone-fill"></i>
                </div>
                <div>
                  <h5 class="mb-1 fw-bold">Verificación en dos pasos</h5>
                  <p class="mb-0 text-muted small">Añade una capa extra de seguridad</p>
                </div>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
              </label>
            </div>

            <div class="security-item border-2 border rounded-3 p-3 mb-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="security-icon rounded-3">
                  <i class="bi bi-envelope-fill"></i>
                </div>
                <div>
                  <h5 class="mb-1 fw-bold">Correo de recuperación</h5>
                  <p class="mb-0 text-muted small">recovery@ejemplo.com</p>
                </div>
              </div>
              <button class="btn btn-outline-primary">
                <i class="bi bi-pencil me-2"></i>Editar
              </button>
            </div>
          </div>

          <!-- Sesiones activas -->
          <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
            <h3 class="fs-4 fw-bold text-dark mb-4 d-flex align-items-center gap-2">
              <i class="bi bi-clock-history text-primary"></i>
              Sesiones activas
            </h3>

            <div class="security-item">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="security-icon" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));">
                  <i class="bi bi-laptop" style="color: var(--success-color);"></i>
                </div>
                <div>
                  <h5 class="mb-1 fw-bold">Windows 11 - Chrome</h5>
                  <p class="mb-0 text-muted small">
                    <i class="bi bi-geo-alt me-1"></i>Lima, Perú • Activa ahora
                  </p>
                </div>
              </div>
              <span class="badge bg-success">Actual</span>
            </div>

            <div class="security-item">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="security-icon">
                  <i class="bi bi-phone"></i>
                </div>
                <div>
                  <h5 class="mb-1 fw-bold">iPhone 14 - Safari</h5>
                  <p class="mb-0 text-muted small">
                    <i class="bi bi-geo-alt me-1"></i>Lima, Perú • Hace 2 días
                  </p>
                </div>
              </div>
              <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-x-lg me-1"></i>Cerrar
              </button>
            </div>
          </div>

          <!-- Zona peligrosa -->
          <div class="bg-white rounded-4 p-4 shadow-sm mb-4 border-2 border-danger">
            <h3 class="fs-4 fw-bold text-danger mb-3 d-flex align-items-center gap-2">
              <i class="bi bi-exclamation-triangle-fill"></i>
              Zona de peligro
            </h3>
            <p class="text-muted mb-3">
              Una vez que elimines tu cuenta, no hay vuelta atrás. Todos tus datos, pedidos e información serán eliminados permanentemente.
            </p>
            <button class="btn btn-danger" onclick="confirmDeleteAccount()">
              <i class="bi bi-trash me-2"></i>Eliminar mi cuenta
            </button>
          </div>
        </div>

        <!-- NOTIFICACIONES -->
        <div class="content-section" id="notificaciones">
          <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
            <h2 class="fs-4 fw-bold text-dark mb-4 d-flex align-items-center gap-2">
              <i class="bi bi-bell-fill text-primary"></i>
              Preferencias de notificaciones
            </h2>

            <div class="security-item">
              <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">Notificaciones por email</h5>
                <p class="mb-0 text-muted small">Recibe actualizaciones sobre tus pedidos y cuenta</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
              </label>
            </div>

            <div class="security-item">
              <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">Ofertas y promociones</h5>
                <p class="mb-0 text-muted small">Entérate de descuentos y ofertas especiales</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
              </label>
            </div>

            <div class="security-item">
              <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">Novedades de productos</h5>
                <p class="mb-0 text-muted small">Nuevos productos y lanzamientos</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox">
                <span class="toggle-slider"></span>
              </label>
            </div>

            <div class="security-item">
              <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">Notificaciones push</h5>
                <p class="mb-0 text-muted small">Alertas en tiempo real en tu dispositivo</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
              </label>
            </div>

            <div class="security-item">
              <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">Recordatorios de carrito</h5>
                <p class="mb-0 text-muted small">Te avisamos si dejaste productos en el carrito</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
              </label>
            </div>

            <div class="security-item">
              <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">Mensajes por WhatsApp</h5>
                <p class="mb-0 text-muted small">Actualizaciones de pedidos por WhatsApp</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox">
                <span class="toggle-slider"></span>
              </label>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- MODALES -->

<!-- Modal Editar Información -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px; border: none;">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Editar información</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nombres</label>
          <input type="text" class="form-control" value="Alexander">
        </div>
        <div class="mb-3">
          <label class="form-label">Apellidos</label>
          <input type="text" class="form-control" value="De La Cruz">
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="passwordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px; border: none;">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-shield-lock text-primary me-2"></i>
          Cambiar contraseña
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Contraseña actual</label>
          <input type="password" class="form-control" placeholder="Ingresa tu contraseña actual">
        </div>
        <div class="mb-3">
          <label class="form-label">Nueva contraseña</label>
          <input type="password" class="form-control" placeholder="Mínimo 8 caracteres">
          <small class="text-muted">Debe contener mayúsculas, minúsculas y números</small>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirmar nueva contraseña</label>
          <input type="password" class="form-control" placeholder="Repite tu nueva contraseña">
        </div>
        <div class="alert alert-info">
          <i class="bi bi-info-circle me-2"></i>
          <small>Tu contraseña debe tener al menos 8 caracteres e incluir letras y números.</small>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Cambiar contraseña</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
@endsection