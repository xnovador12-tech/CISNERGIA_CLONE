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
      border: 1px solid rgba(var(--bs-primary-rgb), 0.1);
    }

    .user-avatar {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      transition: all 0.3s ease;
    }

    .user-avatar:hover {
      transform: scale(1.05) rotate(5deg);
      box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb), 0.3);
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.875rem 1rem;
      color: var(--c-text-muted);
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
      background: rgba(var(--bs-primary-rgb), 0.05);
    }

    .menu-item:hover i {
      transform: scale(1.15);
    }

    .menu-item.active {
      background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
      color: white;
      box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.3);
      transform: translateX(5px);
    }

    .menu-item.active::before {
      display: none;
    }

    .menu-item.danger {
      color: var(--bs-danger);
    }

    .menu-item.danger:hover {
      background: linear-gradient(135deg, rgba(var(--bs-danger-rgb), 0.1), rgba(var(--bs-danger-rgb), 0.05));
      color: var(--bs-danger);
    }

    .menu-item.danger:hover::before {
      background: var(--bs-danger);
    }

    /* Info Cards Modernizadas */
    .profile-card {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.8) 100%);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(var(--bs-primary-rgb), 0.1) !important;
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
      background: linear-gradient(90deg, transparent, rgba(var(--bs-primary-rgb), 0.05), transparent);
      transition: left 0.6s ease;
    }

    .profile-card:hover::before {
      left: 100%;
    }

    .profile-card:hover {
      border-color: var(--bs-primary) !important;
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(var(--bs-primary-rgb), 0.15);
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
      color: var(--c-text);
    }

    .btn-edit-all {
      background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
      color: white;
      border: none;
      padding: 0.75rem 2rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.2);
    }

    .btn-edit-all:hover {
      background: linear-gradient(135deg, var(--bs-secondary), var(--bs-primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(var(--bs-primary-rgb), 0.3);
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
      box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.1);
    }

    .address-card.default {
      border-color: var(--bs-success) !important;
      background: linear-gradient(135deg, rgba(var(--bs-success-rgb), 0.05) 0%, var(--c-surface) 100%);
    }

    .default-badge {
      position: absolute;
      top: -12px;
      right: 16px;
      background: linear-gradient(135deg, var(--bs-success), var(--bs-success));
      color: white;
      padding: 0.35rem 1rem;
      font-size: 0.75rem;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(var(--bs-success-rgb), 0.3);
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
      box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.1);
    }

    .security-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.1), rgba(var(--bs-primary-rgb), 0.05));
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
      background-color: var(--c-border);
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
            <h5 class="fw-bold mb-1">{{Auth::user()->persona->name.' '.Auth::user()->persona->surnames}}</h5>
            <p class="text-muted small mb-0">{{Auth::user()->email}}</p>
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
                  <div class="info-value">{{ Auth::user()->persona->name.' '.Auth::user()->persona->surnames }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-card-text me-1"></i>Documento
                  </div>
                  <div class="info-value">DNI {{ Auth::user()->persona->nro_identificacion }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-telephone me-1"></i>Celular
                  </div>
                  <div class="info-value">{{ Auth::user()->persona->celular }}</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="profile-card border rounded-3 p-3">
                  <div class="info-label text-primary mb-2">
                    <i class="bi bi-envelope me-1"></i>Correo electrónico
                  </div>
                  <div class="info-value" style="font-size: 0.9rem;">{{ Auth::user()->email }}</div>
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
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crear_direccion">
                <i class="bi bi-plus-lg me-2"></i>Nueva dirección
              </button>
            </div>

            <!-- Dirección Principal -->
             @foreach($direcciones as $direccion)
            <div class="address-card default bg-white border-2 rounded-3 p-3 mb-3">
              <!-- <span class="default-badge rounded-pill">
                <i class="bi bi-star-fill me-1"></i>Principal
              </span> -->
              <div class="mb-3">
                <h5 class="fw-bold mb-2">{{$direccion->referencia}}</h5>
                <p class="mb-1 text-muted">
                  <i class="bi bi-geo-alt me-2"></i>
                  {{$direccion->direccion}}
                </p>
                <p class="mb-1 text-muted">
                  {{$direccion->distrito->nombre}}, {{$direccion->provincia->nombre}}, {{$direccion->departamento->nombre}}
                </p>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <button type="button" data-bs-toggle="modal" data-bs-target="#editar_direcciones{{$direccion->id}}" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil me-1"></i>Editar
                </button>
                <button onclick="eliminarDireccion({{$direccion->id}})" class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash me-1"></i>Eliminar
                </button>
              </div>
            </div>
            @endforeach
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
              <button class="btn btn-outline-primary" data-bs-toggle="modal" 
                      data-bs-target="#passwordModal">
                <i class="bi bi-pencil me-2"></i>Cambiar
              </button>
            </div>

            <div class="security-item border-2 border rounded-3 p-3 mb-3">
              <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="security-icon rounded-3">
                  <i class="bi bi-envelope-fill"></i>
                </div>
                <div>
                  <h5 class="mb-1 fw-bold">Correo de recuperación</h5>
                  <p class="mb-0 text-muted small">{{ Auth::user()->email }}</p>
                </div>
              </div>
              <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                <i class="bi bi-pencil me-2"></i>Editar
              </button>
            </div>
          </div>
        </div>

        <!-- NOTIFICACIONES -->
        <div class="content-section" id="notificaciones">
          <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
            <h2 class="fs-4 fw-bold text-dark mb-4 d-flex align-items-center gap-2">
              <i class="bi bi-bell-fill text-primary"></i>
              Notificaciones
            </h2>

            @forelse($cupons as $cupon)
            <div class="security-item">
              <div class="flex-grow-1 mb-2">
              @php
                  $validar_noticupon = \App\Models\Usercoupon::where('user_id',Auth::user()->id)->where('coupon_id',$cupon->id)->first();
              @endphp

              @if(\App\Models\Usercoupon::where('user_id',Auth::user()->id)->where('coupon_id',$cupon->id)->exists())
                  <div class="card-body" disabled>
                      <div class="row align-items-center">
                          <div class="col-1 col-md-1">
                              <i class="cupon bi bi-ticket-perforated-fill fs-1 text-primary p-2"></i>
                          </div>
                          <div class="col-8 col-md-8">
                              <p class="mb-1 fw-bold">{{$validar_noticupon->user->name.' '.$validar_noticupon->user->surnames}} tu cupon ya fue utilizado</p>
                              <small class="fw-light d-block">Publicado hace {{$cupon->created_at->diffForHumans(null, true) }}</small>
                          </div>
                          <div class="col-3 col-md-3 text-end">
                              <p class="mb-1 fw-bold">CÓDIGO</p>
                              <small class="fw-light d-block">{{$cupon->codigo}}</small>
                          </div>
                      </div>
                  </div>
              @else
                  <div class="card-body">
                      <div class="row align-items-center">
                          <div class="col-1 col-md-1">
                              <i class="cupon bi bi-ticket-perforated-fill fs-1 text-primary"></i>
                          </div>
                          <div class="col-8 col-md-8">
                              <p class="mb-1 fw-bold">{{Auth::user()->name.' '.Auth::user()->surnames}} <label class="mb-1 fw-light">tienes un cupon de descuento</label></p>
                              <small class="fw-light d-block">Publicado hace {{$cupon->created_at->diffForHumans(null, true) }}</small>
                          </div>
                          <div class="col-3 col-md-3 text-end">
                              <p class="mb-1 fw-bold">CÓDIGO</p>
                              <small class="fw-light d-block">{{$cupon->codigo}}</small>
                          </div>
                      </div>
                  </div>
              @endif
              </div>
            </div>
            @empty
                <p class="text-muted">No tienes cupones disponibles.</p>
            @endforelse

            @forelse($ultimos_productos as $producto)
            <div class="security-item mt-2 mb-2">
              <div class="flex-grow-1">
                <div class="card-body">
                  <div class="row align-items-center g-2">

                    {{-- Imagen --}}
                    <div class="col-auto">
                      <img src="{{ $producto->imagen ? asset('images/productos/' . $producto->imagen) : asset('images/logo.webp') }}"
                          alt="{{ $producto->name }}"
                          class="rounded-3"
                          style="width: 50px; height: 50px; object-fit: cover;">
                    </div>

                    {{-- Descripción --}}
                    <div class="col">
                      <p class="mb-1 fw-bold">{{ $producto->name }} ha sido agregado recientemente</p>
                      <small class="fw-light text-muted d-block">
                        Publicado hace {{ $producto->created_at->diffForHumans(null, true) }}
                      </small>
                    </div>

                    {{-- Código --}}
                    <div class="col-auto text-end">
                      <p class="mb-1 fw-bold small">CÓDIGO</p>
                      <small class="fw-light d-block text-primary">{{ $producto->codigo }}</small>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            @empty
            @endforelse
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

@endsection

@push('modals')
    @include('ECOMMERCE.cuenta.editar_informacion')
    @include('ECOMMERCE.cuenta.crear_direccion')
    @foreach($direcciones as $direccion)
      @include('ECOMMERCE.cuenta.editar_direccion', ['direccion' => $direccion])
    @endforeach
    @include('ECOMMERCE.cuenta.editar_contraseña')
    @include('ECOMMERCE.cuenta.correo_recuperacion')
@endpush

@section('js')
<script>
  // Navegación entre secciones
  document.querySelectorAll('.menu-item[data-section]').forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();

      const targetSection = this.dataset.section;

      // Quitar active de todos los menu-items
      document.querySelectorAll('.menu-item').forEach(m => m.classList.remove('active'));
      // Poner active al clickeado
      this.classList.add('active');

      // Ocultar todas las secciones
      document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
      // Mostrar la sección target
      document.getElementById(targetSection).classList.add('active');
    });
  });
