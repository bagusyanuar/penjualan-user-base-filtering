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
    <section id="new-product-section" class="content-section mb-5">
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
                <div class="product-action">
                    <a href="#" class="btn-cart">
                        <i class='bx bx-cart-alt'></i>
                    </a>
                    <a href="#" class="btn-shop">
                        <i class='bx bx-shopping-bag'></i>
                    </a>
                </div>
            </div>
            <div class="card-product"></div>
            <div class="card-product"></div>
            <div class="card-product"></div>
            <div class="card-product"></div>
        </div>
    </section>
    <section id="our-brand" class="content-section">
        <p class="section-title">BRAND KAMI</p>
        <div class="slick-brand">
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/imoo.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/infinix.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/iphone.gif') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/sharp.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/realme.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/oppo.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/mi.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/vivo.png') }}" alt="img-brand" height="100">
            </div>
            <div class="slick-brand-container">
                <img src="{{ asset('/assets/brands/samsung.png') }}" alt="img-brand" height="100">
            </div>
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
            })
        }

        function setupSlickBrand() {
            $('.slick-brand').slick({
                infinite: true,
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                arrows: false,
                autoplaySpeed: 1000,
            })
        }

        $(document).ready(function () {
            setupSlickBanner();
            setupSlickBrand();
        })
    </script>
@endsection
