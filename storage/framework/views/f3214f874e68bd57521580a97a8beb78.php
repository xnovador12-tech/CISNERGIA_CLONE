<?php $__env->startSection('title', 'PROVEEDORES'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PROVEEDORES</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-proveedores')); ?>">Proveedores</a></li>
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
                        <div class="col-12 col-md-6 col-xl-3 mb-2 mb-lg-0">
                            <a href="<?php echo e(url('admin-proveedores/create')); ?>" class="btn btn-primary btn-sm text-uppercase text-white w-100 <?php if(Gate::allows('gerencia',Auth()->user())): ?> disabled <?php else: ?> <?php endif; ?>">
                                <i class="bi bi-plus-circle-fill me-2"></i>
                                Nuevo registro
                            </a>
                        </div>
                        <!-- <?php if(Gate::allows('gerencia',Auth()->user())): ?>
                            <div class="col-6 col-md-3 col-xl-3 mb-2 mb-lg-0">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">SEDES</span>
                                    <select class="form-select form-select-sm text-uppercase" id="lista_sedes" aria-label="Floating label select example">
                                        <option selected="selected" value="-- Seleccione --" hidden="hidden">-- Seleccione --</option>
                                        <option value="TODOS">TODOS</option>
                                        <?php $__currentLoopData = $sedes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin_proveedores_sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($admin_proveedores_sede->id); ?>" ><?php echo e($admin_proveedores_sede->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                        <?php endif; ?>
                        <div class="col-6 col-md-3 col-xl-3 mb-2 mb-lg-0">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="basic-addon1">TIPOS</span>
                                <select class="form-select form-select-sm" id="lista_tipo_bienes" aria-label="Floating label select example">
                                    <option selected="selected" hidden="hidden">-- Seleccione --</option>
                                    <option value="TODOS">TODOS</option>
                                    <option value="1">MATERIA PRIMA</option>
                                    <option value="2">MATERIALES</option>
                                    <option value="3">ACTIVOS</option>
                                    <option value="4">ALIMENTOS</option>
                                    <option value="5">COSMETICOS</option>
                                    <option value="6">PUBLICOS</option>
                                    <option value="7">PRIVADOS</option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <?php if(Gate::allows('gerencia',Auth()->user())): ?>
                        <?php else: ?>       
                            <div class="col-12 col-md-1 col-xl-5"></div>
                        <?php endif; ?> -->
                        <!-- <div class="col-12 col-md-6 col-lg-3 col-xl-1 mb-2 mb-lg-0">
                            <button type="button" class="btn btn-dark btn-sm w-100" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-download"></i></button>
                            <ul class="dropdown-menu">      
                                
                                <li class="dropdown-item">
                                    <button class="bg-transparent border-0 px-0 mx-0" data-bs-toggle="modal" data-bs-target="#reporte_PDF"><i class="bi bi-file-pdf me-2"></i><small>PDF</small></button>
                                </li>                                                    
                            </ul>
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2 ">
                            <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold"><?php echo e($admin_proveedores->count()); ?></span></span>
                        </div>
                        <div class="col-12 col-md-6 mb-2 d-flex justify-content-end">
                            <?php if(Gate::allows('gerencia',Auth()->user())): ?>
                                <span class="text-uppercase">
                                    <?php if(empty($name_sede)): ?>
                                        <span class="text-uppercase">Sede: <span class="fw-bold">Todos</span></span>
                                    <?php else: ?>
                                        <span class="text-uppercase">Sede: <span class="fw-bold"><?php echo e($name_sede->name); ?></span></span>
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>   
                            <?php endif; ?>
                        </div>
                    </div>
                    <table id="display" class="table table-hover align-middle nowrap" cellspacing="0" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th class="h6 small text-uppercase fw-bold">N°</th>
                                <th class="h6 small text-uppercase fw-bold">Identificación</th>
                                <th class="h6 small text-uppercase fw-bold">Razon social</th>
                                <th class="h6 small text-uppercase fw-bold">Giro</th>
                                <th class="h6 small text-uppercase fw-bold">Email</th>
                                <th class="h6 small text-uppercase fw-bold">Nro. Contacto</th>
                                <th class="h6 small text-uppercase fw-bold text-center">Estado</th>
                                <th class="h6 small text-uppercase fw-bold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <?php
                            $contador = 1;
                        ?>
                        <tbody id="tble_index_prov">
                            <?php $__currentLoopData = $admin_proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin_proveedore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-normal align-middle"><?php echo e($contador); ?></td>
                                    <td class="fw-normal align-middle text-uppercase"><?php echo e($admin_proveedore->identificacion.' - '.$admin_proveedore->nro_identificacion); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_proveedore->proveedor->name_contacto); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_proveedore->proveedor->giro); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_proveedore->proveedor->email_contacto); ?></td>
                                    <td class="fw-normal align-middle"><?php echo e($admin_proveedore->celular); ?></td>
                                    <td class="fw-normal align-middle small text-start text-md-center">
                                        <form method="POST" action="/admin-proveedores/estado/<?php echo e($admin_proveedore->slug); ?>" class="form-update">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                                <?php if($admin_proveedore->proveedor->estado == 'Activo'): ?>
                                                    <button type="submit" class="text-uppercase small badge bg-success border-0">Activo</button>
                                                <?php else: ?>
                                                    <button type="submit" class="text-uppercase small badge bg-danger border-0">Inactivo</button>
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
                                                    <a href="<?php echo e(url("/admin-proveedores/$admin_proveedore->slug")); ?>" class="dropdown-item d-flex align-items-center"><i class="bi bi-eye text-secondary me-2"></i>Detalles</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(url("/admin-proveedores/$admin_proveedore->slug/edit")); ?>" class="dropdown-item d-flex align-items-center"><i class="bi bi-pencil text-secondary me-2"></i>Editar</a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin-proveedores.destroy',$admin_proveedore->slug)); ?>" class="form-delete">
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
<script>
    $(function() {
        $('#toggle-two').bootstrapToggle({
        on: 'Enabled',
        off: 'Disabled'
        });
    })
