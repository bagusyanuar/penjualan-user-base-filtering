@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Pesanan Baru</p>
            <p class="content-sub-title">Manajemen data pesanan baru</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.order') }}">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->no_penjualan }}</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title" style="font-size: 0.8em">Data Pesanan</p>
        </div>
        <hr class="custom-divider"/>
        <div class="row w-100">
            <div class="col-8">
                <div class="w-100 d-flex align-items-center mb-1" style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">No. Pesanan :</p>
                    <p style="margin-bottom: 0">{{ $data->no_penjualan }}</p>
                </div>
                <div class="w-100 d-flex align-items-center" style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0" class="me-2">Tanggal Pesanan :</p>
                    <p style="margin-bottom: 0">{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</p>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTableNewOrder() {
            table = $('#table-data-new-order').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 1
                    }
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
                        data: 'is_kirim',
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            if (data) {
                                return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                    '<div class="d-flex justify-content-center align-items-center"' +
                                    ' style="color: white; height: 22px; width: 22px; background-color: var(--success); border-radius: 4px;" data-id="' + id + '">' +
                                    '<i class="bx bx-check"></i>' +
                                    '</div>' +
                                    '</div>';
                            }
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<div class="d-flex justify-content-center align-items-center"' +
                                ' style="color: white; height: 22px; width: 22px; background-color: var(--danger); border-radius: 4px;" data-id="' + id + '">' +
                                '<i class="bx bx-x"></i>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let urlDetail = path + '/' + id;
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }


        $(document).ready(function () {
            // generateTableNewOrder();
        })
    </script>
@endsection
