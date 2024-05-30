@extends('customer.layout')

@section('content')
{{--    <div class="slick-banner">--}}
{{--        <div class="banner-container">--}}
{{--            <img src="{{ asset('/assets/images/banner-hp-1.webp') }}" alt="img-banner">--}}
{{--        </div>--}}
{{--        <div class="banner-container">--}}
{{--            <img src="{{ asset('/assets/images/banner-hp-1.webp') }}" alt="img-banner">--}}
{{--        </div>--}}
{{--    </div>--}}
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
                centerMode: true,
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
