@extends('TEMPLATES.administrador')
@section('title', 'CREAR PEDIDO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">CREAR PEDIDO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-pedidos.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Crear</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin-pedidos.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                    <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }} - {{ $cliente->documento }}</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha Entrega Estimada</label>
                                    <input type="date" name="fecha_entrega_estimada" class="form-control" value="{{ old('fecha_entrega_estimada') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Dirección de Instalación</label>
                                    <input type="text" name="direccion_instalacion" class="form-control" value="{{ old('direccion_instalacion') }}" placeholder="Dirección completa">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Distrito</label>
                                    <select name="distrito_id" class="form-select">
                                        <option value="">Seleccione distrito</option>
                                        @foreach($distritos as $distrito)
                                            <option value="{{ $distrito->id }}">{{ $distrito->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Técnico Asignado</label>
                                    <select name="tecnico_asignado_id" class="form-select">
                                        <option value="">Sin asignar</option>
                                        @foreach($tecnicos as $tecnico)
                                            <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Almacén</label>
                                    <select name="almacen_id" class="form-select">
                                        <option value="">Seleccione almacén</option>
                                        @foreach($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}">{{ $almacen->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones adicionales">{{ old('observaciones') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Totales</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" class="form-control" step="0.01" value="{{ old('subtotal', 0) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descuento</label>
                                <input type="number" name="descuento" class="form-control" step="0.01" value="{{ old('descuento', 0) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IGV (18%)</label>
                                <input type="number" name="igv" class="form-control" step="0.01" value="{{ old('igv', 0) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Total</strong></label>
                                <input type="number" name="total" class="form-control" step="0.01" value="{{ old('total', 0) }}" required>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-save me-2"></i>Guardar Pedido
                            </button>
                            <a href="{{ route('admin-pedidos.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
