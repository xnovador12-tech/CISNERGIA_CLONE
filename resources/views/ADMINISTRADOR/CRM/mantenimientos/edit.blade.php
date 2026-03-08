@extends('TEMPLATES.administrador')
@section('title', 'Editar Mantenimiento ' . $mantenimiento->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR {{ $mantenimiento->codigo }}</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.mantenimientos.index') }}">Mantenimientos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar {{ $mantenimiento->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- Alerta informativa --}}
                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <div>
                        Solo puedes modificar los datos logísticos del mantenimiento.
                        Los datos finales (hallazgos, costos, evidencias) se registran al <strong>completar</strong>.
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 15px">
                    <div class="card-header bg-transparent py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <h5 class="fw-bold mb-0">{{ $mantenimiento->titulo }}</h5>
                                <small class="text-muted">
                                    <span class="badge bg-secondary me-1">{{ $mantenimiento->codigo }}</span>
                                    {{ ucfirst($mantenimiento->tipo) }}
                                    @if($mantenimiento->ticket)
                                        · Ticket <a href="{{ route('admin.crm.tickets.show', $mantenimiento->ticket) }}" class="text-decoration-none">{{ $mantenimiento->ticket->codigo }}</a>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admin.crm.mantenimientos.update', $mantenimiento) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="alert alert-danger mb-3">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-3">

                                {{-- Fecha programada --}}
                                <div class="col-md-6">
                                    <label for="fecha_programada" class="form-label fw-bold">
                                        Fecha Programada <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="fecha_programada" id="fecha_programada"
                                           class="form-control @error('fecha_programada') is-invalid @enderror"
                                           value="{{ old('fecha_programada', $mantenimiento->fecha_programada->format('Y-m-d')) }}" required>
                                    @error('fecha_programada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Hora programada --}}
                                <div class="col-md-6">
                                    <label for="hora_programada" class="form-label fw-bold">Hora Programada</label>
                                    <input type="time" name="hora_programada" id="hora_programada"
                                           class="form-control @error('hora_programada') is-invalid @enderror"
                                           value="{{ old('hora_programada', $mantenimiento->hora_programada ? $mantenimiento->hora_programada->format('H:i') : '') }}">
                                    @error('hora_programada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Técnico --}}
                                <div class="col-12">
                                    <label for="tecnico_id" class="form-label fw-bold">Técnico Asignado</label>
                                    <select name="tecnico_id" id="tecnico_id"
                                            class="form-select select2_bootstrap_2 @error('tecnico_id') is-invalid @enderror">
                                        <option value="">Sin asignar</option>
                                        @foreach($tecnicos as $tecnico)
                                            <option value="{{ $tecnico->id }}"
                                                {{ old('tecnico_id', $mantenimiento->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                                {{ $tecnico->persona?->name ?? $tecnico->email }}
                                                {{ $tecnico->persona?->surnames ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tecnico_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Dirección --}}
                                <div class="col-12">
                                    <label for="direccion" class="form-label fw-bold">
                                        Dirección <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="direccion" id="direccion"
                                           class="form-control @error('direccion') is-invalid @enderror"
                                           value="{{ old('direccion', $mantenimiento->direccion) }}"
                                           placeholder="Dirección donde se realizará el mantenimiento" required>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Notas internas --}}
                                <div class="col-12">
                                    <label for="notas_internas" class="form-label fw-bold">Notas Internas</label>
                                    <textarea name="notas_internas" id="notas_internas"
                                              class="form-control @error('notas_internas') is-invalid @enderror"
                                              rows="3" placeholder="Notas visibles solo para el equipo interno...">{{ old('notas_internas', $mantenimiento->notas_internas) }}</textarea>
                                    @error('notas_internas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                                <a href="{{ route('admin.crm.mantenimientos.show', $mantenimiento) }}"
                                   class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancelar
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
