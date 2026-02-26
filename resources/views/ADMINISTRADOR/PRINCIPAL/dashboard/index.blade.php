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
                    <i class="fa-solid fa-cart-shopping me-2"></i> Ventas Digitales
                </button>
            </li>
            <!-- Espacio reservado para futuros apartados -->
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded border-0 fw-bold px-4 shadow-sm bg-white text-secondary" 
                        id="crm-tab" data-bs-toggle="tab" data-bs-target="#crm" type="button" role="tab" 
                        aria-controls="crm" aria-selected="false"
                        onclick="document.getElementById('ventas-tab').style.backgroundColor='white'; document.getElementById('ventas-tab').style.color='#495057'; this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                        onmouseout="if(!this.classList.contains('active')) { this.style.backgroundColor='white'; this.style.color='#495057'; }">
                    <i class="fa-solid fa-users-viewfinder me-2"></i> CRM & Prospectos (Próximamente)
                </button>
            </li>
            
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded border-0 fw-bold px-4 shadow-sm bg-white text-secondary" 
                        id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab" 
                        aria-controls="inventario" aria-selected="false"
                        onclick="document.getElementById('ventas-tab').style.backgroundColor='white'; document.getElementById('ventas-tab').style.color='#495057'; this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                        onmouseout="if(!this.classList.contains('active')) { this.style.backgroundColor='white'; this.style.color='#495057'; }">
                    <i class="fa-solid fa-boxes-stacked me-2"></i> Inventario (Próximamente)
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
                                        <i class="fa-solid fa-money-bill-wave fs-4"></i>
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
                                        <i class="fa-solid fa-chart-line fs-4"></i>
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
                                        <i class="fa-solid fa-receipt fs-4"></i>
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
                                        <i class="fa-solid fa-bullseye fs-4"></i>
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
                                        <i class="fa-solid fa-crown text-warning me-2"></i> Top 5 Productos Más Vendidos
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
                                                                <i class="fa-solid fa-box text-muted"></i>
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
                                                    <i class="fa-solid fa-inbox fs-2 mb-3 text-light"></i>
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
            
            <!-- PESTAÑA 2: CRM Y PROSPECTOS (VACÍA POR AHORA) -->
            <div class="tab-pane fade" id="crm" role="tabpanel" aria-labelledby="crm-tab">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; min-height: 400px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted">
                        <i class="fa-solid fa-person-digging fs-1 mb-3 text-secondary opacity-50"></i>
                        <h5>Módulo en construcción</h5>
                        <p>Aquí se añadirán las métricas de CRM próximamente.</p>
                    </div>
                </div>
            </div>

            <!-- PESTAÑA 3: INVENTARIO (VACÍA POR AHORA) -->
            <div class="tab-pane fade" id="inventario" role="tabpanel" aria-labelledby="inventario-tab">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; min-height: 400px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted">
                        <i class="fa-solid fa-person-digging fs-1 mb-3 text-secondary opacity-50"></i>
                        <h5>Módulo en construcción</h5>
                        <p>Aquí se añadirán las métricas de Inventario próximamente.</p>
                    </div>
                </div>
            </div>

        </div> <!-- Fin Tab Content -->

    </div>
@endsection

@section('js')

@endsection
