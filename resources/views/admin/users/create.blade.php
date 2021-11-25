@extends('layouts.app')

@section('title', 'Add User')

@section('styles')

    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/toastr/css/toastr.min.css">

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {{ Form::open([
                            'route' => 'users.store',
                            'class' => '',
                            'id' => 'created'
                        ]) }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Name</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" required
                                           class="form-control form-control-lg" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Email</label>
                                <div class="col-sm-10">
                                    <input name="email" type="email" required
                                           class="form-control form-control-lg" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Password</label>
                                <div class="col-sm-10">
                                    <input name="password" type="password" required
                                           class="form-control form-control-lg" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Contact</label>
                                <div class="col-sm-10">
                                    <input name="contact" type="text" class="form-control form-control-lg" placeholder="Contact">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Address</label>
                                <div class="col-sm-10">
                                    <textarea name="address" id="" cols="30" rows="2" class="form-control form-control-lg"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Role</label>
                                <div class="col-sm-10">
                                    <select name="role" id="" class="form-control form-control-lg" required>
                                        <option value="USER" selected>User</option>
                                        <option value="ADMIN">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg"></label>
                                <div class="col-sm-10">
                                    <input type="submit" value="Create" class="btn btn-primary">
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Toastr -->
    <script src="{{ url('public/assets') }}/vendor/toastr/js/toastr.min.js"></script>
    <script src="{{ url('public') }}/js/my-js.js"></script>
    <script>

        $(document).on('submit', '#created', (event) => {

            event.preventDefault();
            var form = $('#created');
            var formData = new FormData(form[0]);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                contentType: false,
                processData: false,
                dataType: 'json',
                headers:$('meta[name="csrf-token"]').attr('content'),
                data: formData,
            }).done(function(response){
                if(response.status == true){
                    toast_success(response.message)
                    setTimeout(function(){ window.location = response.redirect; }, 3000);
                }else{
                    toast_error(response.message)
                    console.log(response.details)
                }
            });
        })


    </script>
@endsection
