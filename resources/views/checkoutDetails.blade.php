@extends('layouts.web')

@section('title', 'Checkout Details')

@section('styles')
@endsection

@section('content')

    <main id="mt-main">
        <section class="mt-contact-banner mt-banner-22" style="background-image: url( {{ url('public/web/images/img-76.jpg') }} );">
            <h1 class="text-center">CHECK OUT DETAILS</h1>
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
                            <li class="active">
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
                    <div class="col-xs-12 col-sm-6">
                        <div class="holder">
                            <h2>BILLING DETAILS</h2>
                            <ul class="list-unstyled block">
                                @if($customer !== null)
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>First Name</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['fname'] }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>Last Name</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['lname'] }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>Address</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['address'] }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>City</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['city'] }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>Email</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['email'] }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>Phone</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['phone'] }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-wrap pull-left">
                                            <strong>Note</strong>
                                        </div>
                                        <div class="text-wrap txt text-right pull-right">
                                            <strong>{{ $customer['notes'] }}</strong>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
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
                                                <span>{{ $value['name'] }}       x{{ $value['quantity'] }}</span>
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
                                @if($checkoutSession !== null)
                                    <li>
                                        <div class="txt-holder">
                                            <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                                            <div class="txt pull-right">
                                                <span>{{ $checkoutSession['total'] }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="txt-holder">
                                            <strong class="title sub-title pull-left">DISCOUNT</strong>
                                            <div class="txt pull-right">
                                                <span>{{ $checkoutSession['discount'] }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="txt-holder">
                                            <strong class="title sub-title pull-left">DISCOUNT CODE</strong>
                                            <div class="txt pull-right">
                                                <span>{{ $checkoutSession['discountCode'] }}</span>
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
                                                <span>{{ $checkoutSession['finalTotal'] }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div class="txt-holder">
                                            <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                                            <div class="txt pull-right">
                                                <span>{{$total }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="txt-holder">
                                            <strong class="title sub-title pull-left">DISCOUNT</strong>
                                            <div class="txt pull-right">
                                                <span>{{ $discount }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="txt-holder">
                                            <strong class="title sub-title pull-left">DISCOUNT CODE</strong>
                                            <div class="txt pull-right">
                                                <span>NON</span>
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
                                                <span>{{ ($total - $discount) + $ship }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
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
                        <form action="{{ url('confirm-order') }}" method="POST">
                            @csrf
                            <div class="block-holder">
                                    <input type="checkbox" required> I’ve read &amp; accept the <a href="#">terms &amp; conditions</a>
                            </div>
                            <input type="submit" value="CONFIRM ORDER" class="process-btn" style="border: none">
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
@endsection
