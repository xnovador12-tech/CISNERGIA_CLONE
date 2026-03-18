@extends('TEMPLATES.administrador')

@section('title', 'Nueva Cuenta Bancaria')

@section('content')
<div class="container-fluid pt-5 mt-4 pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="zoom-in">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-4 border-0">
                    <div class="d-flex align-items-center px-2">
                        <div class="p-3 rounded-circle bg-white bg-opacity-20 text-white me-3">
                            <i class="bi bi-bank fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-white mb-0">Nueva Cuenta Bancaria</h3>
                            <p class="text-white text-opacity-75 mb-0">Configure los detalles de la nueva cuenta por sede</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('admin-cuentasbancarias.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Titular de la Cuenta -->
                            <div class="col-12">
                                <label for="titular" class="form-label fw-semibold text-dark">Titular de la Cuenta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                                    <input type="text" name="titular" id="titular" class="form-control bg-light border-0 py-3 rounded-end shadow-none" placeholder="Nombre completo del titular" required>
                                </div>
                            </div>

                            <!-- Número de Cuenta -->
                            <div class="col-md-6">
                                <label for="numero_cuenta" class="form-label fw-semibold text-dark">Número de Cuenta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-hash text-primary"></i></span>
                                    <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control bg-light border-0 py-3 rounded-end shadow-none" placeholder="000-0000000-0-00" required>
                                </div>
                            </div>

                            <!-- CCI -->
                            <div class="col-md-6">
                                <label for="cci" class="form-label fw-semibold text-dark">CCI (Opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-shield-check text-primary"></i></span>
                                    <input type="text" name="cci" id="cci" class="form-control bg-light border-0 py-3 rounded-end shadow-none" placeholder="000-000-000000000000-00">
                                </div>
                            </div>

                            <!-- Banco -->
                            <div class="col-md-6">
                                <label for="banco_id" class="form-label fw-semibold text-dark">Banco</label>
                                <select name="banco_id" id="banco_id" class="form-select bg-light border-0 py-3 shadow-none" required>
                                    <option value="" disabled selected>Seleccione un banco</option>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->id }}">{{ $banco->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Moneda -->
                            <div class="col-md-6">
                                <label for="moneda_id" class="form-label fw-semibold text-dark">Moneda</label>
                                <select name="moneda_id" id="moneda_id" class="form-select bg-light border-0 py-3 shadow-none" required>
                                    <option value="" disabled selected>Seleccione moneda</option>
                                    @foreach($monedas as $moneda)
                                        <option value="{{ $moneda->id }}">{{ $moneda->descripcion }} ({{ $moneda->simbolo }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sede (Sucursal) -->
                            <div class="col-md-6">
                                <label for="sede_id" class="form-label fw-semibold text-dark">Sede / Sucursal</label>
                                <select name="sede_id" id="sede_id" class="form-select bg-light border-0 py-3 shadow-none" required>
                                    <option value="" disabled selected>Asigne una sede</option>
                                    @foreach($sedes as $sede)
                                        <option value="{{ $sede->id }}">{{ $sede->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Saldo Inicial -->
                            <div class="col-md-6">
                                <label for="saldo_inicial" class="form-label fw-semibold text-dark">Saldo Inicial</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-cash-stack text-primary"></i></span>
                                    <input type="number" step="0.01" name="saldo_inicial" id="saldo_inicial" class="form-control bg-light border-0 py-3 rounded-end shadow-none" placeholder="0.00" required>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="col-12 mt-5">
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 shadow-sm flex-grow-1 fw-bold">
                                        <i class="bi bi-check2-circle me-2"></i>Guardar Cuenta Bancaria
                                    </button>
                                    <a href="{{ route('admin-cuentasbancarias.index') }}" class="btn btn-light rounded-pill px-5 py-3 flex-grow-1 fw-semibold text-muted border">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-text {
        border-right: none;
    }
    .form-control:focus, .form-select:focus {
        background-color: #f8f9fa !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
        border: 1px solid rgba(13, 110, 253, 0.2) !important;
    }
    .scale-150 {
        transform: scale(1.5);
    }
    .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
</style>
@endsection
