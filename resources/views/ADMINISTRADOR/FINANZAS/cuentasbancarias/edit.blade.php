@extends('TEMPLATES.administrador')

@section('title', 'Editar Cuenta Bancaria')

@section('content')
<div class="container-fluid pt-5 mt-4 pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="zoom-in">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header py-4 border-0">
                    <div class="d-flex align-items-center px-2">
                        <div class="p-3 rounded-circle bg-white bg-opacity-20 text-white me-3">
                            <i class="bi bi-bank fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-white mb-0">Editar Cuenta Bancaria</h3>
                            <p class="text-white text-opacity-75 mb-0">Modifique los datos de la cuenta bancaria</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('admin-cuentasbancarias.update', $admin_cuentasbancaria->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Titular -->
                            <div class="col-12">
                                <label for="titular" class="form-label fw-semibold text-dark">Titular de la Cuenta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                                    <input type="text" name="titular" id="titular"
                                           class="form-control bg-light border-0 py-3 rounded-end shadow-none @error('titular') is-invalid @enderror"
                                           value="{{ old('titular', $admin_cuentasbancaria->titular) }}" required>
                                </div>
                                @error('titular') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Número de Cuenta -->
                            <div class="col-md-6">
                                <label for="numero_cuenta" class="form-label fw-semibold text-dark">Número de Cuenta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-hash text-primary"></i></span>
                                    <input type="text" name="numero_cuenta" id="numero_cuenta"
                                           class="form-control bg-light border-0 py-3 rounded-end shadow-none @error('numero_cuenta') is-invalid @enderror"
                                           value="{{ old('numero_cuenta', $admin_cuentasbancaria->numero_cuenta) }}" required>
                                </div>
                                @error('numero_cuenta') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- CCI -->
                            <div class="col-md-6">
                                <label for="cci" class="form-label fw-semibold text-dark">CCI (Opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-shield-check text-primary"></i></span>
                                    <input type="text" name="cci" id="cci"
                                           class="form-control bg-light border-0 py-3 rounded-end shadow-none"
                                           value="{{ old('cci', $admin_cuentasbancaria->cci) }}">
                                </div>
                            </div>

                            <!-- Banco -->
                            <div class="col-md-6">
                                <label for="banco_id" class="form-label fw-semibold text-dark">Banco</label>
                                <select name="banco_id" id="banco_id" class="form-select bg-light border-0 py-3 shadow-none" required>
                                    <option value="" disabled>Seleccione un banco</option>
                                    @foreach($bancos as $banco)
                                        <option value="{{ $banco->id }}" {{ old('banco_id', $admin_cuentasbancaria->banco_id) == $banco->id ? 'selected' : '' }}>
                                            {{ $banco->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('banco_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Moneda -->
                            <div class="col-md-6">
                                <label for="moneda_id" class="form-label fw-semibold text-dark">Moneda</label>
                                <select name="moneda_id" id="moneda_id" class="form-select bg-light border-0 py-3 shadow-none" required>
                                    <option value="" disabled>Seleccione moneda</option>
                                    @foreach($monedas as $moneda)
                                        <option value="{{ $moneda->id }}" {{ old('moneda_id', $admin_cuentasbancaria->moneda_id) == $moneda->id ? 'selected' : '' }}>
                                            {{ $moneda->descripcion }} ({{ $moneda->simbolo }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('moneda_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Sede -->
                            <div class="col-md-6">
                                <label for="sede_id" class="form-label fw-semibold text-dark">Sede / Sucursal</label>
                                <select name="sede_id" id="sede_id" class="form-select bg-light border-0 py-3 shadow-none" required>
                                    <option value="" disabled>Asigne una sede</option>
                                    @foreach($sedes as $sede)
                                        <option value="{{ $sede->id }}" {{ old('sede_id', $admin_cuentasbancaria->sede_id) == $sede->id ? 'selected' : '' }}>
                                            {{ $sede->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sede_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Estado</label>
                                <div class="d-flex gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="estado" id="estado_activa" value="1"
                                               {{ old('estado', $admin_cuentasbancaria->estado ? '1' : '0') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="estado_activa">Activa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="estado" id="estado_inactiva" value="0"
                                               {{ old('estado', $admin_cuentasbancaria->estado ? '1' : '0') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="estado_inactiva">Inactiva</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Info de saldo (solo lectura) -->
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-center rounded-3 border-0 bg-primary bg-opacity-10" role="alert">
                                    <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                    <span class="small text-primary">El saldo actual <strong>S/ {{ number_format($admin_cuentasbancaria->saldo_actual, 2) }}</strong> no se modifica desde aquí. Se actualiza automáticamente con los movimientos registrados.</span>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="col-12 mt-3">
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 shadow-sm flex-grow-1 fw-bold">
                                        <i class="bi bi-check2-circle me-2"></i>Guardar Cambios
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
    .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
    .form-control:focus, .form-select:focus {
        background-color: #f8f9fa !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
        border: 1px solid rgba(13, 110, 253, 0.2) !important;
    }
</style>
@endsection
