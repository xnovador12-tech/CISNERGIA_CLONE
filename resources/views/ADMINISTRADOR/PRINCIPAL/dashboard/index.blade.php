@extends('TEMPLATES.administrador')

@section('title', 'DASHBOARD')

@section('css')
@endsection
 
@section('content')
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0"> DASHBOARD</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin encabezado-->

    {{-- Contenido --}}
    <div class="container-fluid">
        
        <!-- Navegación de Pestañas (Tabs) -->
        <ul class="nav nav-tabs border-0 mb-4 gap-2" id="dashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded border-0 fw-bold px-4 shadow-sm" style="background-color: transparent; color: #495057;" 
                        id="ventas-tab" data-bs-toggle="tab" data-bs-target="#ventas" type="button" role="tab" 
                        aria-controls="ventas" aria-selected="true"
                        onclick="this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                        onmouseout="if(!this.classList.contains('active')) { this.style.backgroundColor='white'; this.style.color='#495057'; }">
                    <i class="bi bi-cart3 me-2"></i> Ventas Digitales
                </button>
            </li>
            <!-- Espacio reservado para futuros apartados -->
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded border-0 fw-bold px-4 shadow-sm bg-white text-secondary" 
                        id="crm-tab" data-bs-toggle="tab" data-bs-target="#crm" type="button" role="tab" 
                        aria-controls="crm" aria-selected="false"
                        onclick="document.getElementById('ventas-tab').style.backgroundColor='white'; document.getElementById('ventas-tab').style.color='#495057'; this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                        onmouseout="if(!this.classList.contains('active')) { this.style.backgroundColor='white'; this.style.color='#495057'; }">
                    <i class="bi bi-people-fill me-2"></i> CRM & Prospectos
                </button>
            </li>
            
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded border-0 fw-bold px-4 shadow-sm bg-white text-secondary" 
                        id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab" 
                        aria-controls="inventario" aria-selected="false"
                        onclick="document.getElementById('ventas-tab').style.backgroundColor='white'; document.getElementById('ventas-tab').style.color='#495057'; this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                        onmouseout="if(!this.classList.contains('active')) { this.style.backgroundColor='white'; this.style.color='#495057'; }">
                    <i class="bi bi-boxes me-2"></i> Inventario (Próximamente)
                </button>
            </li>
        </ul>

        <!-- Contenido de las Pestañas -->
        <div class="tab-content" id="dashboardTabsContent">
            
            <!-- PESTAÑA 1: VENTAS DIGITALES -->
            <div class="tab-pane fade show active" id="ventas" role="tabpanel" aria-labelledby="ventas-tab">
                
                <!-- Tarjetas de Métricas -->
                <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Facturación Diaria -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Facturación Diaria</h6>
                                        <h3 class="fw-bold mb-0 text-dark">S/. {{ number_format($facturacionDiaria, 2) }}</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-cash-coin fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Facturación Mensual -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Facturación Mensual</h6>
                                        <h3 class="fw-bold mb-0 text-dark">S/. {{ number_format($facturacionMensual, 2) }}</h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-graph-up fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Promedio -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Ticket Promedio</h6>
                                        <h3 class="fw-bold mb-0 text-dark">S/. {{ number_format($ticketPromedio, 2) }}</h3>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-receipt fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasa de Conversión -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Tasa de Conversión</h6>
                                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($tasaConversion, 1) }}%</h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-bullseye fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tablas y Gráficos -->
                <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                    <!-- Productos Más Vendidos -->
                    <div class="col-md-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-uppercase mb-0">
                                        <i class="bi bi-trophy-fill text-warning me-2"></i> Top 5 Productos Más Vendidos
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border-top">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 10%">#</th>
                                                <th style="width: 60%">Producto</th>
                                                <th style="width: 30%" class="text-center">Cant. Vendida</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($productosMasVendidos as $index => $item)
                                            <tr>
                                                <td><span class="text-muted fw-bold">{{ $index + 1 }}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if($item->producto && $item->producto->image)
                                                            <img src="{{ asset('storage/' . $item->producto->image) }}" class="rounded shadow-sm" width="45" height="45" style="object-fit: cover;" alt="{{ $item->producto->name }}">
                                                        @else
                                                            <div class="bg-light rounded d-flex justify-content-center align-items-center shadow-sm" style="width: 45px; height: 45px;">
                                                                <i class="bi bi-box text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $item->producto ? $item->producto->name : 'Producto Eliminado' }}</h6>
                                                            @if($item->producto && $item->producto->categorie)
                                                                <small class="text-muted badge bg-secondary bg-opacity-10 text-secondary">{{ $item->producto->categorie->name }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary bg-gradient rounded-pill px-3 py-2 fs-6 shadow-sm">{{ $item->total_vendido }} und.</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox fs-2 mb-3 text-light"></i>
                                                    <p class="mb-0">Aún no hay ventas registradas.</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- PESTAÑA 2: CRM Y PROSPECTOS -->
            <div class="tab-pane fade" id="crm" role="tabpanel" aria-labelledby="crm-tab">

                <!-- Tarjetas de Métricas CRM -->
                <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Prospectos Nuevos -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Prospectos Nuevos</h6>
                                        <h3 class="fw-bold mb-0 text-dark">{{ $prospectosNuevosMes }}</h3>
                                        <small class="text-muted">este mes</small>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-person-plus fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Oportunidades Activas -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Oportunidades Activas</h6>
                                        <h3 class="fw-bold mb-0 text-dark">{{ $oportunidadesActivas }}</h3>
                                        <small class="text-muted">en pipeline</small>
                                    </div>
                                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-graph-up fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Valor Pipeline -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Valor Pipeline</h6>
                                        <h3 class="fw-bold mb-0 text-dark">S/. {{ number_format($valorPipeline, 2) }}</h3>
                                        <small class="text-muted">proyectado</small>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-cash-stack fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets Abiertos -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                            <div class="card-body p-4 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Tickets Abiertos</h6>
                                        <h3 class="fw-bold mb-0 text-dark">{{ $ticketsAbiertos }}</h3>
                                        <small class="text-muted">por resolver</small>
                                    </div>
                                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-ticket-perforated fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fila de Gráficos: Pipeline por Etapa + Prospectos por Origen -->
                <div class="row g-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <!-- Pipeline por Etapa (Bar Chart) -->
                    <div class="col-md-12 col-lg-8">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <h5 class="fw-bold text-uppercase mb-0">
                                    <i class="bi bi-diagram-3 text-primary me-2"></i> Pipeline por Etapa
                                </h5>
                                <small class="text-muted">Distribución de oportunidades en cada fase</small>
                            </div>
                            <div class="card-body" style="height: 280px;">
                                <canvas id="chartPipeline"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Prospectos por Origen (Doughnut Chart) -->
                    <div class="col-md-12 col-lg-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <h5 class="fw-bold text-uppercase mb-0">
                                    <i class="bi bi-pie-chart text-info me-2"></i> Prospectos por Origen
                                </h5>
                                <small class="text-muted">De dónde llegan los leads</small>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center" style="height: 280px;">
                                @if(count($origenData) > 0)
                                    <canvas id="chartOrigen"></canvas>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 mb-3 text-light"></i>
                                        <p class="mb-0">Aún no hay prospectos registrados.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fila de Evolución + Top Vendedores -->
                <div class="row g-4" data-aos="fade-up" data-aos-delay="300">
                    <!-- Evolución Mensual (Line Chart) -->
                    <div class="col-md-12 col-lg-7">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <h5 class="fw-bold text-uppercase mb-0">
                                    <i class="bi bi-graph-up-arrow text-success me-2"></i> Evolución de Oportunidades Ganadas
                                </h5>
                                <small class="text-muted">Últimos 6 meses</small>
                            </div>
                            <div class="card-body" style="height: 280px;">
                                <canvas id="chartEvolucion"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Top Vendedores -->
                    <div class="col-md-12 col-lg-5">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <h5 class="fw-bold text-uppercase mb-0">
                                    <i class="bi bi-trophy text-warning me-2"></i> Top 5 Vendedores del Mes
                                </h5>
                                <small class="text-muted">Oportunidades ganadas</small>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border-top mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 10%">#</th>
                                                <th>Vendedor</th>
                                                <th class="text-center">Ganadas</th>
                                                <th class="text-end">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($topVendedores as $index => $v)
                                            <tr>
                                                <td><span class="text-muted fw-bold">{{ $index + 1 }}</span></td>
                                                <td>
                                                    <h6 class="mb-0 fw-semibold">{{ $v->name ?? $v->email }}</h6>
                                                    @if($v->surnames)
                                                        <small class="text-muted">{{ $v->surnames }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-success bg-gradient rounded-pill px-3 py-2 shadow-sm">{{ $v->total_ganadas }}</span>
                                                </td>
                                                <td class="text-end fw-semibold">S/. {{ number_format($v->valor_cerrado, 2) }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox fs-2 mb-3 text-light"></i>
                                                    <p class="mb-0">Sin oportunidades ganadas este mes.</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- PESTAÑA 3: INVENTARIO (VACÍA POR AHORA) -->
            <div class="tab-pane fade" id="inventario" role="tabpanel" aria-labelledby="inventario-tab">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; min-height: 400px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted">
                        <i class="bi bi-cone-striped fs-1 mb-3 text-secondary opacity-50"></i>
                        <h5>Módulo en construcción</h5>
                        <p>Aquí se añadirán las métricas de Inventario próximamente.</p>
                    </div>
                </div>
            </div>

        </div> <!-- Fin Tab Content -->

    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Chart.js defaults globales para que todos los gráficos se vean coherentes
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.color = '#6c757d';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;

    // ═══════════════════════════════════════════════════════════════
    // GRÁFICO 1: Pipeline por Etapa (Bar Chart vertical)
    // ═══════════════════════════════════════════════════════════════
    const ctxPipeline = document.getElementById('chartPipeline');
    if (ctxPipeline) {
        new Chart(ctxPipeline, {
            type: 'bar',
            data: {
                labels: @json($etapasLabels),
                datasets: [{
                    label: 'Oportunidades',
                    data: @json($conteoEtapas),
                    backgroundColor: @json($etapasColores),
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: '#e9ecef' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════
    // GRÁFICO 2: Prospectos por Origen (Doughnut)
    // ═══════════════════════════════════════════════════════════════
    const ctxOrigen = document.getElementById('chartOrigen');
    if (ctxOrigen) {
        new Chart(ctxOrigen, {
            type: 'doughnut',
            data: {
                labels: @json($origenLabels),
                datasets: [{
                    data: @json($origenData),
                    backgroundColor: @json($origenColors),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 12,
                            font: { size: 11 },
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                return `${ctx.label}: ${ctx.parsed} (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════
    // GRÁFICO 3: Evolución mensual (Line Chart con 2 datasets)
    // ═══════════════════════════════════════════════════════════════
    const ctxEvolucion = document.getElementById('chartEvolucion');
    if (ctxEvolucion) {
        new Chart(ctxEvolucion, {
            type: 'line',
            data: {
                labels: @json($mesesLabels),
                datasets: [
                    {
                        label: 'Oportunidades Ganadas',
                        data: @json($mesesGanadas),
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#198754',
                        yAxisID: 'y',
                    },
                    {
                        label: 'Valor Cerrado (S/.)',
                        data: @json($mesesValorCerrado),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.05)',
                        borderWidth: 2.5,
                        fill: false,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#0d6efd',
                        borderDash: [5, 5],
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: { padding: 15, font: { size: 11 } }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        callbacks: {
                            label: function(ctx) {
                                if (ctx.dataset.yAxisID === 'y1') {
                                    return `${ctx.dataset.label}: S/. ${ctx.parsed.y.toLocaleString('es-PE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                                }
                                return `${ctx.dataset.label}: ${ctx.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: '#e9ecef' },
                        title: { display: true, text: 'Cantidad' }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: 'Valor (S/.)' },
                        ticks: {
                            callback: function(value) {
                                return 'S/. ' + value.toLocaleString('es-PE');
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

});
</script>
@endsection
