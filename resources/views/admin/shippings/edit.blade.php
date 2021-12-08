@extends('layouts.app')

@section('title', 'Edit shipping')

@section('styles')

    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/toastr/css/toastr.min.css">

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {{ Form::open([
                            'method' => 'PATCH',
                            'route' => ['shippings.update', $data->id],
                            'class' => '',
                            'id' => 'edited'
                        ]) }}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">City</label>
                            <div class="col-sm-10">
                                <input name="city" type="text" required value="{{ $data->city }}"
                                       class="form-control form-control-lg" placeholder="City">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Rate</label>
                            <div class="col-sm-10">
                                <input name="rate" type="text" required value="{{ $data->rate }}"
                                       class="form-control form-control-lg" placeholder="Rate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-lg">Products</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allCheck">
                                    <label class="form-check-label">
                                        Select All
                                    </label>
                                </div>
                                @foreach($products as $p)
                                    <div class="form-check">
                                        <input class="form-check-input" id="check_{{ $p->id }}"
                                               type="checkbox" value="{{ $p->id }}" name="products[]">
                                        <label class="form-check-label">
                                            {{ $p->name }}
                                        </label>
                                    </div>
                                @endforeach
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

        var products = {!! $data->products !!}

        for (var i = 0; i < products.length; i++){
            $('#check_'+products[i].id).prop('checked', true);
        }



        $('#allCheck').change( (e) => {
            var chk = $('#allCheck').prop('checked');
            if (chk){
                $('input:checkbox').prop('checked', true);
            }
            else{
                $('input:checkbox').prop('checked', false);
            }
        })

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
