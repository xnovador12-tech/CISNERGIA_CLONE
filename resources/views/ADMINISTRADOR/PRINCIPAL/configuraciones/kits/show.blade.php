<style>
    .swiper {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .mySwiper2 {
        height: 300px;
        width: 100%;
    }

    .mySwiper {
        height: 90px;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mySwiper .swiper-slide {
        opacity: 0.5;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }
</style>

<div class="modal fade" id="showkit{{ $admin_kit->slug }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white py-2">
                <span class="modal-title text-uppercase small" id="staticBackdropLabel">Actualizar Kits</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label for="name_id">Codigo<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm bg-white" value="{{ $admin_kit->codigo }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label for="name_id">Precio Total<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm bg-white" value="{{ $admin_kit->precio_total }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label for="name_id">Cantidad Total<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm bg-white" value="{{ $admin_kit->cantidad_total }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="name_id">Etiqueta<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm bg-white" value="{{ $admin_kit->etiquetas->pluck('name')->implode(', ') }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="mt-4">
                                    <p class="text-uppercase mb-1 fw-bold small"><span class="border-top border-2 border-primary py-2">Descripción</span></p>
                                    <div class="" style="min-height: 150px">
                                        <p class="mb-1">{!! $admin_kit->descripcion !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="mb-3 text-center">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                <div class="swiper-wrapper">
                                    @forelse($admin_kit->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image->url }}"/>
                                        </div>
                                    @empty
                                        <div class="swiper-slide">
                                            <img src="/images/icon.png"/>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="swiper-button-next nav__btn"></div>
                                <div class="swiper-button-prev nav__btn"></div>
                            </div>
                            <div thumbsSlider="" class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    @forelse($admin_kit->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image->url }}"/>
                                        </div>
                                    @empty
                                        <div class="swiper-slide">
                                            <img src="/images/icon.png"/>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>                           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark text-uppercase small px-5 text-white" data-bs-dismiss="modal">Regresar</button>   
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function previewImage(nb) {        
        var reader = new FileReader();         
        reader.readAsDataURL(document.getElementById('uploadImage'+nb).files[0]);         
        reader.onload = function (e) {             
            document.getElementById('uploadPreview'+nb).src = e.target.result;         
        };     
        }
    </script>
    <script>
        document.querySelectorAll('.modal[id^="showkit"]').forEach(function(modal) {
            modal.addEventListener('shown.bs.modal', function() {
                if (modal.dataset.swiperInit) return;

                var thumbsEl = modal.querySelector('.mySwiper');
                var mainEl = modal.querySelector('.mySwiper2');
                if (!thumbsEl || !mainEl) return;

                var thumbsSwiper = new Swiper(thumbsEl, {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                });

                new Swiper(mainEl, {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: modal.querySelector('.swiper-button-next'),
                        prevEl: modal.querySelector('.swiper-button-prev'),
                    },
                    thumbs: {
                        swiper: thumbsSwiper,
                    },
                });

                modal.dataset.swiperInit = 'true';
            });
        });
    </script>
@endpush