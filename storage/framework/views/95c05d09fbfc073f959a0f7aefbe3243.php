<?php $__env->startSection('title', 'KITS'); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #container_images_multiple{
        display: flex;
        justify-content: space-evenly;
        gap: 20px;
        flex-wrap: wrap;
    }

    figure{
        width: 30%;
    }

    .img_opcional{
        width: 100%;
        height: 150px;
    }

    figcaption{
        text-align: center;
        font-size: 1.8vmin;
        margin-top: 0.5vmin;
    }

    @media only screen and (min-width:320px) and (max-width:768px){
        .img_opcional{
        width: 100%;
        height: 90px;
    }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
<div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">KITS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-kits')); ?>">Kits</a></li>
                        <li class="breadcrumb-item" aria-current="page">Nuevo registro</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->

    
    <form method="POST" action="/admin-kits" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>      
        <?php echo csrf_field(); ?>
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <div class="card border-0 rounded-0 border-start border-3 border-info mb-4" style="box-shadow: rgba(17, 17, 26, 0.1) 0px 1px 0px; background-color: #f6f6f6">
                        <div class="card-body py-2">
                            <i class="bi bi-info-circle text-info me-2"></i>Importante:
                            <ul class="list-unstyled mb-0 pb-0">
                                <li class="mb-0 pb-0">
                                    <small class="text-muted py-0 my-0 text-start"> Se consideran campos obligatorios los campos que tengan este simbolo: <span class="text-danger">*</small></span>
                                </li>
                                <li class="mb-0 pb-0">
                                    <small class="text-muted">Se recomienda tener en cuenta las siguientes medidas para la imágen: <span class="fw-bold">1200 x 1200 px.</span> Peso máximo de imagen:<span class="fw-bold"> 3 MB.</span></small>
                                </li>
                            </ul>
                        </div>
                    </div>     

                    <div class="row">
                        <p class="text-secondary mb-2 small text-uppercase fw-bold">Datos generales</p>
                        <div class="row">
                            <div class="col-12 col-md-7 col-lg-7">
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="mb-3">
                                            <label for="codigo_id" class="">Codigo<span class="text-danger">*</span></label>
                                            <input type="text" value="<?php echo e($codigo); ?>" class="form-control form-control-sm bg-white" disabled id="codigo_id">
                                            <input hidden value="<?php echo e($codigo); ?>" name="codigo">
                                            <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-lg-2">
                                        <div class="mb-3">
                                            <label for="precio_total_id" class="">Precio Total<span class="text-danger">*</span></label>
                                            <input type="text" name="precio_total" class="form-control form-control-sm <?php $__errorArgs = ['precio_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <?php $__errorArgs = ['precio_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="mb-3">
                                            <label for="cantidad_total_id" class="">Cantidad Total<span class="text-danger">*</span></label>
                                            <input type="number" disabled id="cantidad_total_id_disabled" class="form-control form-control-sm <?php $__errorArgs = ['cantidad_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <input type="number" hidden name="cantidad_total" id="cantidad_total_id" class="form-control form-control-sm <?php $__errorArgs = ['cantidad_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <?php $__errorArgs = ['cantidad_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="mb-3">
                                            <label for="codigo_id" class="">Etiqueta<span class="text-danger">*</span></label>
                                            <div class="form-check form-switch">
                                                <select class="js-example-basic-multiple form-select form-select-sm select2" name="etiquetas[]" multiple="multiple" style="width:100%">
                                                    <?php $__currentLoopData = $etiquetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($etiqueta->id); ?>"><?php echo e($etiqueta->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="descripcion_id" class="">Descripción</label>
                                            <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="descripcion" id="editor" placeholder="Escribe una descripción" style="height: 210px"><?php echo e(old('descripcion')); ?></textarea>
                                            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 col-lg-5">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <p class="text-primary mb-2 small text-uppercase fw-bold">Detalles</p>
                                        <div class="row g-2">
                                            <div class="col-6 col-md-6 col-lg-6 mb-3">
                                                <label for="productos_id" class=" d-block">Bienes</label>
                                                <select class="form-select select2 form-select-sm" id="productos_id">
                                                    <option selected disabled>Seleccione una opción</option>
                                                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($producto->id); ?>_<?php echo e($producto->name); ?>"><?php echo e($producto->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>  
                                            </div>
                                            <div class="col-6 col-md-4 col-lg-4 mb-3">
                                                <label for="cantidad_id" class=" d-block">Cantidad</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" min="0" id="cantidad_id" class="float-end form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2 col-lg-2 mb-3 d-flex align-items-end">
                                                <button type="button" id="btnasignar" class="btn btn-secondary btn-sm w-100 text-white" style="padding: 0.375rem 0.75rem;">
                                                    Agregar
                                                </button>
                                            </div>
                                        </div>
                                        <table class=" table table-sm table-hover">
                                            <thead class="bg-light">
                                            <tr>
                                                <th class="fw-bold small text-uppercase">N°</th>
                                                <th class="fw-bold small text-uppercase">Producto</th>
                                                <th class="fw-bold small text-uppercase">Cantidad</th>
                                                <th class="fw-bold small text-uppercase"></th>
                                            </tr>
                                            </thead>
                                            <tbody id="dtll_combo">
                                                
                                            </tbody>
                                        </table>
                                    </div>    
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <p class="text-muted mb-2 small text-uppercase fw-bold">Cargue más imágenes (opcional)</p> 
                                            <div class="card imagecardfiles" style="min-height: 200px">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <label for="multiple__imagenes" class="btn btn-sm btn-secondary"><i class="bi bi-upload me-2"></i>Subir imágenes</label>
                                                            <input type="file" onchange="preview()" multiple accept="image/*" id="multiple__imagenes" name="images_opcional[]" hidden>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <p id="numero_archivos" class="text-start text-md-end small fw-bold text-muted">0 archivos seleccionados</p>
                                                        </div>
                                                    </div>
                                                    <div id="container_images_multiple">
                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                      
                </div>
            </div>
            <div class="pt-3 pb-3 text-end" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <a href="<?php echo e(url('admin-kits')); ?>" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 my-2 my-md-0 text-white">Registrar</button>
            </div>     
        </div> 
    </form>
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    function previewImagePrincipal(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);                
        reader.onload = function (e) {   
            document.getElementById('uploadPreview'+nb).src = e.target.result;                  
        };     
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    var contador_comb = 1;
    cantidad_totalg=0;
    $('#btnasignar').click(function() {
        var producto = document.getElementById('productos_id').value.split('_');
        var cantidad = $('#cantidad_id').val();
        if(producto && cantidad > 0){
            cantidad_totalg+=Number(cantidad);
            var fila = '<tr class="selected igv_carta" id="filamp' + contador_comb +
                                    '"><td class="align-middle fw-normal">' + contador_comb + '</td><td class="align-middle fw-normal">' + producto[1] +
                                    '</td><td class="align-middle fw-normal">' + cantidad +
                                    '</td><input type="hidden" name="producto_id[]" value="' + producto[0] +
                                    '"><input type="hidden" name="cantidad[]" value="' + cantidad +
                                    '"><td class="align-middle"><button type="button" class="btn btn-sm btn-danger text-white" onclick="eliminarcombo(' +
                            contador_comb +','+cantidad+','+producto[0]+');"><i class="bi bi-trash"></i></button></td></tr>';
                            contador_comb++;
                            $('#productos_id').prop('selectedIndex', 0).change();
                            $('#cantidad_id').val("");
                            $('#cantidad_total_id').val(cantidad_totalg);
                            $('#cantidad_total_id_disabled').val(cantidad_totalg);
                            $('#dtll_combo').append(fila);
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error al ingresar el detalle del ingreso, revise los datos del requerimiento',
            })
        }
    });

    function eliminarcombo(indexmp, cantidad, protipo_id) {
        cantidad = Number(cantidad);
        
        // Validar que cantidad sea válido
        if (isNaN(cantidad) || cantidad < 0) return;
        
        // Evitar que el total sea negativo
        cantidad_totalg = Math.max(0, cantidad_totalg - cantidad);
        
        $('#cantidad_total_id').val(cantidad_totalg);
        $('#cantidad_total_id_disabled').val(cantidad_totalg);
        $("#filamp" + indexmp).remove();

        if(cantidad_totalg == 0){
            contador_comb = 1;
        }
    }
</script>
<script>
    let multiple__imagenes = document.getElementById("multiple__imagenes");
    let container_images_multiple = document.getElementById("container_images_multiple");
    let numero_archivos = document.getElementById("numero_archivos");

    function preview(){
        container_images_multiple.innerHTML = "";
        numero_archivos.textContent = `${multiple__imagenes.files.length} archivos seleccionados`;

        for(i of multiple__imagenes.files){
            let reader = new FileReader();
            let figure = document.createElement("figure");
            let figCap = document.createElement("figcaption");
            figCap.innerText = i.name;
            figure.appendChild(figCap);
            reader.onload=()=>{
                let img = document.createElement("img");
                img.setAttribute("src",reader.result);
                img.classList.add('img_opcional');
                figure.insertBefore(img,figCap);
            }
            container_images_multiple.appendChild(figure);
            reader.readAsDataURL(i);
        }

    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/kits/create.blade.php ENDPATH**/ ?>