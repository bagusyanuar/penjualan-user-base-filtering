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
                        @elseif($data->status === 1)
                            <div class="chip-status-warning">menunggu konfirmasi pembayaran</div>
                        @elseif($data->status === 2)
                            <div class="chip-status-danger">pembayaran di tolak</div>
                        @elseif($data->status === 3)
                            <div class="chip-status-info">barang di packing</div>
                        @elseif($data->status === 4)
                            <div class="chip-status-info">barang siap di ambil</div>
                        @elseif($data->status === 5)
                            <div class="chip-status-info">barang di kirim</div>
                        @elseif($data->status === 6)
                            <div class="chip-status-success">selesai</div>
                        @endif
                    </span>
                </div>
                @if($data->status === 2)
                    <div class="d-flex align-items-center mb-1">
                        <span style="" class="me-2">Alasan Penolakan :</span>
                        <span style="font-weight: 600;">
                             {{ $data->pembayaran_status->deskripsi }}
                        </span>
                    </div>
                @endif
            </div>
            <hr class="custom-divider"/>
            <div class="d-flex w-100 gap-3">
                <div class="flex-grow-1 d-flex gap-2" style="flex-direction: column;">
                    @foreach($data->keranjang as $cart)
                        <div class="cart-item-container" style="height: fit-content;">
                            <img src="{{ $cart->product->gambar }}" alt="product-image">
                            <div class="flex-grow-1">
                                <p style="color: var(--dark); font-size: 1em; margin-bottom: 0; font-weight: bold">{{ $cart->product->nama }}</p>
                                <p style="margin-bottom: 0; color: var(--dark-tint); font-size: 0.8em;">{{ $cart->product->category->nama }}</p>
                                <div class="d-flex align-items-center" style="font-size: 0.8em;">
                                    <span style="color: var(--dark-tint);" class="me-1">Jumlah: </span>
                                    <span style="color: var(--dark); font-weight: bold;">{{ $cart->qty }}X (Rp.{{ number_format($cart->harga, 0, ',' ,'.') }})</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end" style="width: 150px;">
                                <p style="font-size: 1em; font-weight: bold; color: var(--dark);">
                                    Rp{{ number_format($cart->total, 0, ',' ,'.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-content" style="width: 350px; height: fit-content;">
                    <p style="font-size: 1em; font-weight: bold; color: var(--dark);">Ringkasan Belanja</p>
                    <hr class="custom-divider"/>
                    <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                        <span style="color: var(--dark-tint); font-size: 0.8em">Subtotal</span>
                        <span id="lbl-sub-total"
                              style="color: var(--dark); font-weight: 600;">Rp{{ number_format($data->sub_total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3" style="font-size: 1em;">
                        <span style="color: var(--dark-tint); font-size: 0.8em">Biaya Pengiriman</span>
                        <span id="lbl-shipment"
                              style="color: var(--dark); font-weight: 600;">Rp{{ number_format($data->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-1" style="font-size: 1em;">
                        <span style="color: var(--dark-tint); font-size: 0.8em">Total</span>
                        <span id="lbl-total"
                              style="color: var(--dark); font-weight: bold;">Rp{{ number_format($data->total, 0, ',', '.') }}</span>
                    </div>

                    @if($data->status === 0 || $data->status === 2)
                        <hr class="custom-divider"/>
                        <a href="{{ route('customer.order.payment', ['id' => $data->id]) }}" class="btn-action-primary">Bayar</a>
                    @endif
                </div>
            </div>
            @if(count($data->rating) <= 0 && $data->status === 6)
                <hr class="custom-divider"/>
                <p style="font-size: 1em; font-weight: 600; color: var(--dark); text-align: center">
                    Rating Product
                </p>
                <div class="w-100 product-container" style="flex-direction: row;">
                    @foreach($data->keranjang as $item)
                        <div class="card-content d-flex flex-column"
                             style="width: 220px; height: 270px; padding: 5px 0;">
                            <div
                                style="width: 100%; height: 150px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                <img src="{{ $item->product->gambar }}" alt="img-product"
                                     style="height: 150px; object-fit: cover; object-position: center center;">
                            </div>
                            <div class="flex-grow-1 d-flex justify-content-between flex-column"
                                 style="padding: 0 10px;">
                                <p style="font-size: 0.8em; color: var(--dark); font-weight: 600; text-align: center; margin-bottom: 5px;">
                                    {{ $item->product->nama }}
                                </p>
                                <div class="w-100 d-flex align-items-center justify-content-center"
                                     style="padding-bottom: 10px;">
                                    <i class="bx bxs-star star-rate product-star-{{$item->id}}" data-index="1"
                                       data-product="{{ $item->product->id }}" data-cart="{{ $item->id }}"></i>
                                    <i class="bx bxs-star star-rate product-star-{{$item->id}}" data-index="2"
                                       data-product="{{ $item->product->id }}" data-cart="{{ $item->id }}"></i>
                                    <i class="bx bxs-star star-rate product-star-{{$item->id}}" data-index="3"
                                       data-product="{{ $item->product->id }}" data-cart="{{ $item->id }}"></i>
                                    <i class="bx bxs-star star-rate product-star-{{$item->id}}" data-index="4"
                                       data-product="{{ $item->product->id }}" data-cart="{{ $item->id }}"></i>
                                    <i class="bx bxs-star star-rate product-star-{{$item->id}}" data-index="5"
                                       data-product="{{ $item->product->id }}" data-cart="{{ $item->id }}"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr class="custom-divider" />
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn-action-primary" style="width: fit-content;" id="btn-rate">Beri Rating</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var _pIDS = @json($cartProductIDS);

        function eventChangeRate() {
            $('.star-rate').on('click', function () {
                let index = this.dataset.index;
                let productID = this.dataset.product;
                let cartID = this.dataset.cart;
                let filledStarClass = 'bxs-star';
                let unFilledStarClass = 'bx-star';
                //clear star
                let elStar = document.getElementsByClassName('product-star-' + cartID);
                $.each(elStar, function (k, v) {
                    let currentIdx = (k + 1);
                    let intIdx = parseInt(index);
                    v.classList.remove(filledStarClass);
                    if (currentIdx <= intIdx) {
                        v.classList.add(filledStarClass)
                    }

                    if (currentIdx > intIdx) {
                        v.classList.add(unFilledStarClass);
                    }
                });
            })
        }

        function eventRate() {
            $('#btn-rate').on('click', function (e) {
                e.preventDefault();
                let arrData = [];
                $.each(_pIDS, function (k, v) {
                    let elStar = document.getElementsByClassName('product-star-' + v);
                    let filledStarClass = 'bxs-star';
                    let countStar = 0;
                    let productID = '';
                    $.each(elStar, function (ks, vs) {
                        productID = vs.dataset.product;
                        if (vs.classList.contains(filledStarClass)) {
                            countStar = countStar + 1;
                        }
                    });
                    console.log('ps-'+v, countStar, productID);
                    let tmpData = {
                        pID: productID,
                        cID: v,
                        star: countStar
                    };
                    arrData.push(tmpData);
                });
                rateHandler(arrData);
            })
        }

        async function rateHandler(arrData = []) {
            try {
                let data = JSON.stringify(arrData);
                let response = await $.post(path, {data});
                console.log(response);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil memberikan rating product...',
                    icon: 'success',
                    timer: 700
                }).then(() => {
                    window.location.reload();
                })
            }catch (e) {
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }
        }

        $(document).ready(function () {
            eventChangeRate();
            eventRate();
        });
    </script>
@endsection
