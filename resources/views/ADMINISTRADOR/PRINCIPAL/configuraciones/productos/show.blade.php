@extends('TEMPLATES.administrador')

@section('title', 'PRODUCTOS')

@section('css')
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
@endsection

@section('content')
<!-- Encabezado -->
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div class="" data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">PRODUCTOS</h1>
                <div class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-configuraciones') }}">Configuraciones</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ url('admin-productos') }}">Productos</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $admin_producto->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!-- fin encabezado -->
 
    {{-- Contenido --}}
        <div class="container-fluid">
            <div class="card border-4 borde-top-secondary shadow-sm h-100" style="border-radius: 20px; min-height: 500px" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="
                                        @if($admin_producto->imagen == 'NULL')
                                        /images/icon.png
                                        @else
                                        /images/productos/{{ $admin_producto->imagen }}
                                        @endif
                                        " />
                                    </div>
                                    @foreach($admin_producto->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image->url }}"/>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next nav__btn"></div>
                                <div class="swiper-button-prev nav__btn"></div>
                            </div>
                            <div thumbsSlider="" class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="
                                        @if($admin_producto->imagen)
                                        /images/productos/{{ $admin_producto->imagen }}
                                        @else
                                        /images/icon.png
                                        @endif
                                        "/>
                                    </div>
                                    @foreach($admin_producto->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image->url }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 d-flex">
                            <div class="contenido align-self-center w-100">
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        <small class="text-uppercase fw-bold text-muted">{{ $admin_producto->clasificacion }}</small>
                                        <h1 class="fw-light text-uppercase mb-0">{{ $admin_producto->name }}</h1>
                                        <div class="row g-2 mb-2">
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Tipo de bien</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ $admin_producto->tipo->name }}">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Categoría</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ $admin_producto->categorie->name }}">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>U.M.</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ $admin_producto->medida->nombre}}">
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Marca</small></label>
                                                <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ $admin_producto->marca->name }}">
                                            </div>
                                        </div>

                                        @if( $admin_producto->tipo_id == 1)
                                        @elseif( $admin_producto->tipo_id == 2)
                                            <div class="row g-2 mb-2">
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Vida útil</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ $admin_producto->vida_util }}">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Costo</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ number_format($admin_producto->costo, 2, '.', ',') }}">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Depreciación</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ number_format($admin_producto->depreciacion, 2, '.', ',') }}">
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>T. Adquisición</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="{{ $admin_producto->tipo_adquisicion }}">
                                                </div>
                                            </div>
                                        @elseif( $admin_producto->tipo_id == 3)
                                            <div class="row g-2 mb-2">
                                                <div class="col-6 col-md-3">
                                                    <label for="" class="small text-uppercase bg-white text-muted px-1 ms-2"><small>Precio</small></label>
                                                    <input class="form-control bg-white pb-0 text-center" disabled style="margin-top: -12px" value="S/ {{ number_format($admin_producto->precio, 2, '.', ',') }}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="mt-4">
                                            <div class="" style="min-height: 150px">
                                                @if( $admin_producto->clasificacion == 'Compras' )
                                                    <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Proveedores</span></p>
                                                    @forelse($admin_producto->proveedores as $proveedor)
                                                        <span class="badge bg-info small text-uppercase">{{ $proveedor->persona->name }}</span>         
                                                    @empty
                                                        <span class="text-muted small text-uppercase fw-light">No hay registros</span>
                                                    @endforelse                                             
                                                @elseif( $admin_producto->clasificacion == 'Productos Terminados' )
                                                    <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Etiquetas</span></p>
                                                    @forelse($admin_producto->etiquetas as $etiqueta)
                                                        <span class="badge bg-info small text-uppercase">{{ $etiqueta->name }}</span>         
                                                    @empty
                                                        <span class="text-muted small text-uppercase fw-light">No hay registros</span>
                                                    @endforelse
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Descripción</span></p>
                                            <div class="" style="min-height: 150px">
                                                <p class="mb-1">{!! $admin_producto->descripcion !!}</p>
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
                <a href="{{url('admin-productos')}}" class="btn btn-outline-secondary px-5">Volver</a>
            </div>     
        </div> 
    {{-- Fin contenido --}}

@endsection

@section('js')
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
@endsection