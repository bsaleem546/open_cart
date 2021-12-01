@extends('layouts.app')

@section('title', 'Products')


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
                    <h4 class="card-title">All Products</h4>
                    <div class="card-toolbar">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-primary">Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>In Stock</th>
                                <th>Start date</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $products)
                                <tr>
                                    <td>{{ $products->brand }}</td>
                                    <td>{{ $products->category }}</td>
                                    <td>{{ $products->name }}</td>
                                    <td>{{ $products->quantity }}</td>
                                    <td>{{ $products->price }}</td>
                                    <td>{{ $products->in_stock }}</td>
                                    <td>{{ $products->created_at }}</td>
                                    <td><a href="{{ route('products.edit', $products->id) }}"><i class="fas fa-cog"></i></a>
                                        |
                                        <a href="#" onclick="_delete( {{ json_encode($products) }} )"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5><span id="username"></span> once deleted cannot be restored.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="delete">Delete</button>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function _delete(data) {
            $('#username').html(data.name)
            $('#delete_modal').modal('show')
            document.getElementById('delete').addEventListener('click', (e) => {
                $.ajax({
                    type: 'DELETE',
                    url: main_url+'admin/products/'+data.id,
                    contentType: false,
                    processData: false,
                    // headers:$('meta[name="csrf-token"]').attr('content'),
                }).done(function(response){
                    $('#delete_modal').modal('hide')
                    if(response.status == true){
                        toast_success(response.message)
                        setTimeout(function(){ window.location = response.redirect; }, 3000);
                    }else{
                        $('#delete_modal').modal('hide')
                        toast_error(response.message)
                        console.log(response.details)
                    }
                });
            })
        }
    </script>

@endsection
