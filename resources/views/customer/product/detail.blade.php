@extends('customer.layout')

@section('content')
    <div class="w-100 d-flex justify-content-between align-items-center mb-5">
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
            <p class="product-price mb-3">Rp5.500.000</p>
            <p style="color: var(--bg-primary); font-weight: bold; font-size: 1em;">Deskripsi</p>
            <div>{!! $product->deskripsi !!}</div>
        </div>
        <div class="product-detail-action-container">
            <p style="font-weight: bold; color: var(--dark);">Atur Jumlah</p>
        </div>
    </div>
@endsection
