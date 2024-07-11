@extends('customer.layout')

@section('content')
    <div class="lazy-backdrop" id="overlay-loading">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
            </div>
            <p class="text-light">Sedang Menyimpan Data...</p>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <p class="page-title">Product Kami</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.product') }}">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->nama }}</li>
            </ol>
        </nav>
    </div>
    <div class="product-detail-container">
        <div class="product-detail-image-container">
            <div class="image-container">
                <img src="{{ $product->gambar }}" alt="product-image">
            </div>
        </div>
        <div class="product-detail-info-container">
            <p class="product-name">{{ $product->nama }}</p>
            <div class="d-flex align-items-center selling-info mb-3">
                <span class="product-sell-info me-1">Terjual</span>
                <span class="me-2">100+</span>
                <i class="bx bxs-star me-1"></i>
                <span class="product-sell-info">4</span>
            </div>
            <p class="product-price mb-3">Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
            <p style="color: var(--bg-primary); font-weight: bold; font-size: 1em;">Deskripsi</p>
            <div class="description-wrapper">{!! $product->deskripsi !!}</div>
        </div>
        <div class="product-detail-action-container">
            <p style="font-weight: bold; color: var(--dark);">Atur Jumlah</p>
            <p style="font-size: 0.8em; color: var(--dark); margin-bottom: 0;">Stok: <span
                    style="font-weight: bold; color: var(--bg-primary)">Sisa {{ $product->qty }}</span></p>
            <div class="qty-change-container mb-3">
                <a href="#" class="qty-change" data-type="minus"><i class='bx bx-minus'></i></a>
                <input type="number" value="1" id="qty-value"/>
                <a href="#" class="qty-change" data-type="plus"><i class='bx bx-plus'></i></a>
            </div>
            <div class="d-flex align-items-center justify-content-between" style="font-size: 1em;">
                <span style="color: var(--dark-tint);">Subtotal</span>
                <span id="lbl-sub-total"
                      style="color: var(--dark); font-weight: 600;">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
            </div>
            <hr class="custom-divider"/>
            @auth()
                <a href="#" class="btn-cart mb-1" id="btn-cart" data-id="{{ $product->id }}">Keranjang</a>
                <a href="#" class="btn-shop" id="btn-shop" data-id="{{ $product->id }}">Beli</a>
            @else
                <a href="{{ route('customer.login') }}" class="btn-cart mb-1">Keranjang</a>
                <a href="{{ route('customer.login') }}" class="btn-shop">Beli</a>
            @endauth
        </div>
    </div>
    <hr class="custom-divider"/>
    <p class="section-title">Rekomendasi Produk Lainnya</p>
    <div class="product-container mb-3">
        @foreach($recommends as $recommend)
            <div class="card-product" data-id="{{ $recommend->id }}">
                <div class="image-container">
                    <img src="{{ $recommend->gambar }}" alt="img-product">
                </div>
                <div class="product-info w-100">
                    <p class="product-name">{{ $recommend->nama }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="product-rate">
                            <i class='bx bxs-star'></i>
                            <span>5</span>
                        </div>
                        <p class="product-price">Rp.{{ number_format($recommend->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="product-action">
                    <a href="#" class="btn-shop" data-id="{{ $recommend->id }}">
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="w-100 d-flex justify-content-center">
        <a href="{{ route('customer.product') }}" style="font-size: 1em; color: var(--bg-primary); text-decoration: none;">Lihat Produk Lainnya</a>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var strPrice = '{{ $product->harga }}';
        var strQTY = '{{ $product->qty }}';
        var cartURL = '{{ route('customer.cart') }}';

        function eventChangeSubTotal(qty = 0) {
            let intPrice = parseInt(strPrice);
            let subTotal = intPrice * qty;
            $('#lbl-sub-total').html('Rp' + subTotal.toLocaleString('id-ID'));
        }

        function eventAddToCart() {
            $('#btn-cart').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                addToCartHandler(id)
            })
        }

        async function addToCartHandler(id) {
            try {
                let qty = $('#qty-value').val();
                blockLoading(true);
                await $.post(cartURL, {
                    id, qty
                });
                blockLoading(false);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil menambahkan product ke keranjang...',
                    icon: 'success',
                    timer: 700
                }).then(() => {
                    window.location.reload();
                })
            }catch (e) {
                blockLoading(false);
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }
        }

        function eventProductAction() {
            $('.card-product').on('click', function () {
                let id = this.dataset.id;
                window.location.href = '/product/' + id;
            })

            $('.btn-shop').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let id = this.dataset.id;
                window.location.href = '/product/' + id;
            })
        }

        $(document).ready(function () {
            eventQtyChange(parseInt(strQTY), function (newVal) {
                eventChangeSubTotal(newVal)
            });
            eventAddToCart();
            eventProductAction();
        })
    </script>
@endsection
