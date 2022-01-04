@extends('layouts.app')

@section('title', 'Add Popup')

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
                            'route' => 'popups.store',
                            'class' => '',
                            'id' => 'created',
                            'enctype' => "multipart/form-data"
                        ]) }}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Image</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="img" required accept="image/*">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Title</label>
                            <div class="col-sm-10">
                                <input name="title" type="text"
                                       class="form-control form-control-lg" placeholder="Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Sub Title</label>
                            <div class="col-sm-10">
                                <input name="sub_title" type="text"
                                       class="form-control form-control-lg" placeholder="Sub Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Optional Sub Title</label>
                            <div class="col-sm-10">
                                <input name="optional_sub_title" type="text"
                                       class="form-control form-control-lg" placeholder="Optional Sub Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Button Text</label>
                            <div class="col-sm-10">
                                <input name="btn_text" type="text"
                                       class="form-control form-control-lg" placeholder="Button Text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Button Link</label>
                            <div class="col-sm-10">
                                <input name="btn_link" type="text"
                                       class="form-control form-control" placeholder="Button Link">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="" class="form-control form-control">
                                    <option value="1" selected>On</option>
                                    <option value="0">Off</option>
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
