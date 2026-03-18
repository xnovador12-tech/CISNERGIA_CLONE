@extends('TEMPLATES.administrador')
@section('title', 'ABRIR CAJA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">ABRIR CAJA CHICA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-caja-chica.index') }}">Caja Chica</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Abrir Caja</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-unlock me-2"></i>Apertura de Caja</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin-caja-chica.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Fecha de Apertura</label>
                                <input type="text" class="form-control" value="{{ now()->format('d/m/Y H:i') }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Usuario</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Saldo Inicial <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" step="0.01" min="0" name="saldo_inicial" class="form-control form-control-lg" value="0.00" required>
                                </div>
                                <small class="text-muted">Monto en efectivo al momento de abrir la caja</small>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 shadow-sm">
                                <i class="bi bi-unlock me-2"></i>Abrir Caja
                            </button>
                            <a href="{{ route('admin-caja-chica.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-arrow-left me-2"></i>Cancelar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
