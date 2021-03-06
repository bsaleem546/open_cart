@extends('layouts.app')

@section('title', 'Edit Coupon')

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
                            'route' => ['coupons.update', $data->id],
                            'class' => '',
                            'id' => 'edited'
                        ]) }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Type</label>
                                <div class="col-sm-10">
                                    <select name="type" id="type" class="form-control form-control-lg" required>
                                        <option value="All" selected>All</option>
                                        <option value="Category">Category</option>
                                        <option value="Brand">Brand</option>
                                        <option value="Product">Product</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Type Name</label>
                                <div class="col-sm-10" style="display: none" id="category_id">
                                    {{ Form::select('category_id', \App\Models\Category::pluck('name','id'), null, [ 'id' => 'category_id1',
                                        'class' => 'form-control form-control-lg', 'placeholder'=>'Select Please']) }}
                                </div>
                                <div class="col-sm-10" style="display: none" id="brand_id">
                                    {{ Form::select('brand_id', \App\Models\Brand::pluck('name','id'), null, [ 'id' => 'brand_id1',
                                        'class' => 'form-control form-control-lg', 'placeholder'=>'Select Please']) }}
                                </div>
                                <div class="col-sm-10" style="display: none" id="product_id">
                                    {{ Form::select('product_id', \App\Models\Product::pluck('name','id'), null, [ 'id' => 'product_id1',
                                        'class' => 'form-control form-control-lg', 'placeholder'=>'Select Please']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Over All</label>
                                <div class="col-sm-10">
                                    <select name="over_all" class="form-control form-control-lg" required id="over_all">
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" name="code" oninput="this.value = this.value.toUpperCase()" required
                                          value="{{ $data->code }}" class="form-control form-control-lg" placeholder="Code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Value</label>
                                <div class="col-sm-10">
                                    <input type="text" name="value" title="only decimals"
                                           value="{{ $data->value }}" class="form-control form-control-lg" placeholder="Value">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Value Type</label>
                                <div class="col-sm-10">
                                    <select name="value_type" class="form-control form-control-lg" id="value_type">
                                        <option value="Percentage" selected>Percentage</option>
                                        <option value="Price">Price</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="number" name="quantity" value="{{ $data->quantity }}"
                                           placeholder="Quantity" class="form-control form-control-lg">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg"> Begin Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="begin_date" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                          value="{{ $data->begin_date }}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-lg">End Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="end_date" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                           value="{{ $data->end_date }}" class="form-control form-control-lg">
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

        $( document ).ready(function() {

            function on_load(){
                var on_type = '{{ $data->type }}'
                $('#type').val( on_type ).prop('selected', true);

                $('#over_all').val( '{{ $data->over_all }}' ).prop('selected', true);

                $('#value_type').val( '{{ $data->value_type }}' ).prop('selected', true);

                if ( on_type == 'Category' ){
                    $('#category_id').show()
                    $('#category_id1').val( '{{ $data->type_id }}' ).prop('selected', true);

                    $('#brand_id').hide()
                    $('#product_id').hide()
                }
                else if( on_type == 'Brand' ){
                    $('#brand_id').show()
                    $('#brand_id1').val( '{{ $data->type_id }}' ).prop('selected', true);

                    $('#category_id').hide()
                    $('#product_id').hide()
                }
                else if( on_type == 'Product' ){
                    $('#product_id').show()
                    $('#product_id1').val( '{{ $data->type_id }}' ).prop('selected', true);

                    $('#brand_id').hide()
                    $('#category_id').hide()
                }
                else{
                    $('#product_id').hide()
                    $('#brand_id').hide()
                    $('#category_id').hide()
                }

            }

            setTimeout( () => { on_load() }, 1000)

            $('#type').change( () => {
                var type = $('#type').val();

                if ( type == 'Category' ){
                    $('#category_id').show()

                    $('#brand_id').hide()
                    $('#product_id').hide()
                }
                else if( type == 'Brand' ){
                    $('#brand_id').show()

                    $('#category_id').hide()
                    $('#product_id').hide()
                }
                else if( type == 'Product' ){
                    $('#product_id').show()

                    $('#brand_id').hide()
                    $('#category_id').hide()
                }
                else{
                    $('#product_id').hide()
                    $('#brand_id').hide()
                    $('#category_id').hide()
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

        })





    </script>
@endsection