</script>

<script>
    $(document).ready(function() {
        $('#departamento_id').on('change', function() {
            valor_departamento = $(this).val();
            $.get('/ver_provincias',{valor_departamento:valor_departamento}, function(busqueda){
                $('#provincia_id').empty();
                $('#provincia_id').append('<option selected disabled>Seleccionar</option>');
                $.each(busqueda, function(index, value){
                    $('#provincia_id').append(''+'<option value="'+index+'">'+value[0]+'</option>');
                });
            });
        });

        $('#provincia_id').on('change', function() {
            valor_provincia = $(this).val();
            $.get('/ver_distritos',{valor_provincia:valor_provincia}, function(busqueda){
                $('#distrito_id').empty();
                $('#distrito_id').append('<option selected disabled>Seleccionar</option>');
                $.each(busqueda, function(index, value){
                    $('#distrito_id').append(''+'<option value="'+index+'">'+value[0]+'</option>');
                });
            });
        });
    });

</script>

@if(session('registrar_direccion') == 'ok')
<script>
    Swal.fire({
    icon: 'success',
    confirmButtonColor: '#1C3146',
    title: '¡Éxito!',
    text: 'Dirección registrada exitosamente.',
    })
</script>
@endif

@if(session('success') == 'ok')
<script>
    Swal.fire({
    icon: 'success',
    confirmButtonColor: '#1C3146',
    title: '¡Éxito!',
    text: 'Dirección actualizada exitosamente.',
    })
