<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - The Twins Furniture</title>
    <link href="{{ url('public/web/favicon.png') }}" rel="shortcut icon" type="image/x-icon">

    <!-- Scripts -->
{{--    <script src="{{ url('public/js/app.js') }}" defer></script>--}}

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{--    <link href="{{ url('public/css/app.css') }}" rel="stylesheet">--}}

    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="{{ url('public/assets') }}/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="{{ url('public/assets') }}/css/style.css" rel="stylesheet">

    @yield('styles')
</head>
<body>

<!--*******************
        Preloader start
    ********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<div id="app">
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ url('/') }}" class="brand-logo">
            <!--<img class="logo-abbr" src="{{ url('public/web') }}/logo1.png" alt="">-->
            <!--<img class="logo-compact" src="{{ url('public/web') }}/logo1.png" alt="">-->
            <!--<img class="brand-title" src="{{ url('public/web') }}/logo1.png" alt="">-->
                <h3 style="padding:10px;color:white;margin-top: 15px;">The Twins Furniture</h1>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">

                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-user"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul>
                                    <a class="all-notification" href="#">See all notifications <i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="quixnav">
            @include('partials.sidebar')
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

    </div>


</div>


<script src="{{ url('public/assets') }}/vendor/global/global.min.js"></script>
<script src="{{ url('public/assets') }}/js/quixnav-init.js"></script>
<script src="{{ url('public/assets') }}/js/custom.min.js"></script>


<!-- Vectormap -->
<script src="{{ url('public/assets') }}/vendor/raphael/raphael.min.js"></script>
<script src="{{ url('public/assets') }}/vendor/morris/morris.min.js"></script>


<script src="{{ url('public/assets') }}/vendor/circle-progress/circle-progress.min.js"></script>
<script src="{{ url('public/assets') }}/vendor/chart.js/Chart.bundle.min.js"></script>

<script src="{{ url('public/assets') }}/vendor/gaugeJS/dist/gauge.min.js"></script>

<!--  flot-chart js -->
<script src="{{ url('public/assets') }}/vendor/flot/jquery.flot.js"></script>
<script src="{{ url('public/assets') }}/vendor/flot/jquery.flot.resize.js"></script>

<!-- Owl Carousel -->
<script src="{{ url('public/assets') }}/vendor/owl-carousel/js/owl.carousel.min.js"></script>

<!-- Counter Up -->
<script src="{{ url('public/assets') }}/vendor/jqvmap/js/jquery.vmap.min.js"></script>
<script src="{{ url('public/assets') }}/vendor/jqvmap/js/jquery.vmap.usa.js"></script>
<script src="{{ url('public/assets') }}/vendor/jquery.counterup/jquery.counterup.min.js"></script>



@yield('scripts')
</body>
</html>
