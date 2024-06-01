@extends('customer.layout')

@section('content')
    <div class="slick-banner mb-5">
        <div class="banner-container">
            <img src="{{ asset('/assets/images/banner-hp-1.webp') }}" alt="img-banner">
        </div>
        <div class="banner-container">
            <img src="{{ asset('/assets/images/banner-hp-1.webp') }}" alt="img-banner">
        </div>
    </div>
    <section id="new-product-section" class="content-section">
        <p class="section-title">PRODUK TERBARU</p>
        <div class="product-container">
            <div class="card-product">
                <div class="image-container">
                    <img src="{{ asset('/assets/images/sample.png') }}" alt="img-product">
                </div>
                <div class="product-info w-100">
                    <p class="product-name">Samsung Galaxy S23 FE - 8GB+256GB asDqwe SDqueiasj asdu</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="product-rate">
                            <i class='bx bxs-star'></i>
                            <span>5</span>
                        </div>
                        <p class="product-price">Rp.5.000.000</p>
                    </div>
                </div>
            </div>
            <div class="card-product"></div>
            <div class="card-product"></div>
            <div class="card-product"></div>
            <div class="card-product"></div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>

        function setupSlickBanner() {
            $('.slick-banner').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 1000,
                // responsive: [
                //     {
                //         breakpoint: 1024,
                //         settings: {
                //             slidesToShow: 31,
                //             slidesToScroll: 3,
                //             infinite: true,
                //             dots: true
                //         }
                //     },
                //     {
                //         breakpoint: 768,
                //         settings: {
                //             slidesToShow: 2,
                //             slidesToScroll: 2
                //         }
                //     },
                //     {
                //         breakpoint: 480,
                //         settings: {
                //             slidesToShow: 1,
                //             slidesToScroll: 1
                //         }
                //     }
                //
                // ]
            })
        }

        $(document).ready(function () {
            setupSlickBanner();
        })
    </script>
@endsection