</script>
@endif

@if(session('eliminar_direccion') == 'ok')
<script>
    Swal.fire({
    icon: 'success',
    confirmButtonColor: '#1C3146',
    title: '¡Éxito!',
    text: 'Dirección eliminada exitosamente.',
    })
</script>
@endif

@if(session('actualizar_contrasena') == 'ok')
<script>
    Swal.fire({
    icon: 'success',
    confirmButtonColor: '#1C3146',
    title: '¡Éxito!',
    text: 'Contraseña actualizada exitosamente.',
    })
</script>
@endif

@if($errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation'))
<script>
    const passwordError = @json($errors->first('current_password') ?: $errors->first('new_password') ?: $errors->first('new_password_confirmation'));

    Swal.fire({
    icon: 'error',
    confirmButtonColor: '#1C3146',
    title: '¡Error!',
    text: passwordError,
    });

    const passwordModal = document.getElementById('passwordModal');
    if (passwordModal) {
      const modalInstance = new bootstrap.Modal(passwordModal);
      modalInstance.show();
    }
</script>
@endif

<script>
  function eliminarDireccion(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Esta acción no se puede deshacer!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirigir a la ruta de eliminación
        window.location.href = `/ecommerce/direccion/eliminar/${id}`;
      }
    });
  }
</script>
@endsection