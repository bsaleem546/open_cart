@extends('layouts.app')

@section('title', 'Orders')

@section('styles')
    <link href="{{  url('public/assets') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/toastr/css/toastr.min.css">

    <style>
        tbody tr{
            color: black !important;
        }
    </style>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Orders</h4>
                    <div class="card-toolbar">
{{--                        <a href="{{ route('options.create') }}" class="btn btn-outline-primary">Add New</a>--}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Discount Code</th>
                                <th>Shipping</th>
                                <th>Total</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $orders)
                                <tr>
                                    <td>{{ $orders->id }}</td>
                                    <td>{{ $orders->sub_total }}</td>
                                    <td>{{ $orders->discount }}</td>
                                    <td>{{ $orders->discount_code }}</td>
                                    <td>{{ $orders->shipping }}</td>
                                    <td>{{ $orders->total }}</td>
                                    <td>{{ $orders->note }}</td>
                                    <td>{{ $orders->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($orders->created_at)->format('d-m-Y')  }}</td>
                                    <td>
                                        <a href="{{ route('orders.details', [$orders->id]) }}" class="btn btn-outline-primary">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Datatable -->
    <script src="{{ url('public/assets') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('public/assets') }}/js/plugins-init/datatables.init.js"></script>
    <script src="{{ url('public/assets') }}/vendor/toastr/js/toastr.min.js"></script>
    <script src="{{ url('public') }}/js/my-js.js"></script>

    <script>

    </script>
@endsection
