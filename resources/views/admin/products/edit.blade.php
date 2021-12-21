@extends('layouts.app')

@section('title', 'Edit Products')

@section('styles')

    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/toastr/css/toastr.min.css">

@endsection

@section('content')
    <div id="app">
        <edit-product :product="{{ $product }}" :Cbrands="{{ $brands }}" :Ccategories="{{ $categories }}"
                      :images="{{ $images ?? 'null' }}" :att="{{ $att ?? 'null' }}" :options="{{ $options ?? 'null' }}"
                        :variations="{{ $variations ?? 'null' }}" :variation_values="{{ $variation_values ?? 'null' }}"></edit-product>
    </div>

@endsection

@section('scripts')
    <!-- Toastr -->
    <script src="{{ url('public/assets') }}/vendor/toastr/js/toastr.min.js"></script>
    <script src="{{ url('public') }}/js/my-js.js"></script>
    <script src="{{ url('public') }}/js/app.js"></script>
@endsection
