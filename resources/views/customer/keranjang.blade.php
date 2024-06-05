@extends('customer.layout')

@section('content')
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <p class="page-title">Keranjang</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex" style="gap: 1rem">
        <div class="cart-list-container">
            <p style="font-size: 0.8em; font-weight: bold; color: var(--dark);">Daftar Belanja</p>
            <div class="cart-item-container">
                <img src="{{ asset('/assets/images/sample.png') }}" alt="product-image">
            </div>
        </div>
        <div class="cart-action-container">
            <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Ringkasan Belanja</p>
            <div class="d-flex align-items-center justify-content-between" style="font-size: 1em;">
                <span style="color: var(--dark-tint);">Total</span>
                <span id="lbl-sub-total" style="color: var(--dark); font-weight: bold;">Rp{{ number_format(30000000, 0, ',', '.') }}</span>
            </div>
            <hr class="custom-divider" />
            <a href="#" class="btn-action-primary mb-1">Beli</a>
        </div>
    </div>
@endsection
