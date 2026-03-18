@extends('TEMPLATES.administrador')
@section('title', 'DETALLE DE COBRO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DE COBRO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-cobros.index') }}">Cobros</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $venta->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            {{-- ====== COLUMNA IZQUIERDA ====== --}}
            <div class="col-md-8">

                {{-- Información de la Venta --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> {{ $venta->codigo }}</p>
                                <p class="mb-1"><strong>Comprobante:</strong> {{ $venta->tipocomprobante->name ?? 'N/A' }} - {{ $venta->numero_comprobante }}</p>
                                <p class="mb-1"><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Vendedor:</strong> {{ $venta->usuario->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Cliente:</strong> {{ $venta->cliente->nombre_completo ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Documento:</strong> {{ $venta->cliente->documento ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Condición:</strong>
                                    <span class="badge {{ $venta->condicion_pago == 'Crédito' ? 'bg-info' : 'bg-secondary' }}">{{ $venta->condicion_pago }}</span>
                                </p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    @if($saldoPendiente <= 0.05)
                                        <span class="badge bg-success">Pagado</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resumen Financiero --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <span class="text-muted small fw-bold">TOTAL VENTA</span>
                                    <span class="h3 mb-0 fw-bold">S/ {{ number_format($venta->total, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <span class="text-primary small fw-bold">TOTAL PAGADO</span>
                                    <span class="h3 mb-0 fw-bold text-primary">S/ {{ number_format($totalPagado, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <span class="{{ $saldoPendiente > 0.05 ? 'text-danger' : 'text-success' }} small fw-bold">SALDO PENDIENTE</span>
                                    <span class="h3 mb-0 fw-bold {{ $saldoPendiente > 0.05 ? 'text-danger' : 'text-success' }}">S/ {{ number_format(max(0, $saldoPendiente), 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @php $porcentaje = $venta->total > 0 ? round(($totalPagado / $venta->total) * 100) : 0; @endphp
                        <div class="progress mt-3" style="height: 25px;">
                            <div class="progress-bar {{ $porcentaje >= 100 ? 'bg-success' : ($porcentaje >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                 role="progressbar" style="width: {{ min($porcentaje, 100) }}%;">
                                {{ $porcentaje }}% cobrado
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cronograma de Cuotas (solo crédito) --}}
                @if($venta->condicion_pago == 'Crédito' && $venta->cuotas && $venta->cuotas->count() > 0)
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Cronograma de Cuotas ({{ $venta->cuotas->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center small text-uppercase fw-bold">N°</th>
                                        <th class="small text-uppercase fw-bold">Fecha Vencimiento</th>
                                        <th class="text-end small text-uppercase fw-bold">Importe</th>
                                        <th class="text-center small text-uppercase fw-bold">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $acumulado = 0; @endphp
                                    @foreach($venta->cuotas as $cuota)
                                    @php
                                        $acumulado += $cuota->importe;
                                        $cuotaPagada = $totalPagado >= $acumulado - 0.05;
                                        $vencida = !$cuotaPagada && \Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast();
                                    @endphp
                                    <tr class="{{ $vencida ? 'table-danger' : '' }}">
                                        <td class="text-center fw-bold">{{ $cuota->numero_cuota }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                            @if($vencida)
                                                <span class="badge bg-danger ms-1">Vencida</span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold">S/ {{ number_format($cuota->importe, 2) }}</td>
                                        <td class="text-center">
                                            @if($cuotaPagada)
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Pagada</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pendiente</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Historial de Pagos --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Pagos ({{ $venta->pagos->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($venta->pagos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center small text-uppercase fw-bold">N°</th>
                                            <th class="small text-uppercase fw-bold">Fecha</th>
                                            <th class="small text-uppercase fw-bold">Método de Pago</th>
                                            <th class="small text-uppercase fw-bold">Detalle</th>
                                            <th class="text-end small text-uppercase fw-bold">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($venta->pagos as $index => $pago)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($pago->fecha_movimiento)->format('d/m/Y') }}
                                                <br><small class="text-muted">{{ $pago->hora_movimiento }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $pago->metodoPago->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if($pago->cuentaBancaria && $pago->cuentaBancaria->banco)
                                                    <small>{{ $pago->cuentaBancaria->banco->name }} - {{ $pago->cuentaBancaria->numero_cuenta }}</small>
                                                @endif
                                                @if($pago->numero_operacion)
                                                    <br><small class="text-muted">Op: {{ $pago->numero_operacion }}</small>
                                                @endif
                                                @if($pago->descripcion)
                                                    <br><small class="text-muted">{{ $pago->descripcion }}</small>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold text-success">S/ {{ number_format($pago->monto, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">TOTAL PAGADO:</td>
                                            <td class="text-end fw-bold text-primary">S/ {{ number_format($totalPagado, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2 mb-0">No se han registrado pagos para esta venta</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ====== COLUMNA DERECHA ====== --}}
            <div class="col-md-4">

                {{-- Formulario Registrar Cobro --}}
                @if($saldoPendiente > 0.05)
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Registrar Cobro</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin-cobros.store', $venta) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Monto a Cobrar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" step="0.01" min="0.01" max="{{ number_format($saldoPendiente, 2, '.', '') }}"
                                           name="monto" class="form-control"
                                           value="{{ number_format($saldoPendiente, 2, '.', '') }}" required>
                                </div>
                                <small class="text-muted">Saldo pendiente: S/ {{ number_format($saldoPendiente, 2) }}</small>
                            </div>
                            @include('ADMINISTRADOR.FINANZAS._form_metodo_pago', ['mediosPago' => $mediosPago, 'cuentasBancarias' => $cuentasBancarias])
                            <button type="submit" class="btn btn-success w-100 py-2 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Registrar Cobro
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-success fw-bold">Venta Pagada</h5>
                        <p class="text-muted mb-0">Esta venta no tiene saldo pendiente.</p>
                    </div>
                </div>
                @endif

                {{-- Botón Volver --}}
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <a href="{{ route('admin-cobros.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver a Cobros
                        </a>
                        <a href="{{ route('admin-ventas.show', $venta) }}" class="btn btn-outline-primary w-100 mt-2">
                            <i class="bi bi-eye me-2"></i>Ver Venta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(document).on('change', '.select-metodo-pago', function() {
            const $form = $(this).closest('form');
            const texto = $(this).find('option:selected').data('tipo') || '';

            const $billetera = $form.find('.div-billetera');
            const $cuenta = $form.find('.div-cuenta-bancaria');

            if (texto.includes('billetera') || texto.includes('digital')) {
                $billetera.slideDown();
                $cuenta.slideDown();
            } else if (texto.includes('transferencia') || texto.includes('depósito') || texto.includes('deposito')) {
                $billetera.slideUp().find('select').val('');
                $cuenta.slideDown();
            } else {
                $billetera.slideUp().find('select').val('');
                $cuenta.slideUp().find('select').val('');
            }
        });
    });
</script>
@endsection
