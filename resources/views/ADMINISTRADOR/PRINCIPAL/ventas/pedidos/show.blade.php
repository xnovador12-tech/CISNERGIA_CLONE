@extends('TEMPLATES.administrador')
@section('title', 'VER PEDIDO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DEL PEDIDO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-pedidos.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Ver Pedido</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        {{-- ====== MENSAJES FLASH ====== --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-x-circle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('warning') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-info-circle-fill fs-5"></i>
                <div>{{ session('info') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        {{-- ============================== --}}

        <div class="row g-3">
            <!-- Información del Pedido -->
            <div class="col-md-8">
                
                <!-- Indicador de Origen -->
                <div class="mb-3" data-aos="fade-up">
                    @if($pedido->origen === 'ecommerce')
                        <span class="badge bg-info fs-6">
                            <i class="bi bi-cart-check me-2"></i>Pedido E-commerce (Pago Online Confirmado)
                        </span>
                    @elseif($pedido->origen === 'cotizacion')
                        <span class="badge bg-primary fs-6">
                            <i class="bi bi-file-earmark-text me-2"></i>Pedido desde Cotización
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">
                            <i class="bi bi-briefcase me-2"></i>Pedido Manual (Proyecto B2B)
                        </span>
                    @endif
                </div>

                {{-- Nota de Stock (Solo si falló la reserva automática) --}}
                @if(!$pedido->aprobacion_stock && $pedido->estado === 'pendiente')
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-3 mb-3" data-aos="fade-up">
                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Atención: Stock insuficiente</h6>
                            <small>No se pudo reservar el stock automáticamente. Por favor, revisa el inventario y una vez abastecido vuelve a intentar la reserva.</small>
                            <form action="{{ route('admin-pedidos.aprobar-stock', $pedido) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-dark">Re-intentar reserva de stock</button>
                            </form>
                        </div>
                    </div>
                @endif


                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> {{ $pedido->codigo }}</p>
                                <p class="mb-1"><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Origen:</strong> 
                                    <span class="badge {{ $pedido->origen == 'ecommerce' ? 'bg-purple' : 'bg-secondary' }}">
                                        {{ ucfirst($pedido->origen) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Estado:</strong>
                                    @if($pedido->estado == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($pedido->estado == 'proceso')
                                        <span class="badge bg-info">En Proceso</span>
                                    @elseif($pedido->estado == 'entregado')
                                        <span class="badge bg-success">Entregado</span>
                                    @else
                                        <span class="badge bg-danger">Anulado / Cancelado</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Fecha Entrega:</strong> {{ $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : 'Sin fecha' }}</p>
                                <p class="mb-1"><strong>Vigencia:</strong> 
                                    <span class="badge bg-secondary">{{ $pedido->vigencia_dias ?? 15 }} días</span>
                                </p>
                                <p class="mb-1"><strong>Vendedor:</strong> {{ $pedido->usuario->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <!-- Cliente -->
                            <div class="col-md-6">
                                <h6 class="text-uppercase fw-bold mb-3">Cliente</h6>
                                <p class="mb-1"><strong>Nombre:</strong> {{ $pedido->cliente->nombre_completo ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Documento:</strong> {{ $pedido->cliente->documento ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Correo:</strong> {{ $pedido->cliente->email ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Teléfono:</strong> {{ $pedido->cliente->telefono ?? 'N/A' }}</p>
                            </div>

                            <!-- Instalación -->
                            <div class="col-md-6">
                                <h6 class="text-uppercase fw-bold mb-3">Instalación</h6>
                                <p class="mb-1"><strong>Dirección:</strong> {{ $pedido->direccion_instalacion ?? 'No especificada' }}</p>
                                <p class="mb-1"><strong>Distrito:</strong> {{ $pedido->distrito->nombre ?? 'No especificado' }}</p>
                                <p class="mb-1"><strong>Almacén:</strong> {{ $pedido->almacen->name ?? 'Sin asignar' }}</p>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="text-uppercase fw-bold mb-3">Información de Pago</h6>
                                <p class="mb-1">
                                    <strong>Condición de Pago:</strong> 
                                    <span class="badge {{ $pedido->condicion_pago == 'Contado' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $pedido->condicion_pago ?? 'Contado' }}
                                    </span>
                                </p>
                                
                                @if($pedido->condicion_pago === 'Crédito' && $pedido->cuotas && $pedido->cuotas->count() > 0)
                                <div class="mt-3 p-3 bg-light rounded border border-primary">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-calendar3 me-2"></i>Cronograma de Cuotas</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered bg-white mb-0">
                                            <thead class="table-light text-muted small">
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">N°</th>
                                                    <th>Fecha de Vencimiento</th>
                                                    <th class="text-end">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pedido->cuotas as $cuota)
                                                <tr>
                                                    <td class="text-center fw-bold text-muted">{{ $cuota->numero_cuota }}</td>
                                                    <td>{{ $cuota->fecha_vencimiento ? \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') : 'Sin fecha' }}</td>
                                                    <td class="text-end fw-bold">S/ {{ number_format($cuota->importe, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($pedido->observaciones)
                        <hr>
                        <h6 class="text-uppercase fw-bold mb-2">Observaciones</h6>
                        <p>{{ $pedido->observaciones }}</p>
                        @endif
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalles del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">P. Unit.</th>
                                    <th class="text-end">Desc.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>
                                        {{ $detalle->descripcion }}
                                        <br><small class="text-muted">Tipo: {{ ucfirst($detalle->tipo) }}</small>
                                        @if($detalle->subcategoria)
                                            <br><small class="text-muted">Subcategoría: {{ $detalle->subcategoria->name }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->descuento, 2) }}</td>
                                    <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen Financiero -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>S/ {{ number_format($pedido->subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <strong class="text-danger">- S/ {{ number_format($pedido->descuento, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>IGV (18%):</span>
                            <strong>S/ {{ number_format($pedido->igv, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h5 class="mb-0 text-primary">S/ {{ number_format($pedido->total, 2) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        @if($pedido->venta)
                            <a href="{{ route('admin-ventas.show', $pedido->venta) }}" class="btn btn-success w-100 mb-2">
                                <i class="bi bi-check-circle me-2"></i>Ver Comprobante: {{ $pedido->venta->codigo }}
                            </a>
                        @else
                            {{-- Botón de Pago (Finanzas) simplificado en Acciones --}}
                            @if(!$pedido->aprobacion_finanzas)
                                <form action="{{ route('admin-pedidos.aprobar-finanzas', $pedido) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 mb-2 py-2">
                                        <i class="bi bi-cash-coin me-2"></i>Confirmar Pago
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-success py-2 mb-2 text-center" style="font-size:0.85rem;">
                                    <i class="bi bi-check-all me-1"></i> Pago Verificado
                                    <form action="{{ route('admin-pedidos.aprobar-finanzas', $pedido) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none small" title="Revocar Pago">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalGenerarComprobante">
                                    <i class="bi bi-receipt me-2"></i>Generar Comprobante
                                </button>
                            @endif
                        @endif
                        <a href="{{ route('admin-pedidos.edit', $pedido) }}" class="btn btn-warning w-100 mb-2">
                            <i class="bi bi-pencil me-2"></i>Editar Pedido
                        </a>
                        <a href="{{ route('admin-pedidos.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Generar Comprobante -->
@if(!$pedido->venta)
    <div class="modal fade" id="modalGenerarComprobante" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Generar Comprobante de Venta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin-pedidos.generar-comprobante', $pedido) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            El comprobante heredará todos los datos del pedido <strong>{{ $pedido->codigo }}</strong>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tipo de Comprobante <span class="text-danger">*</span></label>
                            <select name="tiposcomprobante_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                @foreach(\App\Models\Tiposcomprobante::where('tipo', 'ventas')->get() as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Condición de Pago <span class="text-danger">*</span></label>
                                <select name="condicion_pago" id="condicion_pago" class="form-select" required>
                                    <option value="Contado" {{ $pedido->condicion_pago == 'Contado' ? 'selected' : '' }}>Al Contado</option>
                                    <option value="Crédito" {{ $pedido->condicion_pago == 'Crédito' ? 'selected' : '' }}>A Crédito</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Medio de Pago <span class="text-danger">*</span></label>
                                <select name="mediopago_id" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach(\App\Models\Mediopago::all() as $medio)
                                        <option value="{{ $medio->id }}">{{ $medio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- SECCIÓN CUOTAS (Oculta por defecto) -->
                        <div id="seccion_cuotas" class="mb-3 p-3 bg-light border rounded" style="display: none;">
                            <h6 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2"></i>Cronograma de Cuotas</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Total a financiar: <strong id="monto_financiar">S/ {{ number_format($pedido->total, 2, '.', '') }}</strong></small>
                                <small class="text-muted">Restante: <strong id="monto_restante" class="text-danger">S/ {{ number_format($pedido->total, 2, '.', '') }}</strong></small>
                            </div>
                            
                            <table class="table table-sm table-bordered bg-white" id="tabla_cuotas">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha de Venc.</th>
                                        <th>Importe (S/)</th>
                                        <th class="text-center"><i class="bi bi-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($pedido->condicion_pago === 'Crédito' && $pedido->cuotas && $pedido->cuotas->count() > 0)
                                        @foreach($pedido->cuotas as $index => $cuota)
                                            <tr>
                                                <td class="align-middle text-center fw-bold cuota-numero">{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="date" name="cuotas[{{ $index }}][fecha_vencimiento]" class="form-control form-control-sm" value="{{ $cuota->fecha_vencimiento }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" min="0.01" name="cuotas[{{ $index }}][importe]" class="form-control form-control-sm input-cuota-monto" value="{{ $cuota->importe }}" required>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-eliminar-cuota"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-grid mt-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="btn_agregar_cuota">
                                    <i class="bi bi-plus-circle me-1"></i>Agregar Cuota
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Número de Comprobante</label>
                            <input type="text" name="numero_comprobante" class="form-control" placeholder="Ej: F001-00001 (opcional)">
                            <small class="text-muted">Dejar vacío para generar automáticamente</small>
                        </div>

                        <hr>
                        <h6 class="fw-bold">Resumen del Pedido:</h6>
                        <table class="table table-sm">
                            <tr><td>Cliente:</td><td class="fw-bold">{{ $pedido->cliente->nombre_completo ?? 'N/A' }}</td></tr>
                            <tr><td>Subtotal:</td><td>S/ {{ number_format($pedido->subtotal, 2) }}</td></tr>
                            <tr><td>IGV:</td><td>S/ {{ number_format($pedido->igv, 2) }}</td></tr>
                            <tr class="table-primary"><td class="fw-bold">TOTAL:</td><td class="fw-bold">S/ {{ number_format($pedido->total, 2) }}</td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Generar Comprobante
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('js')
<script>
    $(document).ready(function() {
        const totalFacturar = parseFloat("{{ $pedido->total }}");
        let cuotaIndex = 0;

        $('#condicion_pago').on('change', function() {
            if ($(this).val() === 'Crédito') {
                $('#seccion_cuotas').slideDown();
                if(cuotaIndex === 0) {
                    agregarCuota(); 
                }
            } else {
                $('#seccion_cuotas').slideUp();
                $('#tabla_cuotas tbody').empty();
                cuotaIndex = 0;
            }
        });

        $('#btn_agregar_cuota').on('click', function() {
            agregarCuota();
        });

        $(document).on('input', '.input-cuota-monto', function() {
            calcularRestante();
        });

        $(document).on('click', '.btn-eliminar-cuota', function() {
            $(this).closest('tr').remove();
            reordenarCuotas();
            calcularRestante();
        });

        function agregarCuota() {
            // Calcular monto sugerido
            let sumaActual = 0;
            $('.input-cuota-monto').each(function() {
                sumaActual += parseFloat($(this).val() || 0);
            });
            let montoSugerido = totalFacturar - sumaActual;
            if(montoSugerido < 0) montoSugerido = 0;

            const tr = `
                <tr>
                    <td class="align-middle text-center fw-bold cuota-numero">${cuotaIndex + 1}</td>
                    <td>
                        <input type="date" name="cuotas[${cuotaIndex}][fecha_vencimiento]" class="form-control form-control-sm" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" min="0.01" name="cuotas[${cuotaIndex}][importe]" class="form-control form-control-sm input-cuota-monto" value="${montoSugerido.toFixed(2)}" required>
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-eliminar-cuota"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#tabla_cuotas tbody').append(tr);
            cuotaIndex++;
            calcularRestante();
        }

        function reordenarCuotas() {
            $('#tabla_cuotas tbody tr').each(function(index) {
                $(this).find('.cuota-numero').text(index + 1);
                $(this).find('input[type="date"]').attr('name', `cuotas[${index}][fecha_vencimiento]`);
                $(this).find('input[type="number"]').attr('name', `cuotas[${index}][importe]`);
            });
            cuotaIndex = $('#tabla_cuotas tbody tr').length;
        }

        function calcularRestante() {
            let suma = 0;
            $('.input-cuota-monto').each(function() {
                suma += parseFloat($(this).val() || 0);
            });
            
            let restante = totalFacturar - suma;
            let ext = restante < 0 ? 'text-danger' : (restante === 0 ? 'text-success' : 'text-warning');
            
            $('#monto_restante').removeClass('text-danger text-success text-warning').addClass(ext).text('S/ ' + restante.toFixed(2));
        }

        // Validación al enviar el formulario si es crédito
        $('#modalGenerarComprobante form').on('submit', function(e) {
            if ($('#condicion_pago').val() === 'Crédito') {
                let suma = 0;
                $('.input-cuota-monto').each(function() {
                    suma += parseFloat($(this).val() || 0);
                });
                
                // Permitir una pequeña tolerancia por redondeo
                if (Math.abs(suma - totalFacturar) > 0.1) {
                    e.preventDefault();
                    alert('La suma de las cuotas (S/ ' + suma.toFixed(2) + ') debe ser exactamente igual al total a facturar (S/ ' + totalFacturar.toFixed(2) + ').');
                }
            }
        });
    });
</script>
@endsection
