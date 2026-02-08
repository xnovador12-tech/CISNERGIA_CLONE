<?php $__env->startSection('title', 'FIDELIZACIÓN'); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">FIDELIZACIÓN</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Fidelización</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Clientes con Puntos</small>
                        <h3 class="mb-0 fw-bold text-primary">89</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Puntos Emitidos</small>
                        <h3 class="mb-0 fw-bold text-success">45,230</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Puntos Canjeados</small>
                        <h3 class="mb-0 fw-bold text-warning">12,450</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body"><small class="text-muted">Nivel Platinum</small>
                        <h3 class="mb-0 fw-bold text-info">12</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs mb-3" data-aos="fade-up">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#puntos"><i
                        class="bi bi-award me-2"></i>Sistema de Puntos</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cupones"><i
                        class="bi bi-ticket-perforated me-2"></i>Cupones</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#membresias"><i
                        class="bi bi-trophy me-2"></i>Membresías</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#referidos"><i
                        class="bi bi-people me-2"></i>Referidos</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="puntos">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px"
                    data-aos="fade-up">
                    <div class="card-body">
                        <table id="tablaPuntos" class="table table-hover align-middle nowrap" cellspacing="0"
                            style="width:100%">
                            <thead class="bg-dark text-white border-0">
                                <tr>
                                    <th class="h6 small text-center text-uppercase fw-bold">Cliente</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Nivel</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Acumulados</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Canjeados</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Disponibles</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Última Actividad</th>
                                    <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-normal text-start align-middle"><strong>Carlos Mendoza SAC</strong></td>
                                    <td class="fw-normal text-center align-middle"><span
                                            class="badge bg-warning">Gold</span></td>
                                    <td class="fw-normal text-center align-middle">5,240</td>
                                    <td class="fw-normal text-center align-middle">1,200</td>
                                    <td class="fw-normal text-center align-middle"><strong>4,040</strong></td>
                                    <td class="fw-normal text-center align-middle"><small>Hace 2 días</small></td>
                                    <td class="text-center align-middle">
                                        <div class="dropstart">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                                data-bs-toggle="dropdown" style="width: 36px; height: 36px; padding: 0;">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu shadow">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="bi bi-eye text-info me-2"></i>Ver Historial</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalCanjear"><i
                                                            class="bi bi-gift text-success me-2"></i>Canjear Puntos</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cupones">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-header bg-transparent">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createCupon"
                            class="btn btn-primary text-uppercase text-white btn-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Generar Cupón
                        </button>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Gestión de cupones de descuento y promociones especiales...</p>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="membresias">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="bi bi-award fs-1 text-secondary"></i>
                                        <h5 class="mt-2">Bronze</h5>
                                        <p class="text-muted small mb-0">45 clientes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="bi bi-award fs-1 text-muted"></i>
                                        <h5 class="mt-2">Silver</h5>
                                        <p class="text-muted small mb-0">32 clientes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center border-warning">
                                    <div class="card-body">
                                        <i class="bi bi-award fs-1 text-warning"></i>
                                        <h5 class="mt-2">Gold</h5>
                                        <p class="text-muted small mb-0">18 clientes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center border-primary">
                                    <div class="card-body">
                                        <i class="bi bi-award fs-1 text-primary"></i>
                                        <h5 class="mt-2">Platinum</h5>
                                        <p class="text-muted small mb-0">12 clientes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="referidos">
                <div class="card border-4 borde-top-secondary shadow-sm" style="border-radius: 20px; min-height: 400px">
                    <div class="card-body">
                        <p class="text-muted">Programa de referidos y comisiones...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Canjear Puntos -->
    <div class="modal fade" id="modalCanjear" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-gift me-2"></i>Canjear Puntos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Cliente</label>
                            <input type="text" class="form-control" value="Carlos Mendoza SAC" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Puntos Disponibles</label>
                            <input type="text" class="form-control" value="4,040 puntos" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Puntos a Canjear</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Concepto</label>
                            <select class="form-select">
                                <option>Descuento en próxima compra</option>
                                <option>Producto gratis</option>
                                <option>Servicio gratuito</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check me-2"></i>Canjear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Cupón -->
    <div class="modal fade" id="createCupon" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Generar Cupón</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Código Cupón</label>
                                <input type="text" class="form-control" placeholder="SOLAR2024">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo Descuento</label>
                                <select class="form-select">
                                    <option>Porcentaje (%)</option>
                                    <option>Monto Fijo (S/)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Valor Descuento</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha Vencimiento</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Usos Máximos</label>
                                <input type="number" class="form-control" value="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monto Mínimo Compra (S/)</label>
                                <input type="number" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            $('#tablaPuntos').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/fidelizacion/index.blade.php ENDPATH**/ ?>