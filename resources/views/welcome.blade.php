@extends('layouts.web')

@section('title', 'Home')

@section('styles')
    <style>
        .my-btn {
            color: #fff;
            padding: 9px 25px;
            background: transparent;
            border-radius: 20px;
            text-decoration: none;
            letter-spacing: -0.4px;
            text-transform: uppercase;
            font: 13px/16px "Montserrat", sans-serif;
            -moz-transition: all 0.4s linear;
            -webkit-transition: all 0.4s linear;
            -o-transition: all 0.4s linear;
            transition: all 0.4s linear;
            border: 1px solid #fff;
        }

        .my-btn:hover {
            color: #fff;
            background: #FBA421 !important;
        }
    </style>
@endsection

@section('content')

    <div class="mt-main-slider">
        <div class="slider banner-slider">
            <!-- holder start here -->
            @foreach($slides as $slider)

                <div class="holder text-center"
                     style="background-image: url( {{ url('public/uploads/slides/'.$slider->img) }} );
                         background-blend-mode: overlay;
                         background-color: rgba(0,0,0,0.5);">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="text">
                                    <strong class="title" style="color: white">{{ $slider->text1 }}</strong>
                                    <h1 style="color: white">{{ $slider->text2 }}</h1>
                                    <h2 style="color: white">{{ $slider->text3 }}</h2>
                                    <div class="txt">
                                        <p style="color: white">{{ $slider->text4 }}</p>
                                    </div>
                                    <a href="{{ $slider->btn_link }}" class="shop"
                                       style="color: white">{{ $slider->btn_text }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <main id="mt-main">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="banner-frame">
                        <div class="banner-box fourth">

                            <div class="banner-box sixth">

                                @php $div1 = \App\Models\HomeSection1::where('position', 2)->first() @endphp
                                @if(isset($div1))
                                    <div class="banner-17 white">
                                        <img src="{{ url('public/uploads/home/'.$div1->img) }}" alt="image description"
                                             width="390" height="320">
                                        <div class="holder">
                                            <h4>{{ $div1->heading }}</h4>
                                            <h6>{{ $div1->sub_heading }}</h6>
                                            <p style="margin-bottom: 15px;">{{ $div1->text }}</p>
                                            <a href="{{ $div1->btn_link }}" class="now my-btn">{{ $div1->btn_text }}</a>
                                        </div>
                                    </div>
                                @endif

                                @php $div2 = \App\Models\HomeSection1::where('position', 1)->first() @endphp
                                @if(isset($div2))
                                    <div class="banner-18 right">
                                        <img src="{{ url('public/uploads/home/'.$div2->img) }}" alt="image description"
                                             width="390" height="320">
                                        <div class="holder">
                                            <h2><strong>{{ $div2->heading }}</strong></h2>
                                            <div class="price-tag">
                                                <span class="price-off">{{ $div2->sub_heading }}</span>
                                                <span class="price"
                                                      style="margin-bottom: 15px;">{{ $div2->text }}</span>
                                                <a class="now my-btn" href="{{ $div2->btn_link }}"
                                                   style="background: #535353;">
                                                    {{ $div2->btn_text }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @php $div3 = \App\Models\HomeSection1::where('position', 5)->first() @endphp
                            @if(isset($div3))
                                <div class="banner-19">
                                    <img src="{{ url('public/uploads/home/'.$div3->img) }}" alt="image description"
                                         width="792" height="493">
                                    <div class="holder">
                                        <div class="txt">
                                            <strong class="heading">{{ $div3->heading }}</strong>
                                            <h3><strong>{{ $div3->sub_heading }}</h3>
                                            <p>{{ $div3->text }}</p>
                                            <a href="{{ $div3->btn_link }}" class="now">{{ $div3->btn_text }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="banner-box fifth hidden-md hidden-sm hidden-xs">

                            @php $div4 = \App\Models\HomeSection1::where('position', 6)->first() @endphp

                            @if(isset($div4))
                                <div class="banner-20">
                                    <img src="{{ url('public/uploads/home/'.$div4->img) }}" alt="image description"
                                         width="387" height="520">
                                    <div class="holder">
                                        <h2>{{ $div4->heading }}</h2>
                                        <p>{{ $div4->sub_heading }}</p>
                                        <p>{{ $div4->text }}</p>
                                        <a href="{{ $div4->btn_link }}" class="card">{{ $div4->btn_text }}</a>
                                    </div>
                                </div>
                            @endif

                            @php $div5 = \App\Models\HomeSection1::where('position', 4)->first() @endphp
                            @if(isset($div5))
                                <div class="banner-21 right">
                                    <img src="{{ url('public/uploads/home/'.$div5->img) }}" alt="image description"
                                         width="387" height="290">
                                    <div class="holder">
                                        <strong class="title">{{ $div5->heading }}</strong>
                                        <h2>{{ $div5->sub_heading }}</h2>
                                        <p>{{ $div5->text }}</p>
                                        <a href="{{ $div5->btn_link }}" class="view">{{ $div5->btn_text }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="product-area wow fadeInUp" data-wow-delay="0.4s"
                         style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 mt-heading text-uppercase text-center">
                                    <h2 class="heading">LATEST PRODUCTS</h2>
                                    <p>FURNITURE DESIGNS IDEAS</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">

                                    <div class="mt-box borderright borderbottom half">
                                        @php $latest1 = \App\Models\Product::latest()->first() @endphp
                                        @if(isset($latest1))
                                            <div class="mt-product1 large">
                                                <div class="box">
                                                    <div class="b1">
                                                        <div class="b2">
                                                            <a href="{{ url('products/'.$latest1->slug) }}">
                                                                <img
                                                                    src="{{ url('public/uploads/'.$latest1->singleImg->paths) }}"
                                                                    alt="image description" width="590" height="485">
                                                            </a>
                                                            <ul class="links">
                                                                <li><a href="javascript::void()"
                                                                       onclick="cart({{ $latest1 }})">
                                                                        <i class="icon-handbag"></i><span>Add to Cart</span>
                                                                    </a></li>
                                                                <li><a href="javascript::void()"
                                                                       onclick="wishlist({{ $latest1->id }})">
                                                                        <i class="fa fa-heart"
                                                                           style="color: {{ isset($wishlist[$latest1->id]) ? '#FBA421' : '' }}"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="txt">
                                                    <strong class="title"><a
                                                            href="{{ url('products/'.$latest1->slug) }}">{{ $latest1->name }}</a></strong>
                                                    @if($latest1->has_attributes == 1)
                                                        <span class="price"><span id="price-change">
                                                            {{ $latest1->variation_values->min('price') }} - {{ $latest1->variation_values->max('price') }}
                                                    </span></span>
                                                    @else
                                                        @if($latest1->sale_price > 0)
                                                            <span class="price"> <span id="price-change">{{ $latest1->sale_price }} <del>{{ $latest1->price }}</del></span></span>
                                                        @else
                                                            <span class="price"> <span
                                                                    id="price-change">{{ $latest1->price }}</span></span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-holder">
                                        <div class="mt-frame">

                                            @php $latest2 = \App\Models\Product::latest()->skip(1)->first() @endphp
                                            @if(isset($latest2))
                                                <div class="mt-box half borderright">
                                                    <div class="mt-product1 large">
                                                        <div class="box">
                                                            <div class="b1">
                                                                <div class="b2">
                                                                    <a href="{{ url('products/'.$latest2->slug) }}">
                                                                        <img
                                                                            src="{{ url('public/uploads/'.$latest2->singleImg->paths) }}"
                                                                            alt="image description" width="299"
                                                                            height="193">
                                                                    </a>
                                                                    <ul class="links">
                                                                        <li><a href="javascript::void()"
                                                                               onclick="cart({{ $latest2 }})">
                                                                                <i class="icon-handbag"></i><span>Add to Cart</span>
                                                                            </a></li>
                                                                        <li><a href="javascript::void()"
                                                                               onclick="wishlist({{ $latest2->id }})">
                                                                                <i class="fa fa-heart"
                                                                                   style="color: {{ isset($wishlist[$latest2->id]) ? '#FBA421' : '' }}"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="txt">
                                                            <strong class="title"><a
                                                                    href="{{ url('products/'.$latest2->slug) }}">{{ $latest2->name }}</a></strong>
                                                            @if($latest2->has_attributes == 1)
                                                                <span class="price"><span id="price-change">
                                                            {{ $latest2->variation_values->min('price') }} - {{ $latest2->variation_values->max('price') }}
                                                    </span></span>
                                                            @else
                                                                @if($latest2->sale_price > 0)
                                                                    <span class="price"> <span id="price-change">{{ $latest2->sale_price }} <del>{{ $latest2->price }}</del></span></span>
                                                                @else
                                                                    <span class="price"> <span
                                                                            id="price-change">{{ $latest2->price }}</span></span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @php $latest3 = \App\Models\Product::latest()->skip(2)->first() @endphp
                                            @if(isset($latest3))
                                                <div class="mt-box half">
                                                    <div class="mt-product1 large">
                                                        <div class="box">
                                                            <div class="b1">
                                                                <div class="b2">
                                                                    <a href="{{ url('products/'.$latest3->slug) }}">
                                                                        <img
                                                                            src="{{ url('public/uploads/'.$latest3->singleImg->paths) }}"
                                                                            alt="image description" width="299"
                                                                            height="193">
                                                                    </a>
                                                                    <ul class="links">
                                                                        <li><a href="javascript::void()"
                                                                               onclick="cart({{ $latest3 }})">
                                                                                <i class="icon-handbag"></i><span>Add to Cart</span>
                                                                            </a></li>
                                                                        <li><a href="javascript::void()"
                                                                               onclick="wishlist({{ $latest3->id }})">
                                                                                <i class="fa fa-heart"
                                                                                   style="color: {{ isset($wishlist[$latest3->id]) ? '#FBA421' : '' }}"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="txt">
                                                            <strong class="title"><a
                                                                    href="{{ url('products/'.$latest3->slug) }}">{{ $latest3->name }}</a></strong>
                                                            @if($latest3->has_attributes == 1)
                                                                <span class="price"><span id="price-change">
                                                            {{ $latest3->variation_values->min('price') }} - {{ $latest3->variation_values->max('price') }}
                                                    </span></span>
                                                            @else
                                                                @if($latest3->sale_price > 0)
                                                                    <span class="price"> <span id="price-change">{{ $latest3->sale_price }} <del>{{ $latest3->price }}</del></span></span>
                                                                @else
                                                                    <span class="price"> <span
                                                                            id="price-change">{{ $latest3->price }}</span></span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-frame">
                                            @php $latest4 = \App\Models\Product::latest()->skip(3)->first() @endphp
                                            @if(isset($latest4))
                                                <div class="mt-box half borderright">
                                                    <div class="mt-product1 large">
                                                        <div class="box">
                                                            <div class="b1">
                                                                <div class="b2">
                                                                    <a href="{{ url('products/'.$latest4->slug) }}">
                                                                        <img
                                                                            src="{{ url('public/uploads/'.$latest4->singleImg->paths) }}"
                                                                            alt="image description" width="299"
                                                                            height="193">
                                                                    </a>
                                                                    <ul class="links">
                                                                        <li><a href="javascript::void()"
                                                                               onclick="cart({{ $latest4 }})">
                                                                                <i class="icon-handbag"></i><span>Add to Cart</span>
                                                                            </a></li>
                                                                        <li><a href="javascript::void()"
                                                                               onclick="wishlist({{ $latest4->id }})">
                                                                                <i class="fa fa-heart"
                                                                                   style="color: {{ isset($wishlist[$latest4->id]) ? '#FBA421' : '' }}"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="txt">
                                                            <strong class="title"><a
                                                                    href="{{ url('products/'.$latest4->slug) }}">{{ $latest4->name }}</a></strong>
                                                            @if($latest4->has_attributes == 1)
                                                                <span class="price"><span id="price-change">
                                                            {{ $latest4->variation_values->min('price') }} - {{ $latest4->variation_values->max('price') }}
                                                    </span></span>
                                                            @else
                                                                @if($latest4->sale_price > 0)
                                                                    <span class="price"> <span id="price-change">{{ $latest4->sale_price }} <del>{{ $latest4->price }}</del></span></span>
                                                                @else
                                                                    <span class="price"> <span
                                                                            id="price-change">{{ $latest4->price }}</span></span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @php $latest5 = \App\Models\Product::latest()->skip(4)->first() @endphp
                                            @if(isset($latest5))
                                                <div class="mt-box half">
                                                    <div class="mt-product1 large">
                                                        <div class="box">
                                                            <div class="b1">
                                                                <div class="b2">
                                                                    <a href="{{ url('products/'.$latest5->slug) }}">
                                                                        <img
                                                                            src="{{ url('public/uploads/'.$latest5->singleImg->paths) }}"
                                                                            alt="image description" width="299"
                                                                            height="193">
                                                                    </a>
                                                                    <ul class="links">
                                                                        <li><a href="javascript::void()"
                                                                               onclick="cart({{ $latest5 }})">
                                                                                <i class="icon-handbag"></i><span>Add to Cart</span>
                                                                            </a></li>
                                                                        <li><a href="javascript::void()"
                                                                               onclick="wishlist({{ $latest5->id }})">
                                                                                <i class="fa fa-heart"
                                                                                   style="color: {{ isset($wishlist[$latest5->id]) ? '#FBA421' : '' }}"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="txt">
                                                            <strong class="title"><a
                                                                    href="{{ url('products/'.$latest5->slug) }}">{{ $latest5->name }}</a></strong>
                                                            @if($latest5->has_attributes == 1)
                                                                <span class="price"><span id="price-change">
                                                            {{ $latest5->variation_values->min('price') }} - {{ $latest5->variation_values->max('price') }}
                                                    </span></span>
                                                            @else
                                                                @if($latest5->sale_price > 0)
                                                                    <span class="price"> <span id="price-change">{{ $latest5->sale_price }} <del>{{ $latest5->price }}</del></span></span>
                                                                @else
                                                                    <span class="price"> <span
                                                                            id="price-change">{{ $latest5->price }}</span></span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-producttabs wow fadeInUp" data-wow-delay="0.4s">
                        <!-- producttabs start here -->
                        <ul class="producttabs">
                            <li><a href="#tab1" class="active">FEATURED</a></li>
                            <li><a href="#tab2">LATEST</a></li>
                            {{--                            <li><a href="#tab3">BEST SELLER</a></li>--}}
                        </ul>
                        <!-- producttabs end here -->
                        <div class="tab-content text-center">

                            <div id="tab1">
                                <div class="tabs-slider">
                                    @foreach($featured as $fe)
                                        <div class="slide">
                                            <div class="mt-product1 mt-paddingbottom20">
                                                <div class="box">
                                                    <div class="b1">
                                                        <div class="b2">
                                                            <a href="{{ url('products/'.$fe->slug) }}">
                                                                <img
                                                                    src="{{ url('public/uploads/'.$fe->singleImg->paths) }}"
                                                                    alt="image description" width="250" height="230">
                                                            </a>
                                                            <ul class="links">
                                                                <li><a href="javascript::void()"
                                                                       onclick="cart({{ $fe }})">
                                                                        <i class="icon-handbag"></i><span>Add to Cart</span></a>
                                                                </li>
                                                                <li><a href="javascript::void()"
                                                                       onclick="wishlist({{ $fe->id }})">
                                                                        <i class="fa fa-heart"
                                                                           style="color: {{ isset($wishlist[$fe->id]) ? '#FBA421' : '' }}"></i>
                                                                    </a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="txt">
                                                    <strong class="title"><a
                                                            href="{{ url('products/'.$fe->slug) }}">{{ $fe->name }}</a></strong>
                                                    @if($fe->has_attributes == 1)
                                                        <span class="price"><span id="price-change">
                                                            {{ $fe->variation_values->min('price') }} - {{ $fe->variation_values->max('price') }}
                                                    </span></span>
                                                    @else
                                                        @if($fe->sale_price > 0)
                                                            <span class="price"> <span id="price-change">{{ $fe->sale_price }} <del>{{ $fe->price }}</del></span></span>
                                                        @else
                                                            <span class="price"> <span
                                                                    id="price-change">{{ $fe->price }}</span></span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div id="tab2">
                                <div class="tabs-slider">
                                    @foreach($latest as $lt)
                                        <div class="slide">
                                            <div class="mt-product1 mt-paddingbottom20">
                                                <div class="box">
                                                    <div class="b1">
                                                        <div class="b2">
                                                            <a href="{{ url('products/'.$lt->slug) }}">
                                                                <img
                                                                    src="{{ url('public/uploads/'.$lt->singleImg->paths) }}"
                                                                    alt="image description" width="250" height="230">
                                                            </a>
                                                            <ul class="links">
                                                                <li><a href="javascript::void()"
                                                                       onclick="cart({{ $lt }})">
                                                                        <i class="icon-handbag"></i><span>Add to Cart</span></a>
                                                                </li>
                                                                <li><a href="javascript::void()"
                                                                       onclick="wishlist({{ $lt->id }})">
                                                                        <i class="fa fa-heart"
                                                                           style="color: {{ isset($wishlist[$lt->id]) ? '#FBA421' : '' }}"></i>
                                                                    </a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="txt">
                                                    <strong class="title"><a
                                                            href="{{ url('products/'.$lt->slug) }}">{{ $lt->name }}</a></strong>
                                                    @if($lt->has_attributes == 1)
                                                        <span class="price"><span id="price-change">
                                                            {{ $lt->variation_values->min('price') }} - {{ $lt->variation_values->max('price') }}
                                                    </span></span>
                                                    @else
                                                        @if($lt->sale_price > 0)
                                                            <span class="price"> <span id="price-change">{{ $lt->sale_price }} <del>{{ $lt->price }}</del></span></span>
                                                        @else
                                                            <span class="price"> <span
                                                                    id="price-change">{{ $lt->price }}</span></span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{--                            <div id="tab3"> </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-bestseller text-center wow fadeInUp" data-wow-delay="0.4s">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 mt-heading text-uppercase">
                        <h2 class="heading">BEST SELLER</h2>
                        <p>EXCEPTEUR SINT OCCAECAT</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bestseller-slider">
                            @foreach($bestSeller as $bs)
                                <div class="slide">
                                    <div class="mt-product1 large">
                                        <div class="box">
                                            <div class="b1">
                                                <div class="b2">
                                                    <a href="{{ url('products/'.$bs->slug) }}">
                                                        <img src="{{ url('public/uploads/'.$bs->singleImg->paths) }}"
                                                             alt="image description" width="280" height="290">
                                                    </a>
                                                    <ul class="links add">
                                                        <li><a href="javascript::void()" onclick="cart({{ $bs }})">
                                                                <i class="icon-handbag"></i><span>Add to Cart</span>
                                                            </a></li>
                                                        <li>
                                                            <a href="javascript::void()"
                                                               onclick="wishlist({{ $bs->id }})">
                                                                <i class="fa fa-heart"
                                                                   style="color: {{ isset($wishlist[$bs->id]) ? '#FBA421' : '' }}"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="txt">
                                            <strong class="title"><a
                                                    href="{{ url('products/'.$bs->slug) }}">{{ $bs->name }}</a></strong>
                                            @if($bs->has_attributes == 1)
                                                <span class="price"><span id="price-change">
                                                            {{ $bs->variation_values->min('price') }} - {{ $bs->variation_values->max('price') }}
                                                    </span></span>
                                            @else
                                                @if($bs->sale_price > 0)
                                                    <span class="price"> <span id="price-change">{{ $bs->sale_price }} <del>{{ $bs->price }}</del></span></span>
                                                @else
                                                    <span class="price"> <span id="price-change">{{ $bs->price }}</span></span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('scripts')
    <script src="{{ url('public/js/my-js.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function wishlist(id) {
            $.ajax({
                type: 'GET',
                url: main_url + 'addToWishlist/' + id,
                dataType: 'JSON',
                success: (data) => {
                    if (data.status == true) {
                        location.reload();
                    }
                }
            })
        }

        function cart(data) {
            var price = data.sale_price > 0 ? data.sale_price : data.price;
            $.ajax({
                type: 'POST',
                url: main_url + 'addToCart',
                dataType: 'JSON',
                data: {id: data.id, qty: 1, price: price, att: ''},
                success: (data) => {
                    if (data.status == true) {
                        location.reload();
                    }
                },
                error: (err) => {
                },
            })
        }
    </script>
@endsection
