@extends('layouts.web')

@section('title', 'Checkout')

@section('styles')
@endsection

@section('content')

    <main id="mt-main">
        <section class="mt-contact-banner mt-banner-22" style="background-image: url( {{ url('public/web/images/img-76.jpg') }} );">
            <h1 class="text-center">CHECK OUT</h1>
        </section>

        <div class="mt-process-sec">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Process List of the Page -->
                        <ul class="list-unstyled process-list">
                            <li class="active">
                                <span class="counter">01</span>
                                <strong class="title">Shopping Cart</strong>
                            </li>
                            <li class="active">
                                <span class="counter">02</span>
                                <strong class="title">Check Out</strong>
                            </li>
                            <li>
                                <span class="counter">03</span>
                                <strong class="title">Order Details</strong>
                            </li>
                            <li>
                                <span class="counter">04</span>
                                <strong class="title">Order Complete</strong>
                            </li>
                        </ul>
                        <!-- Process List of the Page end -->
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-detail-sec toppadding-zero">
            <div class="container">
                <div class="row">
                    <form action="{{ url('addCustomerDetails') }}" method="POST" class="bill-detail">
                        @csrf
                        <div class="col-xs-12 col-sm-6">
                            <h2>BILLING DETAILS</h2>
                            @if($errors->any())
                                <h4 style="color: red; margin-bottom: 10px">{{$errors->first()}}</h4>
                            @endif
                            <small style="color: red; margin-bottom: 10px">(*) represents all required fields</small>
                            <!-- Bill Detail of the Page -->
                            @if(Auth::check())
                                <fieldset>
                                    <div class="form-group">
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                   placeholder="Name *" name="fname" required value="{{ $customer != null ? $customer['fname'] : '' }}">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                   placeholder="Last Name *" name="lname" required value="{{ $customer != null ? $customer['lname'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control"
                                                  placeholder="Address *" name="address" required>{{ $customer != null ? $customer['address'] : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                               placeholder="Town / City *" name="city" required value="{{ $customer != null ? $customer['city'] : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                               placeholder="State / Country *" name="country" required value="{{ $customer != null ? $customer['country'] : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email Address *" name="email" required value="{{ Auth::user()->email }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control"
                                               placeholder="Phone Number *" name="phone" required value="{{ $customer != null ? $customer['phone'] : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Order Notes" name="notes">{{ $customer != null ? $customer['notes'] : '' }}</textarea>
                                    </div>
                                </fieldset>
                            @else
                                <fieldset>
                                    <div class="form-group">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Name *" name="fname" required>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Last Name *" name="lname" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Address *" name="address" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Town / City *" name="city" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="State / Country *" name="country" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email Address *" name="email" required>
                                    </div>
                                    <div class="form-group" style="display: none" id="pass_txt">
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" id="sign_up_shk" name="sign_up_shk"> Want to sign up?
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" placeholder="Phone Number *" name="phone" required>
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Order Notes" name="notes"></textarea>
                                    </div>
                                </fieldset>
                            @endif
                            <!-- Bill Detail of the Page end -->
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="holder">
                                <h2>YOUR ORDER</h2>

                                <ul class="list-unstyled block">
                                        @php $total = 0; $cartTotal = 0; $discount = 0; $ship = 0; @endphp
                                        <li>
                                            <div class="txt-holder">
                                                <div class="text-wrap pull-left">
                                                    <strong class="title">PRODUCTS</strong>
                                                    @foreach($cart  as $key => $value)
                                                        @php $total += $value['price']  @endphp
                                                        <span>{{ Auth::check() ? $value['product_name'] : $value['name'] }}       x{{ $value['quantity'] }}</span>
                                                    @endforeach
                                                </div>
                                                <div class="text-wrap txt text-right pull-right">
                                                    <strong class="title">TOTALS</strong>
                                                    @foreach($cart  as $key => $value)
                                                        <span>{{ $value['price'] }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="txt-holder">
                                                <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                                                <div class="txt pull-right">
                                                    <span>{{ $checkoutSession == null ? $total : $checkoutSession['total'] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="txt-holder">
                                                <strong class="title sub-title pull-left">DISCOUNT</strong>
                                                <div class="txt pull-right">
                                                    <span>{{ $checkoutSession == null ? $discount : $checkoutSession['discount'] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="txt-holder">
                                                <strong class="title sub-title pull-left">DISCOUNT CODE</strong>
                                                <div class="txt pull-right">
                                                    <span>{{ $checkoutSession == null ? 'NON' : $checkoutSession['discountCode'] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="txt-holder">
                                                <strong class="title sub-title pull-left">SHIPPING</strong>
                                                <div class="txt pull-right">
                                                    <span>Free Shipping</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li style="border-bottom: none;">
                                            <div class="txt-holder">
                                                <strong class="title sub-title pull-left">ORDER TOTAL</strong>
                                                <div class="txt pull-right">
                                                    <span>{{ $checkoutSession == null ? ($total - $discount) + $ship : $checkoutSession['finalTotal'] }}</span>
                                                </div>
                                            </div>
                                        </li>
                                </ul>

                                <h2>PAYMENT METHODS</h2>
                                <!-- Panel Group of the Page -->
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <!-- Panel Panel Default of the Page -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    50% UP FRONT PAYMENT
                                                    <span class="check"><i class="fa fa-check"></i></span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <p>Make your payment directly into our bank account. Please use your order id as the payment reference. Your order wont be shippided until the funds have cleared in our account</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Panel Panel Default of the Page end -->
                                </div>
                                <!-- Panel Group of the Page end -->
                            </div>
                            <input type="submit" value="PROCEED TO CHECKOUT" class="process-btn" style="border: none">
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <aside class="f-promo-box">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
                    <!-- F Widget Item of the Page -->
                    <div class="f-widget-item">
                        <span class="widget-icon"><i class="fa fa-plane"></i></span>
                        <div class="txt-holder">
                            <h2 class="f-promo-box-heading">FREE SHIPPING</h2>
                            <p>Free shipping on all PAKISTAN order</p>
                        </div>
                    </div>
                    <!-- F Widget Item of the Page end -->
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
                    <!-- F Widget Item of the Page -->
                    <div class="f-widget-item border">
                        <span class="widget-icon"><i class="fa fa-life-ring"></i></span>
                        <div class="txt-holder">
                            <h2 class="f-promo-box-heading">SUPPORT 24/7</h2>
                            <p>We support 24 hours a day</p>
                        </div>
                    </div>
                    <!-- F Widget Item of the Page end -->
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomxs">
                    <!-- F Widget Item of the Page -->
                    <div class="f-widget-item border">
                        <span class="widget-icon"><i class="fa fa-dropbox"></i></span>
                        <div class="txt-holder">
                            <h2 class="f-promo-box-heading">GIFT CARDS</h2>
                            <p>Give perfect gift</p>
                        </div>
                    </div>
                    <!-- F Widget Item of the Page end -->
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <!-- F Widget Item of the Page -->
                    <div class="f-widget-item border">
                        <span class="widget-icon"><i class="fa fa-money"></i></span>
                        <div class="txt-holder">
                            <h2 class="f-promo-box-heading">PAYMENT 100% SECURE</h2>
                            <p>Payment 100% secure</p>
                        </div>
                    </div>
                    <!-- F Widget Item of the Page end -->
                </div>
            </div>
        </div>
    </aside>

@endsection

@section('scripts')
    <script src="{{ url('public/js/my-js.js') }}"></script>
    <script>
        $('#sign_up_shk').change( () => {
            var chk = document.getElementById('sign_up_shk').checked
            if(chk == true){
                $('#pass_txt').show()
            }
            else{
                $('#pass_txt').hide()
            }
        })
    </script>
@endsection
