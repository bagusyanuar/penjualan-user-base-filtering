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
                <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
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
            <div class="card-content">
                <table id="table-data" class="display table w-100">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="10%" class="text-center">Tanggal</th>
                        <th>No. Penjualan</th>
                        <th width="10%" class="text-end">Sub Total</th>
                        <th width="10%" class="text-end">Ongkir</th>
                        <th width="10%" class="text-end">Total</th>
                        <th width="13%" class="text-center">Status</th>
                        <th width="8%" class="text-center"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTable() {
            table = $('#table-data').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'tanggal',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'no_penjualan',
                        className: 'middle-header',
                    },
                    {
                        data: 'sub_total',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },

                    {
                        data: 'ongkir',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'total',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'status',
                        orderable: false,
                        className: 'middle-header text-center',
                        render: function (data) {
                            return '<div class="chip-status-danger">menunggu pembayaran</div>'
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let isDelivery = data['is_kirim'];
                            let urlDetail = path + '/' + id;
                            if (isDelivery === 1) {
                                return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                    '<div class="delivery-status-container"><i class="bx bx-car"></i></div>' +
                                    '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action-delete" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                    '</div>';
                            }
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action-delete" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }

        $(document).ready(function () {
            generateTable();
        })
    </script>
@endsection
