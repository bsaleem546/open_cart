@extends('layouts.app')

@section('title', 'Edit Slide')

@section('styles')

    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/toastr/css/toastr.min.css">

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update slide</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {{ Form::open([
                            'method' => 'PATCH',
                            'route' => ['sliders.update', $data->id],
                            'class' => '',
                            'id' => 'edited',
                            'enctype' => "multipart/form-data"
                        ]) }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Image</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="img" accept="image/*">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Text 1</label>
                                <div class="col-sm-10">
                                    <input name="text1" type="text" value="{{ $data->text1 }}"
                                           class="form-control form-control-lg" placeholder="Text 1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Text 2</label>
                                <div class="col-sm-10">
                                    <input name="text2" type="text" value="{{ $data->text2 }}"
                                           class="form-control form-control-lg" placeholder="Text 2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Text 3</label>
                                <div class="col-sm-10">
                                    <input name="text3" type="text" value="{{ $data->text3 }}"
                                           class="form-control form-control-lg" placeholder="Text 3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Text 4</label>
                                <div class="col-sm-10">
                                    <input name="text4" type="text" value="{{ $data->text4 }}"
                                           class="form-control form-control-lg" placeholder="Text 4">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Button Text</label>
                                <div class="col-sm-10">
                                    <input name="btn_text" type="text" value="{{ $data->btn_text }}"
                                           class="form-control form-control-lg" placeholder="Button Text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Button Link</label>
                                <div class="col-sm-10">
                                    <input name="btn_link" type="text"  value="{{ $data->btn_link }}"
                                           class="form-control form-control-lg" placeholder="Button Link">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg"></label>
                                <div class="col-sm-10">
                                    <input type="submit" value="Update" class="btn btn-primary">
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

        $(document).on('submit', '#edited', (event) => {

            event.preventDefault();
            var form = $('#edited');
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
