@extends('TEMPLATES.administrador')
@section('title', 'DETALLE DE PAGO')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DE PAGO</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-pagos.index') }}">Pagos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $orden->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-3">
            {{-- ====== COLUMNA IZQUIERDA ====== --}}
            <div class="{{ $saldoPendiente > 0.05 ? 'col-md-8' : 'col-md-12' }}">

                {{-- Información de la Orden de Compra --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Información de la Orden de Compra</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Código:</strong> {{ $orden->codigo }}</p>
                                <p class="mb-1"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($orden->fecha)->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Comprobante:</strong> {{ $orden->comprobante ?? 'N/A' }} {{ $orden->nro_comprobante ? '- ' . $orden->nro_comprobante : '' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Proveedor:</strong> {{ $orden->proveedor->persona->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Forma de Pago:</strong> {{ $orden->forma_pago ?? 'N/A' }}</p>
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
                                    <span class="text-muted small fw-bold">TOTAL OC</span>
                                    <span class="h3 mb-0 fw-bold">S/ {{ number_format($orden->total, 2) }}</span>
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
                        @php $porcentaje = $orden->total > 0 ? round(($totalPagado / $orden->total) * 100) : 0; @endphp
                        <div class="progress mt-3" style="height: 25px;">
                            <div class="progress-bar {{ $porcentaje >= 100 ? 'bg-success' : ($porcentaje >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                 role="progressbar" style="width: {{ min($porcentaje, 100) }}%;">
                                {{ $porcentaje }}% pagado
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cronograma de Cuotas --}}
                @if($orden->cuotas && $orden->cuotas->count() > 0)
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Cronograma de Cuotas ({{ $orden->cuotas->count() }})</h5>
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
                                    @foreach($orden->cuotas as $cuota)
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

                {{-- Detalle de Productos --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalle de la Orden</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">N°</th>
                                        <th>Descripción</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-end">P. Unit.</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orden->detallecompra as $index => $detalle)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $detalle->descripcion ?? $detalle->producto ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $detalle->cantidad }} {{ $detalle->umedida ? '('.$detalle->umedida.')' : '' }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->precio_unitario ?? $detalle->precio ?? 0, 2) }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->subtotal ?? ($detalle->cantidad * ($detalle->precio_unitario ?? $detalle->precio ?? 0)), 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">Sin detalle de productos registrado</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Historial de Pagos --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Pagos ({{ $orden->pagos->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($orden->pagos->count() > 0)
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
                                        @foreach($orden->pagos as $index => $pago)
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
                                <p class="text-muted mt-2 mb-0">No se han registrado pagos para esta orden</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ====== COLUMNA DERECHA (solo si hay saldo pendiente) ====== --}}
            @if($saldoPendiente > 0.05)
            <div class="col-md-4">

                    @php
                        $tieneCuotas = $orden->cuotas && $orden->cuotas->count() > 0;
                        $acumuladoCuota = 0;
                        $cuotasPendientes = collect();
                        if ($tieneCuotas) {
                            foreach ($orden->cuotas as $cuota) {
                                $acumuladoCuota += $cuota->importe;
                                if ($totalPagado < $acumuladoCuota - 0.05) {
                                    $cuotasPendientes->push($cuota);
                                }
                            }
                        }
                    @endphp

                    @if($tieneCuotas && $cuotasPendientes->count() > 0)
                        {{-- Pago por cuotas - mostrar todas --}}
                        {{-- Lista de cuotas seleccionables --}}
                        <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Cuotas Pendientes ({{ $cuotasPendientes->count() }})</h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach($cuotasPendientes as $index => $cuotaPend)
                                @php
                                    $esVencida = \Carbon\Carbon::parse($cuotaPend->fecha_vencimiento)->isPast();
                                    $esPrimera = $loop->first;
                                @endphp
                                <div class="p-3 {{ !$loop->last ? 'border-bottom' : '' }} {{ $esVencida ? 'bg-danger bg-opacity-10' : '' }} {{ !$esPrimera ? 'opacity-50' : '' }} cuota-item"
                                     data-monto="{{ $cuotaPend->importe }}"
                                     data-numero="{{ $cuotaPend->numero_cuota }}"
                                     data-habilitada="{{ $esPrimera ? '1' : '0' }}"
                                     style="cursor: {{ $esPrimera ? 'pointer' : 'not-allowed' }};">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Cuota {{ $cuotaPend->numero_cuota }}</strong>
                                            <span class="ms-2 text-muted small">Vence: {{ \Carbon\Carbon::parse($cuotaPend->fecha_vencimiento)->format('d/m/Y') }}</span>
                                            @if($esVencida)
                                                <span class="badge bg-danger ms-1">Vencida</span>
                                            @endif
                                            @if(!$esPrimera)
                                                <br><small class="text-muted"><i class="bi bi-lock me-1"></i>Pague la cuota anterior</small>
                                            @endif
                                        </div>
                                        <span class="fw-bold {{ $esPrimera ? 'text-primary' : 'text-muted' }}">S/ {{ number_format($cuotaPend->importe, 2) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Formulario único de pago (oculto hasta seleccionar cuota) --}}
                        <div class="card border-0 shadow-sm mb-3" id="formPagoCuota" style="display: none;">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bi bi-cash me-2"></i>Pagar <span id="lblCuotaSeleccionada"></span></h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <span class="text-muted small">Monto a pagar:</span>
                                    <h4 class="fw-bold text-primary mb-0" id="lblMontoCuota"></h4>
                                </div>
                                <form action="{{ route('admin-pagos.store', $orden) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="monto" id="inputMontoCuota" value="">
                                    <input type="hidden" name="numero_cuota" id="inputNumeroCuota" value="">
                                    @include('ADMINISTRADOR.FINANZAS._form_metodo_pago', ['mediosPago' => $mediosPago, 'cuentasBancarias' => $cuentasBancarias])
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-1"></i>Confirmar Pago
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Pago libre (contado o sin cuotas) --}}
                        <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Registrar Pago</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin-pagos.store', $orden) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Monto a Pagar <span class="text-danger">*</span></label>
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
                                        <i class="bi bi-check-circle me-2"></i>Registrar Pago
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                {{-- Botones --}}
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <a href="{{ route('admin-pagos.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver a Pagos
                        </a>
                        <a href="{{ route('admin-ordencompras.show', $orden) }}" class="btn btn-outline-primary w-100 mt-2">
                            <i class="bi bi-eye me-2"></i>Ver Orden de Compra
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        function detectarTipoMedio(texto) {
            texto = texto.toLowerCase().trim();
            if (texto.includes('transferencia') || texto.includes('depósito') || texto.includes('deposito') || texto.includes('banco') || texto.includes('billetera') || texto.includes('digital')) return 'banco';
            return 'otro';
        }

        // Seleccionar cuota
        $('.cuota-item').on('click', function() {
            if ($(this).data('habilitada') != 1) return;

            $('.cuota-item').removeClass('border border-primary border-2 rounded');
            $(this).addClass('border border-primary border-2 rounded');

            const monto = $(this).data('monto');
            const numero = $(this).data('numero');

            $('#lblCuotaSeleccionada').text('Cuota ' + numero);
            $('#lblMontoCuota').text('S/ ' + parseFloat(monto).toFixed(2));
            $('#inputMontoCuota').val(monto);
            $('#inputNumeroCuota').val(numero);
            $('#formPagoCuota').slideDown();
        });

        // Lógica de método de pago (aplica a todos los formularios)
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