</script>
    <!--sweet alert agregar-->
    <?php if(session('addproveedor') == 'ok'): ?>
    <script>
        Swal.fire({
        icon: 'success',
        confirmButtonColor: '#1C3146',
        title: '¡Éxito!',
        text: 'Proveedor registrado correctamente',
        })
    </script>
    <?php endif; ?>
    <?php if(session('error') == 'ok'): ?>
    <script>
        Swal.fire({
        icon: 'error',
        confirmButtonColor: '#1C3146',
        title: '!!Error!!',
        text: 'Asegurece que este registro no este siendo utilizado en otra seccion',
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
    <!--.sweet alert eliminar-->

    <script>
        $(document).ready(function(){
        <?php if($message = Session::get('errors')): ?>
            $("#createcolor").modal('show');
        <?php endif; ?>
        });
    </script>
    
    <script>
    $(document).ready(function() {
        var contador_mps = 1;
        $('#lista_tipo_bienes').on('change', function(){
            var lista_bienes = $(this).val();
            var sede_id = $('#lista_sedes').val();
            $.get('/lista_index_proveedores',{sede_id: sede_id, lista_bienes:lista_bienes}, function(busqueda){
                $('#tble_index_prov').empty("");
                contador_mps = 1;
                _token = $('meta[name="csrf-token"]').attr('content');  
                $.each(busqueda, function(index, value){
                    if(value[0] == 'No existe'){
                        $('#tble_index_prov').empty("");
                    }else{
                        if(value[7] == 'Activo'){
                            estados= '<button type="submit" class="text-uppercase small badge bg-success border-0">Activo</button>';
                        }else{
                            estados= '<button type="submit" class="text-uppercase small badge bg-danger border-0">Inactivo</button>';
                        }
                        
                        var fila = '<tr id="filamp' + contador_mps +
                                '"><td class="align-middle fw-normal">' + contador_mps + '</td><td class="align-middle text-uppercase">' + value[0] +' - '+value[1]+
                                '</td><td class="align-middle fw-normal">' + value[2] +
                                '</td><td class="align-middle fw-normal">' + value[3] +
                                '</td><td class="align-middle fw-normal">'+value[4]+'</td><td class="align-middle fw-normal">' + value[5] +
                                '</td><td class="fw-normal align-middle small text-start text-md-center"><form method="PUT" action="/admin-proveedores/estado/'+value[6]+'" class="form-update"><input hidden value="'+_token+'"><input type="hidden" value="PUT">'+estados+'</form></td><td class="align-middle"><div class="text-start text-md-center"><div class="dropstart"><button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button><ul class="dropdown-menu"><li class="dropdown-item"><a href="/admin-proveedores/'+value[6]+'" class="link-dark text-decoration-none"><i class="bi bi-eye-fill me-2"></i>Detalles</a></li><li class="dropdown-item"><a href="/admin-proveedores/'+value[6]+'/edit" class="link-dark text-decoration-none"><i class="bi bi-pencil-square me-2"></i>Editar</a></li><form method="DELETE" action="/admin-proveedores/delete/'+value[6]+'" class="form-delete"><input hidden value="'+_token+'"><input type="hidden" value="DELETE"><li class="dropdown-item"><button type="submit" class="bg-transparent mx-0 px-0 border-0"><i class="bi bi-trash-fill me-2"></i>Eliminar</button></li></form></ul></div></div></td></tr>';
                        contador_mps++;
                        $('#tble_index_prov').append(fila);
                    }
                });
            });
        });
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/proveedores/index.blade.php ENDPATH**/ ?>