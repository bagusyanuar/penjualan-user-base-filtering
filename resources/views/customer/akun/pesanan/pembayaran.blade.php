@extends('customer.layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", '{{ \Illuminate\Support\Facades\Session::get('failed') }}', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ \Illuminate\Support\Facades\Session::get('success') }}',
                icon: 'success',
                timer: 700
            }).then(() => {
                window.location.reload();
            })
        </script>
    @endif
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <p class="page-title">Pesanan</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.order') }}">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->no_penjualan }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex">
        <div class="categories-sidebar">
            <a href="{{ route('customer.account') }}" class="categories-link">Akun Saya</a>
            <a href="{{ route('customer.order') }}" class="categories-link active">Pesanan</a>
            <a href="{{ route('customer.logout') }}" class="categories-link">Logout</a>
        </div>
        <div class="flex-grow-1" style="padding-left: 25px">
            <div class="mb-3" style="font-size: 0.8em; color: var(--dark);">
                <div class="d-flex align-items-center mb-1">
                    <span style="" class="me-2">No. Pembelian :</span>
                    <span style="font-weight: 600;">{{ $data->no_penjualan }}</span>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="" class="me-2">Tgl. Pembelian :</span>
                    <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</span>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="" class="me-2">Metode Pengiriman :</span>
                    @if($data->is_kirim)
                        <div class="d-flex align-items-center gap-1">
                            <div class="delivery-status-container"><i class="bx bx-car"></i></div>
                            <span style="font-weight: 600;">Di Kirim</span>
                        </div>
                    @else
                        <span style="font-weight: 600;">Ambil Sendiri</span>
                    @endif
                </div>
                @if($data->is_kirim)
                    <div class="d-flex align-items-center mb-1">
                        <span style="" class="me-2">Alamat Pengiriman :</span>
                        <span style="font-weight: 600;">{{ $data->alamat }} ({{ $data->kota }})</span>
                    </div>
                @endif
                <div class="d-flex align-items-center mb-1">
                    <span style="" class="me-2">Status :</span>
                    <span style="font-weight: 600;">
                        @if($data->status === 0)
                            <div class="chip-status-danger">menunggu pembayaran</div>
                        @endif
                    </span>
                </div>
            </div>
            <hr class="custom-divider"/>
            <div class="d-flex w-100 gap-3">
                <div class="flex-grow-1 d-flex gap-2">
                    <div class="w-100 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('/assets/images/payment-bg.png') }}" alt="payment-image">
                    </div>
                </div>
                <div class="card-content" style="width: 400px; height: fit-content;">
                    <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Pembayaran</p>
                    <hr class="custom-divider"/>
                    <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                        <span style="color: var(--dark); font-size: 0.8em">Total</span>
                        <span id="lbl-total"
                              style="color: var(--dark); font-weight: bold;">Rp{{ number_format($data->total, 0, ',', '.') }}</span>
                    </div>
                    <hr class="custom-divider"/>
                    <div class="w-100 mb-3">
                        <label for="category" class="form-label input-label">Kategori <span
                                class="color-danger">*</span></label>
                        <select id="category" name="category" class="text-input">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                        <span id="category-error" class="input-label-error d-none"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
