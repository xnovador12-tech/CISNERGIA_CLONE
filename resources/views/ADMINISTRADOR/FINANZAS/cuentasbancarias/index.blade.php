@extends('TEMPLATES.administrador')

@section('title', 'Cuentas Bancarias')

@section('content')
<div class="container-fluid pt-5 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-right">
        <div>
            <h2 class="fw-bold text-dark mb-0">Cuentas Bancarias</h2>
            <p class="text-muted">Gestión de cuentas por sucursal</p>
        </div>
        <div>
            <a href="{{ route('admin-cuentasbancarias.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Nueva Cuenta
            </a>
        </div>
    </div>

    <div class="row" data-aos="fade-up">
        @foreach($cuentas as $cuenta)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-bank fs-4"></i>
                        </div>
                        <span class="badge {{ $cuenta->estado ? 'bg-success text-white' : 'bg-danger text-white' }} rounded-pill px-3 py-2">
                            {{ $cuenta->estado ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">{{ $cuenta->banco->name }}</h5>
                    <p class="text-muted small mb-3">{{ $cuenta->moneda->descripcion ?? '' }}</p>

                    <div class="bg-light p-3 rounded-4 mb-3">
                        <p class="text-muted small mb-1">Número de Cuenta</p>
                        <p class="fw-bold text-dark mb-0">{{ $cuenta->numero_cuenta }}</p>
                        @if($cuenta->cci)
                        <p class="text-muted small mt-2 mb-1">CCI</p>
                        <p class="fw-semibold text-dark mb-0">{{ $cuenta->cci }}</p>
                        @endif
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="p-2 rounded-circle bg-secondary bg-opacity-10 text-secondary">
                                <i class="bi bi-geo-alt-fill small"></i>
                            </div>
                        </div>
                        <div class="ms-2">
                            <p class="small text-muted mb-0">Sucursal</p>
                            <p class="small fw-bold text-dark mb-0 text-uppercase">{{ $cuenta->sede?->name ?? 'Sin sede' }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto border-top pt-3">
                        <div>
                            <p class="small text-muted mb-0">Saldo Actual</p>
                            <h4 class="fw-bold text-primary mb-0">{{ $cuenta->moneda->simbolo }} {{ number_format($cuenta->saldo_actual, 2) }}</h4>
                        </div>
                        <div class="btn-group">
                            <a href="{{-- route('admin-cuentasbancarias.edit', $cuenta->id) --}}" class="btn btn-sm btn-outline-secondary rounded-pill me-1 px-3">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
