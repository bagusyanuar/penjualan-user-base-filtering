@extends('customer.layout')

@section('content')
    <div class="d-flex">
        <div class="categories-sidebar">
            <a href="#" class="categories-link active" data-tag="all" id="cat-link-all">Semua</a>
            @foreach($categories as $category)
                <a href="#" class="categories-link" data-tag="{{ $category->id }}"
                   id="cat-link-{{ $category->id }}">{{ $category->nama }}</a>
            @endforeach
        </div>
        <div class="flex-grow-1"></div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var selectedCategory = 'all';
        function eventChangeCategory() {
            $('.categories-link').on('click', function (e) {
                e.preventDefault();
                let tag = this.dataset.tag;
                selectedCategory = tag;
                $('.categories-link').removeClass('active');
                $('#cat-link-'+tag).addClass('active');
            })
        }

        $(document).ready(function () {
            eventChangeCategory();
        });
    </script>
@endsection
