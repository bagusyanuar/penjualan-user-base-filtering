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
            <div class="cart-item-container mb-3">
                <img src="{{ asset('/assets/images/sample.png') }}" alt="product-image">
                <div class="flex-grow-1">
                    <p style="color: var(--dark); font-size: 1em; margin-bottom: 0; font-weight: bold">IPhone 13 Pro MAX</p>
                    <p style="margin-bottom: 0; color: var(--dark-tint); font-size: 0.8em;">IPhone</p>
                    <div class="d-flex align-items-center" style="font-size: 0.8em;">
                        <span style="color: var(--dark-tint);" class="me-1">Jumlah: </span>
                        <span style="color: var(--dark); font-weight: bold;">3 PCS</span>
                    </div>
                    <div class="d-flex justify-content-end w-100">
                        <a href="#" class="btn-delete-item">
                            <i class='bx bx-trash'></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="width: 150px;">
                    <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Rp13.000.000</p>
                </div>
            </div>
            <div class="cart-item-container mb-3">
                <img src="{{ asset('/assets/images/sample.png') }}" alt="product-image">
                <div class="flex-grow-1">
                    <p style="color: var(--dark); font-size: 1em; margin-bottom: 0; font-weight: bold">IPhone 13 Pro MAX</p>
                    <p style="margin-bottom: 0; color: var(--dark-tint); font-size: 0.8em;">IPhone</p>
                    <div class="d-flex align-items-center" style="font-size: 0.8em;">
                        <span style="color: var(--dark-tint);" class="me-1">Jumlah: </span>
                        <span style="color: var(--dark); font-weight: bold;">3 PCS</span>
                    </div>
                    <div class="d-flex justify-content-end w-100">
                        <a href="#" class="btn-delete-item">
                            <i class='bx bx-trash'></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="width: 150px;">
                    <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Rp13.000.000</p>
                </div>
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
