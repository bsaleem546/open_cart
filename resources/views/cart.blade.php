@extends('layouts.web')

@section('title', 'Cart')

@section('styles')
    <style>
        .qty{
            font-size: 18px;
            line-height: 20px;
            font-weight: 700;
            padding: 7px 10px;
            border: none;
            outline: none;
            background: #eeeeee;
            color: #494949;
            width: 60px;
        }
    </style>
@endsection

@section('content')

    <main id="mt-main">
        <section class="mt-contact-banner mt-banner-22" style="background-image: url( {{ url('public/web/images/img-76.jpg') }} );">
            <h1 class="text-center">SHOPPING CART</h1>
        </section>
        <!-- Mt Process Section of the Page -->
        <div class="mt-process-sec">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="list-unstyled process-list">
                            <li class="active">
                                <span class="counter">01</span>
                                <strong class="title">Shopping Cart</strong>
                            </li>
                            <li>
                                <span class="counter">02</span>
                                <strong class="title">Check Out</strong>
                            </li>
                            <li>
                                <span class="counter">03</span>
                                <strong class="title">Order Complete</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- Mt Process Section of the Page end -->

        @if( \Illuminate\Support\Facades\Session::get('cart') == null )
            <div class="text-center">
                <h1>Cart Empty</h1>
            </div>
        @else

            <div class="mt-product-table">
                <div class="container">
                    <div class="row border">
                        <div class="col-xs-12 col-sm-6">
                            <strong class="title">PRODUCT</strong>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <strong class="title">PRICE</strong>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <strong class="title">QUANTITY</strong>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <strong class="title">TOTAL</strong>
                        </div>
                    </div>
                    @php $total = 0  @endphp
                    @foreach(\Illuminate\Support\Facades\Session::get('cart') as $key => $value)
                        <div class="row border" id="{{ $value['id'] }}">
                            @php $total += $value['price']  @endphp
                            <div class="col-xs-12 col-sm-2">
                                @php $path = \App\Models\Image_Product::where('product_id', $value['id'])->pluck('paths')->first()  @endphp
                                <div class="img-holder">
                                    @if($path == null || $path == '')
                                        <img src="{{ url('public/imgs/empty.jpg') }}"
                                             alt="image" class="img-responsive">
                                    @else
                                        <img src="{{ url('public/uploads/'.$path) }}"
                                             alt="image" class="img-responsive">
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <strong class="product-name">{{ $value['name'] }}</strong>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <strong class="price"><i class="fa fa-dollar"></i> {{ $value['p'] }}</strong>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <form action="#" class="qyt-form">
                                    <fieldset>
                                        <input type="number" name="qty" id="" value="{{ $value['quantity'] }}" class="qty">
                                    </fieldset>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <strong class="price"><i class="fa fa-dollar"></i> {{ $value['price'] }}</strong>
                                <a href="#" onclick="removeItem({{ $value['id'] }})"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="coupon-form" id="coupon-form">
                                <fieldset>
                                    <div class="mt-holder">
                                        <input type="text" class="form-control" oninput="this.value = this.value.toUpperCase()"
                                              id="coupon_code" placeholder="Your Coupon Code" required>
                                        <button type="submit">APPLY</button>
                                    </div>
                                </fieldset>
                                <div class="my-alert-success text-center" style="display: none">
                                    <h3 id="coupon-success"></h3>
                                </div>
                                <div class="my-alert-error text-center" style="display: none">
                                    <h3 id="coupon-error"></h3>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <section class="mt-detail-sec style1">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h2>CALCULATE SHIPPING</h2>
                            <form action="#" class="bill-detail">
                                <fieldset>
                                    <div class="form-group">
                                        <select class="form-control" disabled>
                                            <option value="Pakistan">Pakistan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="">Select City</option>
                                            @foreach($shipping as $s)
                                                <option value="{{ $s->id }}">{{ $s->city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="update-btn" type="submit">UPDATE TOTAL <i class="fa fa-refresh"></i></button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h2>CART TOTAL</h2>
                            <ul class="list-unstyled block cart">
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                                        <div class="txt pull-right">
                                            <span><i class="fa fa-dollar"></i> {{ $total }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">SHIPPING</strong>
                                        <div class="txt pull-right">
                                            <strong>Free Shipping</strong>
                                        </div>
                                    </div>
                                </li>
                                <li style="border-bottom: none;">
                                    <div class="txt-holder">
                                        <strong class="title sub-title pull-left">CART TOTAL</strong>
                                        <div class="txt pull-right">
                                            <span><i class="fa fa-eur"></i> 1299,00</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <a href="#" class="process-btn">PROCEED TO CHECKOUT <i class="fa fa-check"></i></a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>

@endsection


@section('scripts')
    <script src="{{ url('public/js/my-js.js') }}"></script>
    <script>
        function removeItem(id) {
            alert(id)
        }

        $(document).on('submit', '#coupon-form', (event) => {
            event.preventDefault();
            var coupon = $('#coupon_code').val()
            $.ajax({
                type: 'GET',
                url: main_url+'checkCoupon/'+coupon,
            }).done( (data) => {
                if (data.status == 0){
                    $('#coupon-error').html(data.msg)
                    $('.my-alert-error').show()
                    $('.my-alert-error').fadeOut(5000)
                    return;
                }
                console.log(data.msg)
            })
        })
    </script>
@endsection
