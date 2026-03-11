@extends('TEMPLATES.administrador')
@section('title', 'USUARIOS')

@section('content')
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">USUARIOS</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Usuarios</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    {{-- KPIs --}}
    <div class="row g-3 mb-4" data-aos="fade-up">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center" style="border-radius:16px">
                <div class="card-body py-3">
                    <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
                    <small class="text-muted text-uppercase">Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center" style="border-radius:16px">
                <div class="card-body py-3">
                    <div class="fs-2 fw-bold text-success">{{ $stats['activos'] }}</div>
                    <small class="text-muted text-uppercase">Activos</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center" style="border-radius:16px">
                <div class="card-body py-3">
                    <div class="fs-2 fw-bold text-danger">{{ $stats['inactivos'] }}</div>
                    <small class="text-muted text-uppercase">Inactivos</small>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px" data-aos="fade-up">
        <div class="card-header bg-transparent">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-auto">
                    <a href="{{ route('admin-usuarios.create') }}" class="btn btn-primary btn-sm text-uppercase text-white">
                        <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-2">
                <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold">{{ $stats['total'] }}</span></span>
            </div>
            <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                <thead class="bg-dark text-white border-0">
                    <tr>
                        <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                        <th class="h6 small text-uppercase fw-bold">Usuario</th>
                        <th class="h6 small text-uppercase fw-bold">Email</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Rol</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $i => $admin_usuario)
                    <tr>
                        <td class="text-center align-middle">{{ $i + 1 }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white fw-bold"
                                    style="width:36px; height:36px; min-width:36px; font-size:0.85rem;">
                                    {{ strtoupper(substr($admin_usuario->persona?->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $admin_usuario->name }}</div>
                                    <small class="text-muted">{{ $admin_usuario->persona?->celular ?? '—' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <small>{{ $admin_usuario->email }}</small>
                        </td>
                        <td class="text-center align-middle">
                            @if($admin_usuario->roles->first())
                                <span class="badge bg-primary">{{ $admin_usuario->roles->first()->name }}</span>
                            @else
                                <span class="badge bg-secondary">Sin rol</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <form method="POST" action="/admin-usuarios/estado/{{ $admin_usuario->id }}" class="form-estado" id="form-estado-{{ $admin_usuario->id }}">
                                @csrf @method('PUT')
                                @if($admin_usuario->estado === 'Activo')
                                    <button type="button" class="badge bg-success border-0 btn-toggle-estado"
                                        data-id="{{ $admin_usuario->id }}"
                                        data-nombre="{{ $admin_usuario->name }}"
                                        data-estado="Activo">Activo</button>
                                @else
                                    <button type="button" class="badge bg-danger border-0 btn-toggle-estado"
                                        data-id="{{ $admin_usuario->id }}"
                                        data-nombre="{{ $admin_usuario->name }}"
                                        data-estado="Inactivo">Inactivo</button>
                                @endif
                            </form>
                        </td>
                        <td class="text-center align-middle">
                            <div class="dropstart">
                                <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="width:36px; height:36px; padding:0;">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('admin-usuarios.show', $admin_usuario->id) }}">
                                            <i class="bi bi-eye text-info me-2"></i>Ver detalle
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('admin-usuarios.edit', $admin_usuario->id) }}">
                                            <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                        </a>
                                    </li>
                                    @if($admin_usuario->id !== auth()->id())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin-usuarios.destroy', $admin_usuario->id) }}" class="form-delete">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                                <i class="bi bi-trash me-2"></i>Eliminar
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('ADMINISTRADOR.PRINCIPAL.configuraciones.roles._alerts')
<script>
    // Confirmar cambio de estado
    document.querySelectorAll('.btn-toggle-estado').forEach(btn => {
        btn.addEventListener('click', function() {
            const id      = this.dataset.id;
            const nombre  = this.dataset.nombre;
            const estado  = this.dataset.estado;
            const nuevo   = estado === 'Activo' ? 'Inactivo' : 'Activo';
            const icono   = estado === 'Activo' ? 'warning' : 'question';

            Swal.fire({
                title: '¿Cambiar estado?',
                html: `El usuario <strong>${nombre}</strong> pasará a <strong>${nuevo}</strong>.`,
                icon: icono,
                showCancelButton: true,
                confirmButtonColor: '#1C3146',
                cancelButtonColor: '#FF9C00',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then(r => {
                if (r.isConfirmed) {
                    document.getElementById('form-estado-' + id).submit();
                }
            });
        });
    });

    // Confirmar eliminar
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Eliminar usuario?',
            text: 'Esta acción no se puede revertir.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3146',
            cancelButtonColor: '#FF9C00',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
</script>
@endsection
