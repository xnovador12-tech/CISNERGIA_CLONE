<?php $__env->startSection('title', 'PROSPECTOS'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROSPECTOS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(route('admin-dashboard.index')); ?>">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Prospectos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- fin encabezado -->

    
    <div class="container-fluid mb-4">
        <div class="row g-3" data-aos="fade-up">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total Prospectos</p>
                                <h3 class="mb-0 fw-bold text-primary">247</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-people fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Calificados</p>
                                <h3 class="mb-0 fw-bold text-success">89</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">En Seguimiento</p>
                                <h3 class="mb-0 fw-bold text-warning">124</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-clock-history fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Descartados</p>
                                <h3 class="mb-0 fw-bold text-danger">34</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                                <i class="bi bi-x-circle fs-3 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-3 mb-2 mb-md-0">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createProspecto"
                            class="btn btn-primary text-uppercase text-white btn-sm w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo Prospecto
                        </button>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filtroEstado">
                                    <option value="">Todos los Estados</option>
                                    <option value="nuevo">Nuevo</option>
                                    <option value="contactado">Contactado</option>
                                    <option value="calificado">Calificado</option>
                                    <option value="descartado">Descartado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filtroOrigen">
                                    <option value="">Todos los Orígenes</option>
                                    <option value="web">Sitio Web</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="referido">Referido</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filtroSegmento">
                                    <option value="">Todos los Segmentos</option>
                                    <option value="residencial">Residencial</option>
                                    <option value="comercial">Comercial</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="agricola">Agrícola</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filtroScoring">
                                    <option value="">Todos los Scoring</option>
                                    <option value="A">A - Alto</option>
                                    <option value="B">B - Medio</option>
                                    <option value="C">C - Bajo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="tablaProspectos" class="table table-hover align-middle nowrap" cellspacing="0"
                    style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre / Razón Social</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Contacto</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Origen</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Segmento</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Scoring</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Asignado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                            <td class="fw-normal text-center align-middle"><span
                                    class="badge bg-secondary">#PROSP-001</span></td>
                            <td class="fw-normal text-start align-middle">
                                <strong>Carlos Mendoza SAC</strong><br>
                                <small class="text-muted">RUC: 20123456789</small>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <small>carlos@empresa.com<br>987 654 321</small>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-info text-dark"><i class="bi bi-globe me-1"></i>Web</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-warning text-dark">Comercial</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="badge bg-success me-2">A</span>
                                    <div class="progress" style="width: 60px; height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 85%"></div>
                                    </div>
                                    <small class="ms-2 text-muted">85</small>
                                </div>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-success">Calificado</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <small>Juan Diego</small>
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center">
                                                <i class="bi bi-eye text-info me-2"></i>Ver Detalles
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center">
                                                <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center text-success">
                                                <i class="bi bi-arrow-right-circle me-2"></i>Convertir a Oportunidad
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form method="POST" action="#" class="form-delete">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="dropdown-item d-flex align-items-center text-danger">
                                                    <i class="bi bi-trash me-2"></i>Eliminar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php $contador++; ?>

                        <tr>
                            <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                            <td class="fw-normal text-center align-middle"><span
                                    class="badge bg-secondary">#PROSP-002</span></td>
                            <td class="fw-normal text-start align-middle">
                                <strong>Ana García Torres</strong><br>
                                <small class="text-muted">DNI: 43287651</small>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <small>ana.garcia@email.com<br>956 123 456</small>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-primary"><i class="bi bi-facebook me-1"></i>Facebook</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-info text-dark">Residencial</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="badge bg-warning text-dark me-2">B</span>
                                    <div class="progress" style="width: 60px; height: 8px;">
                                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                                    </div>
                                    <small class="ms-2 text-muted">60</small>
                                </div>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <span class="badge bg-primary">Contactado</span>
                            </td>
                            <td class="fw-normal text-center align-middle">
                                <small>María López</small>
                            </td>
                            <td class="text-center align-middle">
                                <div class="dropstart">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style="width: 36px; height: 36px; padding: 0;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center">
                                                <i class="bi bi-eye text-info me-2"></i>Ver Detalles
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center">
                                                <i class="bi bi-pencil text-secondary me-2"></i>Editar
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center text-success">
                                                <i class="bi bi-arrow-right-circle me-2"></i>Convertir a Oportunidad
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form method="POST" action="#" class="form-delete">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="dropdown-item d-flex align-items-center text-danger">
                                                    <i class="bi bi-trash me-2"></i>Eliminar
                                                </button>
                                            </form>
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

    <!-- Modal: Crear Prospecto -->
    <div class="modal fade" id="createProspecto" tabindex="-1" aria-labelledby="createProspectoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createProspectoLabel">
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Prospecto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Tipo de Prospecto -->
                            <div class="col-md-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3"><i
                                        class="bi bi-info-circle me-2"></i>Información General</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tipo de Prospecto <span class="text-danger">*</span></label>
                                <select class="form-select" name="tipo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="persona">Persona Natural</option>
                                    <option value="empresa">Empresa</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el tipo</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Documento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="documento" placeholder="DNI o RUC"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese el documento</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nombre / Razón Social <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre"
                                    placeholder="Nombre completo o razón social" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre</div>
                            </div>

                            <!-- Contacto -->
                            <div class="col-md-12 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-telephone me-2"></i>Datos
                                    de Contacto</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="correo@ejemplo.com" required>
                                <div class="invalid-feedback">Por favor ingrese un email válido</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="telefono" placeholder="987 654 321"
                                    required>
                                <div class="invalid-feedback">Por favor ingrese el teléfono</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono Alternativo</label>
                                <input type="tel" class="form-control" name="telefono_alt"
                                    placeholder="987 654 321">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion"
                                    placeholder="Dirección completa">
                            </div>

                            <!-- Clasificación -->
                            <div class="col-md-12 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3"><i
                                        class="bi bi-tags me-2"></i>Clasificación</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Origen <span class="text-danger">*</span></label>
                                <select class="form-select" name="origen" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="web">Sitio Web</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="google">Google Ads</option>
                                    <option value="referido">Referido</option>
                                    <option value="feria">Feria/Evento</option>
                                    <option value="directo">Directo</option>
                                    <option value="otro">Otro</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el origen</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Segmento <span class="text-danger">*</span></label>
                                <select class="form-select" name="segmento" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="residencial">Residencial</option>
                                    <option value="comercial">Comercial</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="agricola">Agrícola</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione el segmento</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Interés en</label>
                                <select class="form-select select2" name="intereses[]" multiple>
                                    <option value="paneles">Paneles Solares</option>
                                    <option value="inversores">Inversores</option>
                                    <option value="baterias">Baterías</option>
                                    <option value="instalacion">Instalación</option>
                                    <option value="mantenimiento">Mantenimiento</option>
                                    <option value="consultoria">Consultoría</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Asignar a</label>
                                <select class="form-select" name="asignado_a">
                                    <option value="">Sin asignar</option>
                                    <option value="1">Juan Diego</option>
                                    <option value="2">María López</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Observaciones</label>
                                <textarea class="form-control" name="observaciones" rows="3"
                                    placeholder="Notas adicionales sobre el prospecto..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar Prospecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        // Inicializar DataTable
        $(document).ready(function() {
            $('#tablaProspectos').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                pageLength: 10,
                order: [
                    [0, 'asc']
                ]
            });

            // Inicializar Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Seleccionar opciones',
                dropdownParent: $('#createProspecto')
            });
        });

        // SweetAlert para eliminar
        $('.form-delete').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1C3146',
                cancelButtonColor: '#FF9C00',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        // Validación de formulario Bootstrap
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/crm/prospectos/index.blade.php ENDPATH**/ ?>