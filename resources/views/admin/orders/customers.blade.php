@extends('layouts.app')

@section('title', 'Customers')

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
                    <h4 class="card-title">All Customers</h4>
                    <div class="card-toolbar">
                        {{--                        <a href="{{ route('options.create') }}" class="btn btn-outline-primary">Add New</a>--}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Phone</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $customers)
                                <tr>
                                    <td>{{ $customers->email }}</td>
                                    <td>{{ $customers->fname }}</td>
                                    <td>{{ $customers->lname }}</td>
                                    <td>{{ $customers->address }}</td>
                                    <td>{{ $customers->city }}</td>
                                    <td>{{ $customers->country }}</td>
                                    <td>{{ $customers->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customers->created_at)->format('d-m-Y')  }}</td>
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
