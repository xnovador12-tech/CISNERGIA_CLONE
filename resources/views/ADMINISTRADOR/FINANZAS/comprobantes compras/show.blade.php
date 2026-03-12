@extends('TEMPLATES.administrador')

@section('title', 'Detalle de Comprobante de Compra')

@section('css')
    <style>
        .detail-card { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); }
        .detail-header { border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; }
        .voucher-type { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 1px; }
        .voucher-number { font-size: 1.5rem; font-weight: 900; color: #1e293b; margin: 0.25rem 0; }
        .status-badge { padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .status-completada { background: #d1fae5; color: #065f46; }

        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
        .info-item label { display: block; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.5rem; }
        .info-item p { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0; }

        .table-custom thead th { background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; padding: 1rem; border: none; }
        .table-custom tbody td { padding: 1.25rem 1rem; color: #475569; font-weight: 500; border-bottom: 1px solid #f1f5f9; }

        .summary-box { background: #f8fafc; border-radius: 12px; padding: 1.5rem; margin-top: 2rem; width: 300px; margin-left: auto; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.9rem; font-weight: 600; }
        .summary-total { border-top: 2px solid #e2e8f0; padding-top: 1rem; margin-top: 1rem; font-size: 1.2rem; font-weight: 900; color: #2563eb; }
    </style>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin-comprobantes-compras.index') }}">Comprobantes Compras</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
                    </ol>
                </nav>
                <a href="{{ route('admin-comprobantes-compras.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Listado
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-2 mb-5">
        <div class="detail-card shadow-sm border-0">
            <div class="detail-header">
                <div>
                    <span class="voucher-type">{{ $admin_comprobantes_compra->tipocomprobante?->name }}</span>
                    <h2 class="voucher-number">{{ $admin_comprobantes_compra->numero_comprobante }}</h2>
                    <p class="text-muted small mb-0"><i class="bi bi-calendar3 me-1"></i> Registrado el: {{ $admin_comprobantes_compra->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-end">
                    <span class="status-badge status-{{ $admin_comprobantes_compra->estado }}">
                        {{ $admin_comprobantes_compra->estado }}
                    </span>
                    <p class="mt-2 fw-bold text-dark mb-0">Código Interno: {{ $admin_comprobantes_compra->codigo }}</p>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Proveedor</label>
                    <p>{{ $admin_comprobantes_compra->proveedor?->persona?->name }}</p>
                    <small class="text-muted">{{ $admin_comprobantes_compra->proveedor?->persona?->identificacion }}: {{ $admin_comprobantes_compra->proveedor?->persona?->nro_identificacion }}</small>
                </div>
                <div class="info-item">
                    <label>Orden de Compra</label>
                    <p>{{ $admin_comprobantes_compra->ordencompra?->codigo ?? 'N/A' }}</p>
                </div>
                <div class="info-item">
                    <label>Condición de Pago</label>
                    <p>{{ $admin_comprobantes_compra->condicion_pago }}</p>
                </div>
                <div class="info-item">
                    <label>Moneda</label>
                    <p>{{ $admin_comprobantes_compra->moneda_id == 1 ? 'Soles (S/)' : 'Dólares ($)' }}</p>
                </div>
            </div>

            <h5 class="fw-bold mb-3"><i class="bi bi-list-ul me-2"></i>Detalle de Productos / Servicios</h5>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">IGV</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admin_comprobantes_compra->detalles as $det)
                            <tr>
                                <td>{{ $det->descripcion }}</td>
                                <td class="text-center">{{ number_format($det->cantidad, 2) }}</td>
                                <td class="text-end">S/ {{ number_format($det->precio_unitario, 2) }}</td>
                                <td class="text-end">S/ {{ number_format($det->igv, 2) }}</td>
                                <td class="text-end fw-bold">S/ {{ number_format($det->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="summary-box">
                <div class="summary-row text-muted">
                    <span>Subtotal</span>
                    <span>S/ {{ number_format($admin_comprobantes_compra->subtotal, 2) }}</span>
                </div>
                <div class="summary-row text-muted">
                    <span>IGV (18%)</span>
                    <span>S/ {{ number_format($admin_comprobantes_compra->igv, 2) }}</span>
                </div>
                <div class="summary-total">
                    <span>TOTAL</span>
                    <span>S/ {{ number_format($admin_comprobantes_compra->total, 2) }}</span>
                </div>
            </div>

            @if($admin_comprobantes_compra->observaciones)
                <div class="mt-4 p-3 bg-light rounded">
                    <label class="info-item label">Observaciones:</label>
                    <p class="mb-0 small text-muted italic">{{ $admin_comprobantes_compra->observaciones }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
