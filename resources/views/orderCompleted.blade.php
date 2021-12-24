@extends('layouts.web')

@section('title', 'Order Completed')

@section('styles')

@endsection

@section('content')
    <main id="mt-main">
        <section class="mt-contact-banner mt-banner-22" style="background-image: url( {{ url('public/web/images/img-76.jpg') }} );">
            <h1 class="text-center">ORDER COMPLETED</h1>
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
                            <li class="active">
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
                    <div class="col-xs-12 col-sm-8 col-sm-push-2">
                        <div class="holder" style="margin: 0px;">
                            <h2>Thank you!</h2>
                            <h1>Your order number is <span style="color: black">{{ $orderID }}</span> </h1>
                            <h4>You can track your order status with your order number.</h4>
                            <p>We will contact you with a time for Collection, once collected we will update you on the status of the repair,
                                than we will contact you for the drop off time.</p>
                            <p>We aim to get your device back to you on the Same Day, but in some cases due to the repair this may be delayed,
                                our techs will inform you once they have received the device.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
@endsection
