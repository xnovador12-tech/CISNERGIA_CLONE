@extends('TEMPLATES.administrador')
@section('title', 'ROLES')

@section('content')
{{-- ENCABEZADO --}}
<div class="header_section">
    <div class="bg-transparent mb-3" style="height: 67px"></div>
    <div class="container-fluid">
        <div data-aos="fade-right">
            <h1 class="titulo h2 text-uppercase fw-bold mb-0">ROLES</h1>
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                    <li class="breadcrumb-item link" aria-current="page">Roles</li>
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
                    <small class="text-muted text-uppercase">Total Roles</small>
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
    </div>

    {{-- TABLA --}}
    <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px" data-aos="fade-up">
        <div class="card-header bg-transparent">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-auto">
                    <a href="{{ route('admin-roles.create') }}" class="btn btn-primary btn-sm text-uppercase text-white">
                        <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Rol
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
                        <th class="h6 small text-uppercase fw-bold">Rol</th>
                        <th class="h6 small text-uppercase fw-bold">Descripción</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Usuarios</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Permisos</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                        <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $i => $admin_role)
                    <tr>
                        <td class="text-center align-middle">{{ $i + 1 }}</td>
                        <td class="align-middle">
                            <span class="fw-semibold">{{ $admin_role->name }}</span>
                        </td>
                        <td class="align-middle">
                            <small class="text-muted">{{ $admin_role->descripcion ?? '—' }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-primary">{{ $admin_role->users_count }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-primary">{{ $admin_role->permissions->count() }}</span>
                        </td>
                        <td class="text-center align-middle">
                            @if($admin_role->estado === 'Activo')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
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
                                            href="{{ route('admin-roles.edit', $admin_role->slug) }}">
                                            <i class="bi bi-pencil text-secondary me-2"></i>Editar / Permisos
                                        </a>
                                    </li>
                                    @if($admin_role->users_count === 0)
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin-roles.destroy', $admin_role->slug) }}" class="form-delete">
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
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: '¿Eliminar rol?',
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
