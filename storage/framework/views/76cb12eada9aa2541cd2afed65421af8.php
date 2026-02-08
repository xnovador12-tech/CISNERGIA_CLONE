<?php $__env->startSection('title', 'PRODUCTOS'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
<style>
    .producto
    {
        width: 100%;
        height: 150px;
        border: 8px solid #fff;
    }

    .img_producto{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nav__btn
    {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        /* transform: translateY(10px); */
        background-color: rgba(0, 0, 0, 0.5);
        transition: 0.2s;
    }

    .nav__btn:hover{
        background-color: rgba(0, 0, 0, 0.8);
    }

    .nav__btn::after,
    .nav__btn::before{
        font-size: 20px;
        color: #FFFFFF;
    }

    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        /* height: 100%; */
        object-fit: cover;
    }

    .swiper {
        width: 100%;
        height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .mySwiper2 {
        height: auto;
        width: 100%;
    }

    .mySwiper {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PRODUCTOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-configuraciones')); ?>">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="<?php echo e(url('admin-productos')); ?>">Productos</a></li>
                        <li class="breadcrumb-item" aria-current="page"><?php echo e($admin_producto->name); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->
 
    
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="
                                        <?php if($admin_producto->imagen == 'NULL'): ?>
                                        /images/icon.png
                                        <?php else: ?>
                                        /images/productos/<?php echo e($admin_producto->imagen); ?>

                                        <?php endif; ?>
                                        " />
                                    </div>
                                    <?php $__currentLoopData = $admin_producto->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <img src="<?php echo e($image->url); ?>"/>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="swiper-button-next nav__btn"></div>
                                <div class="swiper-button-prev nav__btn"></div>
                            </div>
                            <div thumbsSlider="" class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="
                                        <?php if($admin_producto->imagen): ?>
                                        /images/productos/<?php echo e($admin_producto->imagen); ?>

                                        <?php else: ?>
                                        /images/icon.png
                                        <?php endif; ?>
                                        "/>
                                    </div>
                                    <?php $__currentLoopData = $admin_producto->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="swiper-slide">
                                            <img src="<?php echo e($image->url); ?>"/>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 d-flex">
                            <div class="contenido align-self-center w-100">
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        <h1 class="fw-light text-uppercase mb-0"><?php echo e($admin_producto->name); ?></h1>
                                        <div class="row g-2 mb-2">
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Tipo de bien</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e($admin_producto->tipo->name); ?>">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Categoría</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e($admin_producto->categorie->name); ?>">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>U.M.</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e($admin_producto->medida->nombre); ?>">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Marca</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e($admin_producto->marca->name); ?>">
                                            </div>
                                        </div>

                                        <?php if( $admin_producto->tipo_id == 1): ?>
                                        <?php elseif( $admin_producto->tipo_id == 2): ?>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Vida útil</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e($admin_producto->vida_util); ?>">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Costo</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e(number_format($admin_producto->costo, 2, '.', ',')); ?>">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Depreciación</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e(number_format($admin_producto->depreciacion, 2, '.', ',')); ?>">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>T. Adquisición</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="<?php echo e($admin_producto->tipo_adquisicion); ?>">
                                                </div>
                                            </div>
                                        <?php elseif( $admin_producto->tipo_id == 3): ?>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Precio</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="S/ <?php echo e(number_format($admin_producto->precio, 2, '.', ',')); ?>">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-4">
                                            <div class="" style="min-height: 150px">
                                                <?php if( $admin_producto->proveedores ): ?>
                                                    <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Proveedores</span></p>
                                                    <?php $__empty_1 = true; $__currentLoopData = $admin_producto->proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <span class="badge bg-info small text-uppercase"><?php echo e($proveedor->persona->name); ?></span>         
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <span class="text-muted small text-uppercase fw-light">No hay registros</span>
                                                    <?php endif; ?>                                             
                                                <?php elseif($admin_producto->etiquetas): ?>
                                                    <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Etiquetas</span></p>
                                                    <?php $__empty_1 = true; $__currentLoopData = $admin_producto->etiquetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <span class="badge bg-info small text-uppercase"><?php echo e($etiqueta->name); ?></span>         
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <span class="text-muted small text-uppercase fw-light">No hay registros</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Descripción</span></p>
                                            <div class="" style="min-height: 150px">
                                                <p class="mb-1"><?php echo $admin_producto->descripcion; ?></p>
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
                <a href="<?php echo e(url('admin-productos')); ?>" class="btn btn-outline-secondary px-5">Volver</a>
            </div>     
        </div> 
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('TEMPLATES.administrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CESHER\Documents\GitHub\project_cisnergia\resources\views/ADMINISTRADOR/PRINCIPAL/configuraciones/productos/show.blade.php ENDPATH**/ ?>