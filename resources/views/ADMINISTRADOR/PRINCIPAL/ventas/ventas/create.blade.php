@extends('TEMPLATES.administrador')
@section('title', 'REGISTRAR VENTA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">REGISTRAR VENTA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-ventas.index') }}">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Registrar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('admin-ventas.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm" data-aos="fade-up">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información de la Venta</h5>
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
                                    <label class="form-label">Tipo de Venta <span class="text-danger">*</span></label>
                                    <select name="tipo_venta" id="tipo_venta" class="form-select" required>
                                        <option value="pos">POS - Venta Directa</option>
                                        <option value="pedido">Facturación de Pedido</option>
                                    </select>
                                </div>

                                <div class="col-md-6" id="pedido_field" style="display: none;">
                                    <label class="form-label">Pedido Relacionado</label>
                                    <select name="pedido_id" class="form-select">
                                        <option value="">Seleccione pedido</option>
                                        @foreach($pedidos as $pedido)
                                            <option value="{{ $pedido->id }}">{{ $pedido->codigo }} - {{ $pedido->cliente->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Proyecto</label>
                                    <select name="tipo_proyecto" class="form-select">
                                        <option value="">Seleccione tipo</option>
                                        <option value="residencial">Residencial</option>
                                        <option value="comercial">Comercial</option>
                                        <option value="industrial">Industrial</option>
                                        <option value="agricola">Agrícola</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Potencia Instalada (kW)</label>
                                    <input type="number" name="potencia_kw" class="form-control" step="0.01" value="{{ old('potencia_kw') }}" placeholder="Ej: 15.50">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Consumo Mensual Cliente (kWh)</label>
                                    <input type="number" name="consumo_mensual_kwh" class="form-control" step="0.01" value="{{ old('consumo_mensual_kwh') }}" placeholder="Ej: 1200">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Instalación</label>
                                    <input type="date" name="fecha_instalacion" class="form-control" value="{{ old('fecha_instalacion') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Garantía Sistema (años)</label>
                                    <input type="number" name="garantia_sistema_años" class="form-control" value="{{ old('garantia_sistema_años', 10) }}" placeholder="10">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Número de Proyecto</label>
                                    <input type="text" name="numero_proyecto" class="form-control" value="{{ old('numero_proyecto') }}" placeholder="PRY-2026-001">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">¿Requiere Financiamiento?</label>
                                    <select name="requiere_financiamiento" id="requiere_financiamiento" class="form-select">
                                        <option value="0">No</option>
                                        <option value="1">Sí</option>
                                    </select>
                                </div>

                                <div class="col-md-6" id="monto_financiado_field" style="display: none;">
                                    <label class="form-label">Monto Financiado</label>
                                    <input type="number" name="monto_financiado" class="form-control" step="0.01" value="{{ old('monto_financiado') }}">
                                </div>

                                <div class="col-md-6" id="entidad_field" style="display: none;">
                                    <label class="form-label">Entidad Financiera</label>
                                    <input type="text" name="entidad_financiera" class="form-control" value="{{ old('entidad_financiera') }}" placeholder="Ej: Banco BCP">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Comprobante <span class="text-danger">*</span></label>
                                    <select name="tiposcomprobante_id" class="form-select @error('tiposcomprobante_id') is-invalid @enderror" required>
                                        <option value="">Seleccione tipo</option>
                                        @foreach($tiposcomprobantes as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tiposcomprobante_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Número de Comprobante</label>
                                    <input type="text" name="numero_comprobante" class="form-control" value="{{ old('numero_comprobante') }}" placeholder="Ej: F001-0001234">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Medio de Pago <span class="text-danger">*</span></label>
                                    <select name="mediopago_id" class="form-select @error('mediopago_id') is-invalid @enderror" required>
                                        <option value="">Seleccione medio</option>
                                        @foreach($mediospago as $medio)
                                            <option value="{{ $medio->id }}">{{ $medio->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('mediopago_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Totales</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" class="form-control" step="0.01" value="{{ old('subtotal', 0) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descuento</label>
                                <input type="number" name="descuento" class="form-control" step="0.01" value="{{ old('descuento', 0) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IGV (18%)</label>
                                <input type="number" name="igv" class="form-control" step="0.01" value="{{ old('igv', 0) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Total</strong></label>
                                <input type="number" name="total" class="form-control" step="0.01" value="{{ old('total', 0) }}" required>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-save me-2"></i>Registrar Venta
                            </button>
                            <a href="{{ route('admin-ventas.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Mostrar/ocultar campo de pedido según tipo de venta
        $('#tipo_venta').on('change', function() {
            if ($(this).val() === 'pedido') {
                $('#pedido_field').show();
            } else {
                $('#pedido_field').hide();
            }
        });

        // Mostrar/ocultar campos de financiamiento
        $('#requiere_financiamiento').on('change', function() {
            if ($(this).val() === '1') {
                $('#monto_financiado_field').show();
                $('#entidad_field').show();
            } else {
                $('#monto_financiado_field').hide();
                $('#entidad_field').hide();
            }
        });
    });
</script>
@endsection
