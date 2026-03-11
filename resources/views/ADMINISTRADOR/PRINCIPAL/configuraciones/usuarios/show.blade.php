@extends('TEMPLATES.administrador')
@section('title', 'Perfil de Usuario')

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">PERFIL DE USUARIO</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-usuarios.index') }}">Usuarios</a></li>
                    <li class="breadcrumb-item link" aria-current="page">{{ $admin_usuario->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row g-4">

        {{-- PERFIL PRINCIPAL --}}
        <div class="col-lg-4">
            <div class="card border-4 borde-top-secondary shadow-sm text-center" style="border-radius:20px" data-aos="fade-up">
                <div class="card-body py-4">
                    {{-- Avatar inicial --}}
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold mx-auto mb-3"
                        style="width:80px; height:80px; font-size:2rem;">
                        {{ strtoupper(substr($admin_usuario->persona?->name ?? 'U', 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-0">{{ $admin_usuario->name }}</h5>
                    <small class="text-muted">{{ $admin_usuario->email }}</small>

                    <div class="mt-3 d-flex justify-content-center gap-2">
                        @if($admin_usuario->roles->first())
                            <span class="badge bg-primary fs-6">{{ $admin_usuario->roles->first()->name }}</span>
                        @endif
                        @if($admin_usuario->estado === 'Activo')
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </div>

                    <hr>
                    <div class="text-start text-muted small">
                        @if($admin_usuario->persona?->celular)
                        <div class="mb-1"><i class="bi bi-phone me-2"></i>{{ $admin_usuario->persona->celular }}</div>
                        @endif
                        @if($admin_usuario->persona?->direccion)
                        <div class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $admin_usuario->persona->direccion }}</div>
                        @endif
                        <div class="mb-1"><i class="bi bi-calendar me-2"></i>Desde {{ $admin_usuario->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="card-footer bg-transparent d-flex gap-2 justify-content-center">
                    <a href="{{ route('admin-usuarios.edit', $admin_usuario->id) }}" class="btn btn-primary btn-sm text-uppercase">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    <a href="{{ route('admin-usuarios.index') }}" class="btn btn-outline-secondary btn-sm text-uppercase">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        {{-- PERMISOS DEL ROL --}}
        <div class="col-lg-8">
            <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius:20px" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-uppercase small">
                        <i class="bi bi-key me-2"></i>Permisos del Rol
                    </span>
                    @if($admin_usuario->roles->first())
                        <a href="{{ route('admin-roles.edit', $admin_usuario->roles->first()->slug) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-shield-lock me-1"></i>Gestionar permisos del rol
                        </a>
                    @endif
                </div>
                <div class="card-body" style="max-height: 60vh; overflow-y: auto;">
                    @php
                        $permisosPorModulo = $admin_usuario->roles->first()?->permissions
                            ->groupBy('modulo') ?? collect();
                    @endphp

                    @if($permisosPorModulo->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-shield-x fs-1 d-block mb-2"></i>
                            Este usuario no tiene permisos asignados.
                            @if($admin_usuario->roles->first())
                                <br><a href="{{ route('admin-roles.edit', $admin_usuario->roles->first()->slug) }}">Asignar permisos al rol</a>
                            @endif
                        </div>
                    @else
                        @foreach($permisosPorModulo as $modulo => $permisos)
                        <div class="mb-3">
                            <div class="fw-semibold small text-uppercase border-bottom pb-1 mb-2">
                                <i class="bi bi-folder2-open me-1 text-primary"></i>{{ $modulo }}
                                <span class="badge bg-secondary ms-1">{{ $permisos->count() }}</span>
                            </div>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($permisos as $permiso)
                                    <span class="badge bg-light text-dark border">{{ $permiso->label }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
