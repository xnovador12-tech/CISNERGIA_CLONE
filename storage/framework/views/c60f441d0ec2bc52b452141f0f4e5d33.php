<?php $__env->startSection('title', 'INVENTARIOS'); ?>

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
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">INVENTARIOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-inventarios')); ?>">Inventarios</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Inicio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->


    <div class="container-fluid">
        <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-uppercase">Total de registros encontrados: <span class="fw-bold"><?php echo e($sedes->count()); ?></span></span>
                    </div>
                    <div class="row">
                        <?php
                            $alm_accesorios_sum = 0;
                            $alm_repuestos_sum = 0;
                            $alm_modulo_solar_sum = 0;
                        ?>
                        <?php $__currentLoopData = $sedes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $almacenes_accesorios = App\Models\Inventario::where('tipo_producto','Accesorios')->where('sede_id',$sede->id)->get();
                                foreach($almacenes_accesorios as $almacenes_accesorio){
                                    $alm_accesorios_sum = $alm_accesorios_sum+($almacenes_accesorio?$almacenes_accesorio->cantidad:'0');
                                }
                                $almacenes_repuestos = App\Models\Inventario::where('tipo_producto','Repuestos')->where('sede_id',$sede->id)->get();
                                foreach($almacenes_repuestos as $almacenes_repuesto){
                                    $alm_repuestos_sum = $alm_repuestos_sum+($almacenes_repuesto?$almacenes_repuesto->cantidad:'0');
                                }
                                $almacenes_modulo_solar = App\Models\Inventario::where('tipo_producto','Modulo Solar')->where('sede_id',$sede->id)->get();
                                foreach($almacenes_modulo_solar as $almacenes_modulo_solar_item){
                                    $alm_modulo_solar_sum = $alm_modulo_solar_sum+($almacenes_modulo_solar_item?$almacenes_modulo_solar_item->cantidad:'0');
                                }
                            ?>
                            <div class="col-12 col-md-4 col-xl-3">
                                <div class="card border-3 borde-top-primary box-shadow">
                                    <div class="card-body pb-0 mb-0">
                                        <div class="row pb-2 mb-3">
                                            <img src="/images/panl_solar.png" class="img-fluid" style="height: 100px;" alt="">
                                        </div>
                                        <div class="row pb-2 mb-3">
                                            <div class="align-self-center bg-primary text-center">
                                                <small class="fw-bold text-white">ALMACEN</small>
                                                <p class="mb-0 fw-bold text-uppercase text-white"><?php echo e($sede->name); ?></p>
                                            </div>
                                        </div>
                                        <div class="card mb-3 shadow-sm border-0 bg-light">
                                            <div class="card-body">
                                                <div class="clearfix text-uppercase fw-bold">
                                                    <span class="float-start">
                                                        <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" onclick="accesorios(<?php echo e($sede->id); ?>)" data-bs-toggle="modal" data-bs-target="#showaccesorios<?php echo e($sede->id); ?>" data-id="areaalmacen" >Accesorios</button>
                                                    </span>
                                                    <span class="float-end">
                                                        <?php echo e($alm_accesorios_sum?round($alm_accesorios_sum, 2):'0'); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3 shadow-sm border-0 bg-light">
                                            <div class="card-body">
                                                <div class="clearfix text-uppercase fw-bold">
                                                    <span class="float-start">
                                                        <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" onclick="repuestos(<?php echo e($sede->id); ?>)" data-bs-toggle="modal" data-bs-target="#showrepuestos<?php echo e($sede->id); ?>" data-id="areaalmacen" >Repuestos</button>
                                                    </span>
                                                    <span class="float-end">
                                                        <?php echo e($alm_repuestos_sum?round($alm_repuestos_sum, 2):'0'); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3 shadow-sm border-0 bg-light">
                                            <div class="card-body">
                                                <div class="clearfix text-uppercase fw-bold">
                                                    <span class="float-start">
                                                        <button class="stretched-link text-uppercase text-dark fw-bold bg-transparent border-0 p-0 m-0" onclick="modulo_solar(<?php echo e($sede->id); ?>)" data-bs-toggle="modal" data-bs-target="#showmodulo_solar<?php echo e($sede->id); ?>" data-id="modulo_solar" >Modulo Solar</button>
                                                    </span>
                                                    <span class="float-end">
                                                        <?php echo e($alm_modulo_solar_sum?$alm_modulo_solar_sum:'0'); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $sedes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('ADMINISTRADOR.ALMACEN.inventarios.showaccesorios', ['sede_id' => $sede->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('ADMINISTRADOR.ALMACEN.inventarios.showrepuestos', ['sede_id' => $sede->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('ADMINISTRADOR.ALMACEN.inventarios.showmodulo_solar', ['sede_id' => $sede->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        function accesorios(x) {
            $filtro_inventario = $('#tipo_accesorios'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('accesorios_request');
            $('#filtro_tipo_total').val('accesorios_request');
            
            $('#filtro_tipo'+x).val('accesorios_request');
            $('#filtro_tipo_total'+x).val('accesorios_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
                
         }
        function repuestos(x) {
            $filtro_inventario = $('#tipo_repuestos'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('repuestos_request');
            $('#filtro_tipo_total').val('repuestos_request');
            
            $('#filtro_tipo'+x).val('repuestos_request');
            $('#filtro_tipo_total'+x).val('repuestos_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
         }
         function modulo_solar(x) {
            $filtro_inventario = $('#tipo_modulo_solar'+x).val();
            $('#filtro_tipo').val($filtro_inventario);
            $('#filtro_tipo').val('modulo_solar_request');
            $('#filtro_tipo_total').val('modulo_solar_request');
            
            $('#filtro_tipo'+x).val('modulo_solar_request');
            $('#filtro_tipo_total'+x).val('modulo_solar_request');
            console.log($filtro_inventario);
            
            $('#sede_id_value'+x).on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val'+x).val(valor_sede);
            });
         }
    </script>

    <script>
        $(document).ready(function(){
                $('#sede_id_value').on('change', function(){
                var valor_sede = $(this).val();
                $('#sede_id_val').val(valor_sede);
            });
        });
    </script>

    <script>
        function accesoriosdetalle(el, sedeId, productoId){
            console.log('compradetalle called:', { el: el, sedeId: sedeId, productoId: productoId });
        }
        function repuestosdetalle(el, sedeId, productoId){
            console.log('compradetalle called:', { el: el, sedeId: sedeId, productoId: productoId });
        }
        function modulosolardetalle(el, sedeId, productoId){
            console.log('compradetalle called:', { el: el, sedeId: sedeId, productoId: productoId });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ADMIN\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/ALMACEN/inventarios/index.blade.php ENDPATH**/ ?>