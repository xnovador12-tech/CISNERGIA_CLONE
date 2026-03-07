@extends('TEMPLATES.administrador')
@section('title', 'EDITAR PEDIDO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR PEDIDO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-pedidos.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin-pedidos.update', $pedido) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Información</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                    <select name="cliente_id" class="form-select" required>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ $pedido->cliente_id == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre_completo }} - {{ $cliente->documento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select name="estado" class="form-select" required>
                                        <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmado" {{ $pedido->estado == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                        <option value="proceso" {{ $pedido->estado == 'proceso' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha Entrega Estimada</label>
                                    <input type="date" name="fecha_entrega_estimada" class="form-control" value="{{ $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('Y-m-d') : '' }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Dirección de Instalación</label>
                                    <input type="text" name="direccion_instalacion" class="form-control" value="{{ $pedido->direccion_instalacion }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Distrito</label>
                                    <select name="distrito_id" class="form-select">
                                        <option value="">Seleccione distrito</option>
                                        @foreach($distritos as $distrito)
                                            <option value="{{ $distrito->id }}" {{ $pedido->distrito_id == $distrito->id ? 'selected' : '' }}>
                                                {{ $distrito->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Almacén</label>
                                    <select name="almacen_id" class="form-select">
                                        <option value="">Seleccione almacén</option>
                                        @foreach($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}" {{ $pedido->almacen_id == $almacen->id ? 'selected' : '' }}>
                                                {{ $almacen->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" class="form-control" rows="3">{{ $pedido->observaciones }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Código:</strong> {{ $pedido->codigo }}</p>
                            <p><strong>Fecha Creación:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Total:</strong> <span class="text-primary">S/ {{ number_format($pedido->total, 2) }}</span></p>

                            <hr>

                            <button type="submit" class="btn btn-warning w-100 mb-2">
                                <i class="bi bi-save me-2"></i>Actualizar Pedido
                            </button>
                            <a href="{{ route('admin-pedidos.show', $pedido) }}" class="btn btn-secondary w-100">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
