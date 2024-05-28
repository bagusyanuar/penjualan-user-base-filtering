@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Kategori</p>
            <p class="content-sub-title">Manajemen data kategori</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <form method="post" id="form-data">
            @csrf
            <div class="w-100 mb-3">
                <label for="name" class="form-label input-label">Nama Kategori <span
                        class="color-danger">*</span></label>
                <input type="text" placeholder="nama kategori" class="text-input" id="name"
                       name="name">
                <span id="name-error" class="input-label-error d-none"></span>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
