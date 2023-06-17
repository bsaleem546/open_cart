<!DOCTYPE html>
<html lang="en">
<head>
    <!-- set the encoding of your site -->
    <meta charset="utf-8">
    <!-- set the viewport width and initial-scale on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | The Twins Furniture</title>
    <link href="{{ url('public/web/favicon.png') }}" rel="shortcut icon" type="image/x-icon">
    <!-- include the site stylesheet -->
    <link
        href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic%7cMontserrat:400,700%7cOxygen:400,300,700'
        rel='stylesheet' type='text/css'>
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ url('public/web') }}/css/bootstrap.css">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ url('public/web') }}/css/animate.css">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ url('public/web') }}/css/icon-fonts.css">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ url('public/web') }}/css/main.css">
    <!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ url('public/web') }}/css/responsive.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    {{--    <link rel="stylesheet" href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">--}}

    @yield('styles')
</head>
<body>
<!-- main container of all the page elements -->
<div id="wrapper">
    <!-- Page Loader -->
    <div id="pre-loader" class="loader-container">
        <div class="loader">
            <img src="{{ url('public/web') }}/images/svg/rings.gif" alt="loader">
        </div>
    </div>
    <!-- W1 start here -->
    <div class="w1">
        <header id="mt-header" class="style4">

            <div class="mt-top-bar" style="padding: 0px !important;">
                <div class="container" style="width: 100% !important;">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 hidden-xs">
                            <span class="tel active" style="color: #fff; margin-left: 10px !important;"> <i
                                    class="fa fa-phone" aria-hidden="true"></i> +1 (555) 333 22 11</span>
                            <a class="tel" href="#" style="color: #fff"> <i class="fa fa-envelope-o"
                                                                            aria-hidden="true"></i>
                                info@schon.chairs</a>
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right">
                            <!-- mt-top-list start here -->
                            <ul class="mt-top-list">
                                <li><a href="{{ url('order-tracking') }}">Order Track</a></li>
                                <li><a href="{{ url('checkout') }}">Checkout</a></li>
                                @auth
                                    <li><a href="#">{{ Auth::user()->name }}</a></li>
                                    @if(Auth::user()->role == 'ADMIN')
                                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @endif
                            </ul><!-- mt-top-list end here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- mt bottom bar start here -->
            <div class="mt-bottom-bar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- mt logo start here -->
                            <div class="mt-logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ url('public/web') }}/logo.png" alt="ttf">
                                </a>
                            </div>
                            <!-- mt icon list start here -->
                            <ul class="mt-icon-list">
                                <li class="hidden-lg hidden-md">
                                    <a href="#" class="bar-opener mobile-toggle">
                                        <span class="bar"></span>
                                        <span class="bar small"></span>
                                        <span class="bar"></span>
                                    </a>
                                </li>
                                <li class="drop">
                                    <a href="#" class="icon-heart cart-opener">
                                        @if( \Illuminate\Support\Facades\Session::get('wishlist') !== null )
                                            <span style="margin-bottom: -3px;"
                                                  class="num">{{ count(\Illuminate\Support\Facades\Session::get('wishlist')) }}</span>
                                        @else
                                            <span style="margin-bottom: -3px;" class="num">0</span>
                                        @endif
                                    </a>
                                    <!-- mt drop start here -->
                                    <div class="mt-drop">
                                        <!-- mt drop sub start here -->
                                        <div class="mt-drop-sub">
                                            <!-- mt side widget start here -->
                                            <div class="mt-side-widget">
                                                @if( \Illuminate\Support\Facades\Session::get('wishlist') !== null )
                                                    @foreach(\Illuminate\Support\Facades\Session::get('wishlist') as $key => $value)
                                                        <div class="cart-row">
                                                            @php $path = \App\Models\Image_Product::where('product_id', $value['product_id'])->pluck('paths')->first()  @endphp
                                                            <a href="{{ url('products/'.$value['slug']) }}" class="img">
                                                                @if($path == null || $path == '')
                                                                    <img src="{{ url('public/imgs/empty.jpg') }}"
                                                                         alt="image" class="img-responsive">
                                                                @else
                                                                    <img src="{{ url('public/uploads/'.$path) }}"
                                                                         alt="image" class="img-responsive">
                                                                @endif
                                                            </a>
                                                            <div class="mt-h">
                                                                <span class="mt-h-title"><a
                                                                        href="{{ url('products/'.$value['slug']) }}">{{ $value['name'] }}</a></span>
                                                                <span class="price"><i class="fa fa-dollar"
                                                                                       aria-hidden="true"></i> {{ $value['price'] }}</span>
                                                            </div>
                                                            {{--                                                            <a href="#" class="close fa fa-times"></a>--}}
                                                        </div>
                                                @endforeach
                                            @endif


                                            {{--                                                <div class="cart-row-total">--}}
                                            {{--                                                    <span class="mt-total">Add them all</span>--}}
                                            {{--                                                    <span class="mt-total-txt"><a href="#" class="btn-type2">add to CART</a></span>--}}
                                            {{--                                                </div>--}}
                                            <!-- cart row total end here -->
                                            </div><!-- mt side widget end here -->
                                        </div>
                                        <!-- mt drop sub end here -->
                                    </div><!-- mt drop end here -->
                                    <span class="mt-mdropover"></span>
                                </li>
                                <li class="drop">
                                    <a href="#" class="cart-opener">
                                        <span class="icon-handbag"></span>
                                        @if(Auth::check())
                                            <span
                                                class="num">{{ count( \App\Models\Cart::where('user_id', Auth::user()->id)->get()  ) }}</span>
                                        @else
                                            @if( \Illuminate\Support\Facades\Session::get('cart') !== null )
                                                <span
                                                    class="num">{{ count(\Illuminate\Support\Facades\Session::get('cart')) }}</span>
                                            @else
                                                <span class="num">0</span>
                                            @endif
                                        @endif
                                    </a>
                                    <!-- mt drop start here -->
                                    <div class="mt-drop">
                                        <!-- mt drop sub start here -->
                                        <div class="mt-drop-sub">
                                            <!-- mt side widget start here -->
                                            <div class="mt-side-widget">
                                                @php $total = 0 @endphp
                                                @if(Auth::check())
                                                    @if( count( \App\Models\Cart::where('user_id', Auth::user()->id)->get()  ) > 0 )
                                                        @foreach(\App\Models\Cart::where('user_id', Auth::user()->id)->get() as $key => $value)
                                                            @php $total += $value['price']  @endphp
                                                            <div class="cart-row">
                                                                <a href="{{ url('products/'.$value['product_slug']) }}"
                                                                   class="img">
                                                                    @php $path = \App\Models\Image_Product::where('product_id', $value['product_id'])->pluck('paths')->first()  @endphp
                                                                    @if($path == null || $path == '')
                                                                        <img src="{{ url('public/imgs/empty.jpg') }}"
                                                                             alt="image" class="img-responsive">
                                                                    @else
                                                                        <img src="{{ url('public/uploads/'.$path) }}"
                                                                             alt="image" class="img-responsive">
                                                                    @endif

                                                                </a>
                                                                <div class="mt-h">
                                                                    <span class="mt-h-title"><a
                                                                            href="{{ url('products/'.$value['product_slug']) }}">{{ $value['product_name'] }}</a></span>
                                                                    <small>{{ $value['att'] }}</small><br>
                                                                    <span class="price">{{ $value['price'] }}</span>
                                                                    <span
                                                                        class="mt-h-title">Qty: {{ $value['quantity'] }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @if( \Illuminate\Support\Facades\Session::get('cart') !== null )
                                                        @foreach(\Illuminate\Support\Facades\Session::get('cart') as $key => $value)
                                                            @php $total += $value['price']  @endphp
                                                            <div class="cart-row">
                                                                <a href="{{ url('products/'.$value['product_slug']) }}"
                                                                   class="img">
                                                                    @php $path = \App\Models\Image_Product::where('product_id', $value['product_id'])->pluck('paths')->first()  @endphp
                                                                    @if($path == null || $path == '')
                                                                        <img src="{{ url('public/imgs/empty.jpg') }}"
                                                                             alt="image" class="img-responsive">
                                                                    @else
                                                                        <img src="{{ url('public/uploads/'.$path) }}"
                                                                             alt="image" class="img-responsive">
                                                                    @endif

                                                                </a>
                                                                <div class="mt-h">
                                                                    <span class="mt-h-title"><a
                                                                            href="{{ url('products/'.$value['product_slug']) }}">{{ $value['product_name'] }}</a></span>
                                                                    <small>{{ $value['att'] }}</small><br>
                                                                    <span class="price">{{ $value['price'] }}</span>
                                                                    <span
                                                                        class="mt-h-title">Qty: {{ $value['quantity'] }}</span>
                                                                </div>
                                                            </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                            <!-- cart row total start here -->
                                                <div class="cart-row-total">
                                                    <span class="mt-total">Sub Total</span>
                                                    <span class="mt-total-txt">{{ $total }}</span>
                                                </div>
                                                <!-- cart row total end here -->
                                                <div class="cart-btn-row">
                                                    <a href="{{ url('cart') }}" class="btn-type2">VIEW CART</a>
                                                    <a href="{{ url('checkout') }}" class="btn-type3">CHECKOUT</a>
                                                </div>
                                            </div><!-- mt side widget end here -->
                                        </div>
                                        <!-- mt drop sub end here -->
                                    </div><!-- mt drop end here -->
                                    <span class="mt-mdropover"></span>
                                </li>
                                @auth
                                @else
                                    <li>
                                        <a href="#" class="bar-opener side-opener">
                                            <span class="bar"></span>
                                            <span class="bar small"></span>
                                            <span class="bar"></span>
                                        </a>
                                    </li>
                                @endauth
                            </ul><!-- mt icon list end here -->
                            <!-- navigation start here -->
                            <nav id="nav">
                                <ul>
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li class="drop">
                                        <a href="#">Products <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        <!-- mt dropmenu start here -->
                                        <div class="mt-dropmenu text-left">
                                            <!-- mt frame start here -->
                                            <div class="mt-frame">
                                                <!-- mt f box start here -->
                                                <div class="mt-f-box">
                                                    <!-- mt col3 start here -->
                                                    <div class="mt-col-3">
                                                        <div class="sub-dropcont">
                                                            <strong class="title"><a href="#" class="mt-subopener">Chairs</a></strong>
                                                            <div class="sub-drop">
                                                                <ul>
                                                                    <li><a href="product-grid-view.html">Product Grid
                                                                            View</a></li>
                                                                    <li><a href="product-list-view.html">Product List
                                                                            View</a></li>
                                                                    <li><a href="product-quickview.html">Product
                                                                            QuickView popup</a></li>
                                                                    <li><a href="product-detail.html">Product Detail</a>
                                                                    </li>
                                                                    <li><a href="product-detail2.html">Product Detail
                                                                            V2</a></li>
                                                                    <li><a href="order-shopping-cart.html">Shopping
                                                                            Cart</a></li>
                                                                    <li><a href="order-checkout.html">Checkout</a></li>
                                                                    <li><a href="ordertracking.html">Order Tracking</a>
                                                                    </li>
                                                                    <li><a href="wishlist.html">Wish List</a></li>
                                                                    <li><a href="faq.html">FAQ Page</a></li>
                                                                    <li><a href="loginpage.html">Login Page</a></li>
                                                                    <li><a href="registerpage.html">Register Page</a>
                                                                    </li>
                                                                    <li><a href="newsletter-popup.html">Newsletter
                                                                            Popup</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- mt col3 end here -->

                                                    <!-- mt col3 start here -->
                                                    <div class="mt-col-3">
                                                        <div class="sub-dropcont">
                                                            <strong class="title"><a href="#" class="mt-subopener">Tables</a></strong>
                                                            <div class="sub-drop">
                                                                <ul>
                                                                    <li><a href="404-page.html">404 Page</a></li>
                                                                    <li><a href="404-page2.html">404 Page2</a></li>
                                                                    <li><a href="404-page3.html">404 Page3</a></li>
                                                                    <li><a href="404-page4.html">404 Page4</a></li>
                                                                    <li><a href="404-page5.html">404 Page5</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="sub-dropcont">
                                                            <strong class="title"><a href="#"
                                                                                     class="mt-subopener">Beds</a></strong>
                                                            <div class="sub-drop">
                                                                <ul>
                                                                    <li><a href="coming-soon.html">Coming Soon</a></li>
                                                                    <li><a href="coming-soon2.html">Coming Soon2</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- mt col3 end here -->

                                                    <!-- mt col3 start here -->
                                                    <div class="mt-col-3">
                                                        <div class="sub-dropcont">
                                                            <strong class="title"><a href="#" class="mt-subopener">KITCHEN
                                                                    FURNITURE</a></strong>
                                                            <div class="sub-drop">
                                                                <ul>
                                                                    <li><a href="#">Kitchen Taps</a></li>
                                                                    <li><a href="#">Breakfast time</a></li>
                                                                    <li><a href="#">Cooking</a></li>
                                                                    <li><a href="#">Food Storage Boxes</a></li>
                                                                    <li><a href="#">Spice Jars</a></li>
                                                                    <li><a href="#">Napskins</a></li>
                                                                    <li><a href="#">Oven Gloves</a></li>
                                                                    <li><a href="#">Placemats</a></li>
                                                                    <li><a href="#">Cooking</a></li>
                                                                    <li><a href="#">Food Storage Boxes</a></li>
                                                                    <li><a href="#">Spice Jars</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- mt col3 end here -->

                                                    <!-- mt col3 start here -->
                                                    <div class="mt-col-3 promo">
                                                        <div class="mt-promobox">
                                                            <a href="#"><img
                                                                    src="{{ url('public/web') }}/images/banner-drop.jpg"
                                                                    alt="promo banner" class="img-responsive"></a>
                                                        </div>
                                                    </div>
                                                    <!-- mt col3 end here -->
                                                </div>
                                                <!-- mt f box end here -->
                                            </div>
                                            <!-- mt frame end here -->
                                        </div>
                                        <!-- mt dropmenu end here -->
                                        <span class="mt-mdropover"></span>
                                    </li>
                                    <li><a href="{{ url('about-us') }}">About</a></li>
                                    <li><a href="{{ url('contact-us') }}">Contact</a></li>
                                </ul>
                            </nav>
                            <!-- mt icon list end here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- mt bottom bar end here -->
            <span class="mt-side-over"></span>
        </header>

    @auth
    @else
        <!-- mt side menu start here -->
            <div class="mt-side-menu">
                <!-- mt holder start here -->
                <div class="mt-holder">
                    <a href="#" class="side-close"><span></span><span></span></a>
                    <strong class="mt-side-title">MY ACCOUNT</strong>
                    <!-- mt side widget start here -->
                    <div class="mt-side-widget">
                        <header>
                            <span class="mt-side-subtitle">SIGN IN</span>
                            <p>Welcome back! Sign in to Your Account</p>
                        </header>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <fieldset>
                                <input type="text" placeholder="email address" class="input" name="email">
                                <input type="password" placeholder="Password" class="input" name="password">
                                <div class="box">
                                    <span class="left"><input class="checkbox" type="checkbox" id="check1"><label
                                            for="check1">Remember Me</label></span>
                                    <a href="{{ route('password.request') }}" class="help">Forget Password?</a>
                                </div>
                                <button type="submit" class="btn-type1">Login</button>
                            </fieldset>
                        </form>
                    </div>
                    <!-- mt side widget end here -->
                    <div class="or-divider"><span class="txt">or</span></div>
                    <!-- mt side widget start here -->
                    <div class="mt-side-widget">
                        <header>
                            <span class="mt-side-subtitle">CREATE NEW ACCOUNT</span>
                            <p>Create your very own account</p>
                        </header>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <fieldset>
                                <input type="text" placeholder="Name" class="input" name="name" required>
                                <input type="text" placeholder="email address" class="input" name="email" required>
                                <input type="password" placeholder="Password" class="input" name="password" required>
                                <input type="password" placeholder="Confirm Password" class="input"
                                       name="password_confirmation" required>
                                <button type="submit" class="btn-type1">Register</button>
                            </fieldset>
                        </form>
                    </div>
                    <!-- mt side widget end here -->
                </div>
                <!-- mt holder end here -->
            </div>
            <!-- mt side menu end here -->
    @endauth
    @yield('content')


    <!-- footer of the Page -->
        <footer id="mt-footer" class="style1 wow fadeInUp" data-wow-delay="0.4s">
            <!-- Footer Holder of the Page -->
            <div class="footer-holder dark">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
                            <!-- F Widget About of the Page -->
                            <div class="f-widget-about">
                                <div class="logo">
                                    <a href="#"><img src="{{ url('public/web') }}/logo1.png" alt="Schon"></a>
                                </div>
                                <p>Exercitation ullamco laboris nisi ut aliquip ex commodo consequat. Duis aute irure
                                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.</p>
                                <!-- Social Network of the Page -->
                                <ul class="list-unstyled social-network">
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
                                </ul>
                                <!-- Social Network of the Page end -->
                            </div>
                            <!-- F Widget About of the Page end -->
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
                            <div class="f-widget-news">
                                <h3 class="f-widget-heading">Quick Links</h3>
                                <ul class="list-unstyled tabs">
                                    <li><a href="{{ url('order-tracking') }}">Order Tracking</a></li>
                                    <li><a href="{{ url('products') }}">Products</a></li>
                                    <li><a href="{{ url('about-us') }}">About Us</a></li>
                                    <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                                    <li><a href="{{ url('terms-and-conditions') }}">Terms And Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomxs">
                            <!-- Footer Tabs of the Page -->
                            <div class="f-widget-tabs">
                                <h3 class="f-widget-heading">Product Categories</h3>
                                <ul class="list-unstyled tabs">
                                    <!-- number needs to be 15 -->
                                    @if(\App\Models\Category::count() > 8)
                                        @foreach(\App\Models\Category::all()->random(8) as $c)
                                            <li><a href="{{ url('categories/'.$c->slug) }}">{{ $c->name }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- Footer Tabs of the Page -->
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 text-right">
                            <!-- F Widget About of the Page -->
                            <div class="f-widget-about">
                                <h3 class="f-widget-heading">Information</h3>
                                <ul class="list-unstyled address-list align-right">
                                    <li><i class="fa fa-map-marker"></i>
                                        <address>Connaugt Road Central Suite 18B, 148 <br>New Yankee</address>
                                    </li>
                                    <li><i class="fa fa-phone"></i><a href="tel:15553332211">+1 (555) 333 22 11</a></li>
                                    <li><i class="fa fa-envelope-o"></i><a
                                            href="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#110;&#046;&#099;&#104;&#097;&#105;&#114;">&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#110;&#046;&#099;&#104;&#097;&#105;&#114;</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- F Widget About of the Page end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Holder of the Page end -->
            <!-- Footer Area of the Page -->
            <div class="footer-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <p>© <a href="#">The Twins Furniture</a> - All rights Reserved</p>
                        </div>
                        <div class="col-xs-12 col-sm-6 text-right">
                            <div class="bank-card">
                                <img src="{{ url('public/web') }}/images/bank-card.png" alt="bank-card">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Area of the Page end -->
        </footer><!-- footer of the Page end -->
    </div><!-- W1 end here -->
    <span id="back-top" class="fa fa-arrow-up"></span>
</div>

@if(Request::is('/'))
    @php $popup = \App\Models\Popup::where('status', 1)->latest()->first()  @endphp
    @if($popup !== null)
        <a id="newsletter-hiddenlink" href="#popup2" class="lightbox" style="display: none;">NEWSLETTER</a>

        <div class="popup-holder">
            <div id="popup2" class="lightbox">
                <!-- Mt Newsletter Popup of the Page -->
                <section class="mt-newsletter-popup">
                    <span class="title">NEWSLETTER</span>
                    <div class="holder">
                        <div class="txt-holder">
                            <h1>{{ $popup->title }}</h1>
                            <span class="txt" style="margin-bottom: 10px">{{ $popup->sub_title }}</span>
                            <span class="txt pop_text_op"
                                  style="margin-bottom: 10px; font-size: 16px">{{ $popup->optional_sub_title }}</span>
                            <a href="{{ $popup->btn_link }}"
                               style="    width: 173px !important;
                                padding: 12px 10px 10px !important;
                                text-align: center !important;
                                text-transform: uppercase !important;
                                display: block !important;
                                font-size: 14px !important;
                                line-height: 20px !important;
                                background: #FBA421 !important;
                                color: #fff !important;
                            " target="_blank">{{ $popup->btn_text }}</a>
                        </div>
                        <div class="img-holder">
                            <img src="{{ url('public/uploads/popups/'.$popup->img) }}" alt="image description">
                        </div>
                    </div>
                </section><!-- Mt Newsletter Popup of the Page -->
            </div>
        </div>
    @endif
@endif


<!-- include jQuery -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script src="{{ url('public/web') }}/js/jquery.js"></script>

@yield('scripts')

<!-- include jQuery -->
<script src="{{ url('public/web') }}/js/plugins.js"></script>
<!-- include jQuery -->
<script src="{{ url('public/web') }}/js/jquery.main.js"></script>


</body>
</html>
