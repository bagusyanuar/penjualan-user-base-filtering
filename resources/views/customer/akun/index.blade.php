@extends('customer.layout')

@section('content')
    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
        <p class="page-title">Akun Saya</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Akun Saya</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex">
        <div class="categories-sidebar">
            <a href="{{ route('customer.account') }}" class="categories-link active">Akun Saya</a>
            <a href="#" class="categories-link">Pesanan</a>
        </div>
        <div class="flex-grow-1" style="padding-left: 25px">
            <div class="w-100 mb-2">
                <label for="email" class="form-label input-label">Email</label>
                <div class="text-group-container">
                    <i class='bx bx-envelope'></i>
                    <input type="email" placeholder="email" class="text-group-input" id="email"
                           name="email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="w-100 mb-3">
                <label for="username" class="form-label input-label">Username</label>
                <div class="text-group-container">
                    <i class='bx bx-user'></i>
                    <input type="text" placeholder="username" class="text-group-input" id="username"
                           name="username" value="{{ $user->username }}">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
