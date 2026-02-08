<?php $__env->startSection('title', 'SERVICIOS'); ?>

<?php $__env->startSection('css'); ?>
<style>
    /* Asegurar que Select2 dropdown aparezca delante del modal */
    .select2-container--open .select2-dropdown {
        z-index: 2000 !important;
    }
</style>
<?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">SERVICIOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-servicios')); ?>">Servicios</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->


    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-beetween">
                    <div class="col-md-3 d-flex">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#createservicios" class="btn btn-dark text-uppercase text-white btn-sm w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo Registro
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold"><?php echo e($admin_servicios->count()); ?></span></span>
                </div>
                <table id="display" class="table table-hover table-sm text-center" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Codigo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Tipo</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $contador = 1;
                        ?>
                        <?php $__currentLoopData = $admin_servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin_servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                                <td class="fw-normal text-center align-middle"><?php echo e($admin_servicio->codigo); ?></td>
                                <td class="fw-normal text-center align-middle"><?php echo e($admin_servicio->name); ?></td>
                                <td class="fw-normal text-center align-middle"><?php echo e($admin_servicio->tipo_servicio); ?></td>
                                <td class="fw-normal align-middle">
                                    <form method="POST" action="/admin-servicios/estado/<?php echo e($admin_servicio->slug); ?>" class="form-update">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                        <?php if($admin_servicio->estado == 'Activo'): ?>
                                            <button type="submit" class="badge bg-success border-0">Activo</button>
                                        <?php else: ?>
                                            <button type="submit" class="badge bg-danger border-0">Inactivo</button>
                                        <?php endif; ?>
                                    </form>
                                </td>    
                                <td class="align-middle">                                        
                                    <div class="dropstart">
                                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow"> 
                                            <li>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#editservicios<?php echo e($admin_servicio->slug); ?>" class="dropdown-item d-flex align-items-center"><i class="bi bi-pencil text-secondary me-2"></i>Editar</button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin-servicios.destroy',$admin_servicio->slug)); ?>" class="form-delete">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger"><i class="bi bi-trash me-2"></i>Eliminar</button>        
                                                </form>                                                     
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                $contador++;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php $__currentLoopData = $admin_servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin_servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('ADMINISTRADOR.PRINCIPAL.configuraciones.servicios.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('ADMINISTRADOR.PRINCIPAL.configuraciones.servicios.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!--sweet alert agregar-->
    <?php if(session('new_registration') == 'ok'): ?>
    <script>
        Swal.fire({
        icon: 'success',
        confirmButtonColor: '#1C3146',
        title: '¡Éxito!',
        text: 'Nuevo registro guardado correctamente',
        })
    </script>
    <?php endif; ?>

    <?php if(session('exists') == 'ok'): ?>
        <script>
            Swal.fire({
            icon: 'warning',
            confirmButtonColor: '#1C3146',
            title: '¡Lo sentimos!',
            text: 'Este registro ya existe',
            })
        </script>
    <?php endif; ?>

    <!--sweet alert actualizar-->
    <?php if(session('error') == 'ok'): ?>
        <script>
            Swal.fire({
            icon: 'warning',
            confirmButtonColor: '#1C3146',
            title: '¡Lo sentimos!',
            text: 'Este registro no se puede eliminar porque está siendo utilizado en otro registro',
            })
        </script>
    <?php endif; ?>

    <!--sweet alert actualizar-->
    <?php if(session('update') == 'ok'): ?>
        <script>
            Swal.fire({
            icon: 'success',
            confirmButtonColor: '#1C3146',
            title: '¡Actualizado!',
            text: 'Registro actualizado correctamente',
            })
        </script>
    <?php endif; ?>

    <!--sweet alert eliminar-->
    <?php if(session('delete') == 'ok'): ?>
        <script>
        Swal.fire({
            icon: 'success',
            confirmButtonColor: '#1C3146',
            title: '¡Eliminado!',
            text: 'Registro eliminado correctamente',
            })
        </script>
    <?php endif; ?>
    <script>
        $('.form-delete').submit(function(e){
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
    </script>
    <script>
        $(document).ready(function(){
        <?php if($message = Session::get('errors')): ?>
            $("#createcategoria").modal('show');
        <?php endif; ?>
        });
    </script>

    <script>
        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>

    <script>
        $(document).ready(function() {
            // Inicializar Select2 dentro de modales con dropdownParent
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.select2').select2({
                    dropdownParent: $(this)
                });
            });
            
            // Inicializar Select2 fuera de modales
            $('.select2').filter(function() {
                return $(this).closest('.modal').length === 0;
            }).select2();
        });
    </script>

    <script>
        
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/servicios/index.blade.php ENDPATH**/ ?>