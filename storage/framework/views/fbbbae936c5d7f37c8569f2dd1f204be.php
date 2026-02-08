<?php $__env->startSection('title', 'PRODUCTOS'); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PRODUCTOS</h1>
                <div class=""
                    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link"
                                href="<?php echo e(url('admin-productos')); ?>">Productos</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- fin encabezado -->

    
    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px"
            data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-header bg-transparent">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-6 col-xl-3 mb-2 mb-lg-0">
                        <a href="<?php echo e(url('admin-productos/create')); ?>" class="btn btn-primary btn-sm text-uppercase text-white w-100">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Nuevo registro
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2 col-12 col-md-6">
                    <span class="text-uppercase">Total de registros encontrados: <span
                            class="fw-bold"><?php echo e($admin_productos->count()); ?></span></span>
                </div>
                <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                    <thead class="bg-dark text-white border-0">
                        <tr>
                            <th class="h6 small text-center text-uppercase fw-bold">N°</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Código</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Nombre</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Precio</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Categoría</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Medida</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Marca</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Estado</th>
                            <th class="h6 small text-center text-uppercase fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $contador = 1;
                        ?>
                        <?php $__currentLoopData = $admin_productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin_producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-normal text-center align-middle"><?php echo e($contador); ?></td>
                                <td class="fw-normal text-center align-middle"><?php echo e($admin_producto->codigo); ?></td>
                                <td class="fw-normal text-center align-middle"><?php echo e($admin_producto->name); ?></td>
                                <td class="fw-normal text-center align-middle">S/
                                    <?php echo e(number_format($admin_producto->precio, 2)); ?></td>
                                <td class="fw-normal text-center align-middle">
                                    <?php echo e($admin_producto->categorie->name ?? '-'); ?>

                                </td>
                                <td class="fw-normal text-center align-middle"><?php echo e($admin_producto->medida->nombre ?? '-'); ?>

                                <td class="fw-normal text-center align-middle"><?php echo e($admin_producto->marca->name ?? '-'); ?>

                                </td>
                                <td class="fw-normal align-middle text-center">
                                    <form method="POST" action="/admin-productos/estado/<?php echo e($admin_producto->slug); ?>"
                                        class="form-update">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <?php if($admin_producto->estado == 'Activo'): ?>
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
                                                <a href="<?php echo e(url("/admin-productos/$admin_producto->slug")); ?>" class="dropdown-item d-flex align-items-center"><i class="bi bi-eye text-secondary me-2"></i>Detalles</a>
                                            </li>
                                            
                                            <li>
                                                <a href="<?php echo e(url("/admin-productos/$admin_producto->slug/edit")); ?>" class="dropdown-item d-flex align-items-center"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="<?php echo e(route('admin-productos.destroy',$admin_producto->slug)); ?>" class="form-delete">
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
        $('.form-delete').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
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
        $(document).ready(function() {
            <?php if($message = Session::get('errors')): ?>
                $("#createproducto").modal('show');
            <?php endif; ?>
        });
    </script>

    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
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

<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/productos/index.blade.php ENDPATH**/ ?>