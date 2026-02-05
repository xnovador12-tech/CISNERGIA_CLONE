<?php $__env->startSection('title', 'SEGUIMIENTO'); ?>

<?php $__env->startSection('css'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">SEGUIMIENTO DE VENTAS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
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
                                <h3 class="mb-0 fw-bold text-primary"><?php echo e($totalPedidos); ?></h3>
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
                                <h3 class="mb-0 fw-bold text-success"><?php echo e($totalVentas); ?></h3>
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
                                <h3 class="mb-0 fw-bold text-info">S/ <?php echo e(number_format($facturacionMes, 2)); ?></h3>
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
                                <h3 class="mb-0 fw-bold text-warning">S/ <?php echo e(number_format($ticketPromedio, 2)); ?></h3>
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
                                <h4 class="mb-0 fw-bold text-purple"><?php echo e(number_format($tasaConversion, 2)); ?>%</h4>
                            </div>
                            <div class="progress" style="width: 60%; height: 30px;">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo e($tasaConversion); ?>%">
                                    <?php echo e(number_format($tasaConversion, 1)); ?>%
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
                    <div class="card-body" style="min-height: 350px;">
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
                                <?php if($pedidosRecientes->count() > 0): ?>
                                    <?php $__currentLoopData = $pedidosRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><a href="<?php echo e(route('admin-pedidos.show', $pedido)); ?>"><?php echo e($pedido->codigo); ?></a></td>
                                        <td><?php echo e($pedido->cliente->name ?? 'N/A'); ?></td>
                                        <td><?php echo e($pedido->created_at->format('d/m/Y')); ?></td>
                                        <td class="text-end">S/ <?php echo e(number_format($pedido->total, 2)); ?></td>
                                        <td>
                                            <?php if($pedido->estado == 'pendiente'): ?>
                                                <span class="badge bg-warning">Pendiente</span>
                                            <?php elseif($pedido->estado == 'entregado'): ?>
                                                <span class="badge bg-success">Entregado</span>
                                            <?php else: ?>
                                                <span class="badge bg-info"><?php echo e(ucfirst($pedido->estado)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted mb-0">No hay pedidos registrados</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                            <?php $__currentLoopData = $topProductos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo e($producto->name); ?>

                                <span class="badge bg-primary rounded-pill"><?php echo e($producto->total_vendido); ?></span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

                <!-- Ventas Recientes -->
                <div class="card border-0 shadow-sm mt-3" data-aos="fade-up">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ventas Recientes</h5>
                    </div>
                    <div class="card-body" style="min-height: 300px; max-height: 300px; overflow-y: auto;">
                        <?php if($ventasRecientes->count() > 0): ?>
                            <?php $__currentLoopData = $ventasRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <strong><a href="<?php echo e(route('admin-ventas.show', $venta)); ?>"><?php echo e($venta->codigo); ?></a></strong><br>
                                    <small class="text-muted"><?php echo e($venta->cliente->name ?? 'N/A'); ?></small>
                                </div>
                                <div class="text-end">
                                    <strong class="text-success">S/ <?php echo e(number_format($venta->total, 2)); ?></strong><br>
                                    <small class="text-muted"><?php echo e($venta->created_at->format('d/m/Y')); ?></small>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    // Gráfico de Ventas Diarias
    const ctxVentas = document.getElementById('chartVentas').getContext('2d');
    const ventasDiarias = <?php echo json_encode($ventasDiarias, 15, 512) ?>;
    
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
    const pedidosEstado = <?php echo json_encode($pedidosPorEstado, 15, 512) ?>;
    
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/ventas/seguimiento/index.blade.php ENDPATH**/ ?>