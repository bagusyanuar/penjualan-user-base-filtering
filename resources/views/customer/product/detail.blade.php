@extends('customer.layout')

@section('content')
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
                    style="font-weight: bold; color: var(--bg-primary)">Sisa {{ 4 }}</span></p>
            <div class="qty-change-container mb-3">
                <a href="#" class="qty-change" data-type="minus"><i class='bx bx-minus'></i></a>
                <input type="number" value="1" id="qty-value"/>
                <a href="#" class="qty-change" data-type="plus"><i class='bx bx-plus'></i></a>
            </div>
            <div class="d-flex align-items-center justify-content-between" style="font-size: 1em;">
                <span style="color: var(--dark-tint);">Subtotal</span>
                <span id="lbl-sub-total" style="color: var(--dark); font-weight: 600;">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
            </div>
            <hr class="custom-divider" />
            <a href="#" class="btn-cart mb-1">Keranjang</a>
            <a href="#" class="btn-shop">Beli</a>
        </div>
    </div>
    <hr class="custom-divider" />
    <p class="section-title">Rekomendasi Produk Lainnya</p>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var strPrice = '{{ $product->harga }}';

        function eventChangeSubTotal(qty = 0) {
            let intPrice = parseInt(strPrice);
            let subTotal = intPrice * qty;
            $('#lbl-sub-total').html('Rp'+subTotal.toLocaleString('id-ID'));
        }

        $(document).ready(function () {
            eventQtyChange(4, function (newVal) {
                eventChangeSubTotal(newVal)
            })
        })
    </script>
@endsection
