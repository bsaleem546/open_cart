@extends('layouts.web')

@section('title', 'Order Tracking')

@section('styles')

@endsection

@section('content')
    <main id="mt-main">
        <section class="mt-contact-banner mt-banner-22" style="background-image: url( {{ url('public/web/images/img-76.jpg') }} );">
            <h1 class="text-center">ORDER TRACKING</h1>
        </section>

        <section class="mt-about-sec" style="padding-bottom: 0;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="txt wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                            <h2>track your order?</h2>
                            <p>Morbi in erat malesuada, sollicitudin massa at, tristique nisl. Maecenas id eros scelerisque, vulputate tortor quis, efficitur arcu sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Umco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit sse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat <strong>Vestibulum sit amet metus euismod, condimentum lectus id, ultrices sem.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-detail-sec toppadding-zero">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-sm-push-2">
                        <div class="holder" style="margin: 0px;">
                            <h2>track ORDER</h2>
                            <!-- Bill Detail of the Page -->
                            <form action="{{ url('order-tracking') }}" method="post" class="bill-detail" style="width: 100%;" id="order-tracking">
                                @csrf
                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="ORDER ID" required name="id">
                                    </div>
                                    <input type="submit" value="track now" class="process-btn" style="border: none">
                                </fieldset>
                            </form>
                            <!-- Bill Detail of the Page end -->
                            <div id="orders" style="margin-top: 50px">
                                @if( session('orderProduct') )
                                    <div id="pd">
                                        <h4>Product details</h4>
                                        @foreach(session('orderProduct') as $op)
                                            <h6>Product Name: {{ $op->product->name }}</h6>

                                            <h6>Qty: {{ $op->quantity }}</h6>

                                            <h6>Attributes: {{ $op->attr }}</h6>

                                            <h6>Total: {{ $op->total }}</h6>

                                        @endforeach
                                        <hr>
                                    </div>
                                @endif
                                @if( session('customer') )
                                    <div id="cu">
                                        <h4>Customer Details</h4>
                                        <h6>Email: {{ session('customer')->email }}</h6>

                                        <h6>Name: {{ session('customer')->fname.' '.session('customer')->lname }}</h6>

                                        <h6>Address: {{ session('customer')->address }}</h6>

                                        <h6>City: {{ session('customer')->city }}</h6>

                                        <h6>Country: {{ session('customer')->country }}</h6>

                                        <h6>Phone: {{ session('customer')->phone }}</h6>
                                        <hr>
                                    </div>
                                @endif
                                @if( session('order') )
                                    <div id="su">
                                        <h4>Order Summary</h4>
                                        <h6>Sub Total: {{ session('order')->sub_total }}</h6>

                                        <h6>Discount: {{ session('order')->discount }}</h6>

                                        <h6>Discount Code: {{ session('order')->discount_code }}</h6>

                                        <h6>Shipping: {{ session('order')->shipping }}</h6>

                                        <h6>Total: {{ session('order')->total }}</h6>

                                        <h6>Note: {{ session('order')->note }}</h6>

                                        <h6>Status: {{ session('order')->status }}</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        // var pd = $('#pd').text()
        // var cu = $('#cu').text()
        // var su = $('#su').text()
        // $(document).on('submit', '#order-tracking', (event) => {
        //     pd = '';
        //     cu = '';
        //     su = '';
        //     event.preventDefault();
        //     var form = $('#order-tracking');
        //     var formData = new FormData(form[0]);
        //     $.ajax({
        //         type: form.attr('method'),
        //         url: form.attr('action'),
        //         contentType: false,
        //         processData: false,
        //         dataType: 'json',
        //         data: formData,
        //         success: (data) => {
        //             if( data.orderProduct !== null ){
        //                 var html = '';
        //                 $.each(data.orderProduct, (i, v) => {
        //
        //                 })
        //             }
        //         }
        //     })
        // })
    </script>
@endsection
