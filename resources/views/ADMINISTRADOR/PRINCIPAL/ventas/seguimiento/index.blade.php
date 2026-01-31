@extends('TEMPLATES.administrador')
@section('title', 'SEGUIMIENTO')

@section('css')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">SEGUIMIENTO DE VENTAS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">Ventas</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Seguimiento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Pedidos del Mes</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $totalPedidos }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cart fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Ventas del Mes</p>
                                <h3 class="mb-0 fw-bold text-success">{{ $totalVentas }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-cash-coin fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Facturación</p>
                                <h3 class="mb-0 fw-bold text-info">S/ {{ number_format($facturacionMes, 2) }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-graph-up fs-3 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Ticket Promedio</p>
                                <h3 class="mb-0 fw-bold text-warning">S/ {{ number_format($ticketPromedio, 2) }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-tag fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila de KPIs -->
        <div class="row g-3 mt-2" data-aos="fade-up">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Tasa de Conversión (Pedidos → Ventas)</p>
                                <h4 class="mb-0 fw-bold text-purple">{{ number_format($tasaConversion, 2) }}%</h4>
                            </div>
                            <div class="progress" style="width: 60%; height: 30px;">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $tasaConversion }}%">
                                    {{ number_format($tasaConversion, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Estadísticas -->
    <div class="container-fluid">
        <div class="row g-3">
            <!-- Gráfico de Ventas -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Ventas Últimos 30 Días</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartVentas" height="80"></canvas>
                    </div>
                </div>

                <!-- Pedidos Recientes -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Pedidos Recientes</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th class="text-end">Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidosRecientes as $pedido)
                                <tr>
                                    <td><a href="{{ route('admin-pedidos.show', $pedido) }}">{{ $pedido->codigo }}</a></td>
                                    <td>{{ $pedido->cliente->name ?? 'N/A' }}</td>
                                    <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">S/ {{ number_format($pedido->total, 2) }}</td>
                                    <td>
                                        @if($pedido->estado == 'pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($pedido->estado == 'entregado')
                                            <span class="badge bg-success">Entregado</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($pedido->estado) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Laterales -->
            <div class="col-md-4">
                <!-- Pedidos por Estado -->
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Pedidos por Estado</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chartEstados" height="180"></canvas>
                    </div>
                </div>

                <!-- Top Productos -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Top 5 Productos</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($topProductos as $producto)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $producto->name }}
                                <span class="badge bg-primary rounded-pill">{{ $producto->total_vendido }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Ventas Recientes -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ventas Recientes</h5>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @foreach($ventasRecientes as $venta)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <strong><a href="{{ route('admin-ventas.show', $venta) }}">{{ $venta->codigo }}</a></strong><br>
                                <small class="text-muted">{{ $venta->cliente->name ?? 'N/A' }}</small>
                            </div>
                            <div class="text-end">
                                <strong class="text-success">S/ {{ number_format($venta->total, 2) }}</strong><br>
                                <small class="text-muted">{{ $venta->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    // Gráfico de Ventas Diarias
    const ctxVentas = document.getElementById('chartVentas').getContext('2d');
    const ventasDiarias = @json($ventasDiarias);
    
    new Chart(ctxVentas, {
        type: 'line',
        data: {
            labels: ventasDiarias.map(v => v.fecha),
            datasets: [{
                label: 'Facturación (S/)',
                data: ventasDiarias.map(v => v.total),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            }, {
                label: 'Cantidad de Ventas',
                data: ventasDiarias.map(v => v.cantidad),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left'
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Gráfico de Pedidos por Estado
    const ctxEstados = document.getElementById('chartEstados').getContext('2d');
    const pedidosEstado = @json($pedidosPorEstado);
    
    new Chart(ctxEstados, {
        type: 'doughnut',
        data: {
            labels: pedidosEstado.map(p => p.estado.charAt(0).toUpperCase() + p.estado.slice(1)),
            datasets: [{
                data: pedidosEstado.map(p => p.total),
                backgroundColor: [
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
