@extends('customer.layout')

@section('content')
    <div class="w-100 d-flex justify-content-between align-items-center mb-1">
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
            {{--            <p style="font-size: 0.8em; font-weight: bold; color: var(--dark);">Daftar Belanja</p>--}}
            @foreach($carts as $cart)
                <div class="cart-item-container mb-3">
                    <img src="{{ $cart->product->gambar }}" alt="product-image">
                    <div class="flex-grow-1">
                        <p style="color: var(--dark); font-size: 1em; margin-bottom: 0; font-weight: bold">{{ $cart->product->nama }}</p>
                        <p style="margin-bottom: 0; color: var(--dark-tint); font-size: 0.8em;">{{ $cart->product->category->nama }}</p>
                        <div class="d-flex align-items-center" style="font-size: 0.8em;">
                            <span style="color: var(--dark-tint);" class="me-1">Jumlah: </span>
                            <span style="color: var(--dark); font-weight: bold;">{{ $cart->qty }} PCS</span>
                        </div>
                        <div class="d-flex justify-content-start w-100">
                            <a href="#" class="btn-delete-item">
                                <i class='bx bx-trash'></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end" style="width: 150px;">
                        <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Rp{{ number_format($cart->harga, 0, ',' ,'.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-action-container">
            <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Ringkasan Belanja</p>
            <hr class="custom-divider"/>
            <div class="w-100 mb-1">
                <label for="shipment" class="form-label input-label">Tujuan</label>
                <select id="shipment" name="shipment" class="text-input">
                    @foreach($shipments as $shipment)
                        <option value="{{ $shipment->id }}" data-price="{{ $shipment->harga }}">{{ $shipment->kota }}
                            (Rp{{ number_format($shipment->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-100 mb-1">
                <label for="address" class="form-label input-label">Alamat</label>
                <textarea rows="3" placeholder="contoh: Wonosaren rt 04 rw 08, jagalan, jebres" class="text-input"
                          id="address"
                          name="address"></textarea>
            </div>
            <hr class="custom-divider"/>
            <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                <span style="color: var(--dark-tint); font-size: 0.8em">Subtotal</span>
                <span id="lbl-sub-total"
                      style="color: var(--dark); font-weight: 600;">Rp{{ number_format(30000000, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3" style="font-size: 1em;">
                <span style="color: var(--dark-tint); font-size: 0.8em">Biaya Pengiriman</span>
                <span id="lbl-shipment"
                      style="color: var(--dark); font-weight: 600;">Rp{{ number_format(7500, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                <span style="color: var(--dark-tint); font-size: 0.8em">Total</span>
                <span id="lbl-total"
                      style="color: var(--dark); font-weight: bold;">Rp{{ number_format(30007500, 0, ',', '.') }}</span>
            </div>
            <hr class="custom-divider"/>
            <a href="#" class="btn-action-primary mb-1">Beli</a>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var strSubTotal = '{{ 30000000 }}';
        var strShipment = '{{ 7500 }}';

        function generateTotal() {
            let intSubtotal = parseInt(strSubTotal);
            let intShipment = parseInt(strShipment);
            let total = intSubtotal + intShipment;
            $('#lbl-total').html('Rp.' + total.toLocaleString('id-ID'));
        }

        function eventChangeShipment() {
            $('#shipment').on('change', function (e) {
                strShipment = $(this).find('option:selected').attr('data-price');
                $('#lbl-shipment').html('Rp.' + parseInt(strShipment).toLocaleString('id-ID'));
                generateTotal();
            })
        }

        $(document).ready(function () {
            generateTotal();
            eventChangeShipment();
        })
    </script>
@endsection
