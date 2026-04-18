@extends('TEMPLATES.administrador')
@section('title', 'DETALLE NOTA')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">DETALLE DE LA NOTA</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-nota-ventas.index') }}">Notas NC/ND</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $nota->numero_comprobante }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        $esNC = $nota->tipocomprobante?->codigo === '07';
        $ventaOriginal = $nota->ventaReferencia?->ventaReferenciada;
        $motivoNota = $nota->ventaReferencia?->sunatMotivoNota;
    @endphp

    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-md-8">

                {{-- Información de la Nota --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header {{ $esNC ? 'bg-danger' : 'bg-info' }} text-white">
                        <h5 class="mb-0">
                            <i class="bi {{ $esNC ? 'bi-dash-circle' : 'bi-plus-circle' }} me-2"></i>
                            {{ $esNC ? 'Nota de Credito' : 'Nota de Debito' }} - {{ $nota->numero_comprobante }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>N° Comprobante:</strong> {{ $nota->numero_comprobante }}</p>
                                <p class="mb-1"><strong>Codigo:</strong> {{ $nota->codigo }}</p>
                                <p class="mb-1"><strong>Tipo:</strong>
                                    @if($esNC)
                                        <span class="badge bg-danger">Nota de Credito</span>
                                    @else
                                        <span class="badge bg-info">Nota de Debito</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Fecha Emision:</strong> {{ $nota->created_at->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Emitido por:</strong> {{ $nota->usuario?->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    @if($nota->estado === 'emitida')
                                        <span class="badge bg-success">Emitida</span>
                                    @else
                                        <span class="badge bg-secondary">Anulada</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Motivo:</strong></p>
                                @if($motivoNota)
                                    <p class="mb-1">
                                        <span class="badge bg-warning text-dark">{{ $motivoNota->codigo }}</span>
                                        {{ $motivoNota->descripcion }}
                                    </p>
                                @endif
                                @if($nota->observaciones)
                                    <p class="mb-1"><strong>Observaciones:</strong> {{ $nota->observaciones }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Comprobante Afectado --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Comprobante Afectado</h5>
                    </div>
                    <div class="card-body">
                        @if($ventaOriginal)
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>N° Comprobante:</strong>
                                        <a href="{{ route('admin-comprobantes-finanzas.show', $ventaOriginal) }}" class="text-decoration-none">
                                            {{ $ventaOriginal->numero_comprobante }}
                                        </a>
                                    </p>
                                    <p class="mb-1"><strong>Tipo:</strong>
                                        @if($ventaOriginal->tipocomprobante?->codigo == '01')
                                            <span class="badge bg-info">Factura</span>
                                        @else
                                            <span class="badge bg-success">Boleta</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Cliente:</strong> {{ $ventaOriginal->cliente?->nombre ?? '' }} {{ $ventaOriginal->cliente?->apellidos ?? '' }}</p>
                                    <p class="mb-1"><strong>Documento:</strong> {{ $ventaOriginal->cliente?->documento ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Fecha Emisión:</strong> {{ $ventaOriginal->created_at->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Total Original:</strong> <span class="fw-bold text-primary">S/ {{ number_format($ventaOriginal->total, 2) }}</span></p>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">Sin comprobante referenciado.</p>
                        @endif
                    </div>
                </div>

                {{-- Resumen Financiero --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <span class="text-muted small">Subtotal</span>
                                <h4 class="mb-0 fw-bold">S/ {{ number_format($nota->subtotal, 2) }}</h4>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted small">IGV (18%)</span>
                                <h4 class="mb-0 fw-bold">S/ {{ number_format($nota->igv, 2) }}</h4>
                            </div>
                            <div class="col-md-4">
                                <span class="{{ $esNC ? 'text-danger' : 'text-info' }} small fw-bold">TOTAL</span>
                                <h3 class="mb-0 fw-bold {{ $esNC ? 'text-danger' : 'text-info' }}">S/ {{ number_format($nota->total, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detalle de Items --}}
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Detalle de Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">N°</th>
                                        <th>Descripcion</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">P. Unit.</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nota->detalles as $index => $detalle)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $detalle->descripcion }}</td>
                                        <td class="text-center">{{ $detalle->cantidad }}</td>
                                        <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="text-end fw-bold">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ====== COLUMNA DERECHA ====== --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3" data-aos="fade-up">
                    <div class="card-body">
                        <a href="{{ route('admin-nota-ventas.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="bi bi-arrow-left me-2"></i>Volver a Notas
                        </a>
                        @if($ventaOriginal)
                            <a href="{{ route('admin-comprobantes-finanzas.show', $ventaOriginal) }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-receipt me-2"></i>Ver Comprobante Original
                            </a>
                        @endif
                        @if($nota->estado === 'emitida')
                            <form action="{{ route('admin-nota-ventas.anular', $nota) }}" method="POST"
                                  onsubmit="return confirm('¿Está seguro de anular esta nota? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-x-circle me-2"></i>Anular Nota
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
