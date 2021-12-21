@extends('layouts.web')

@section('title', 'Categories')

@section('styles')

@endsection

@section('content')

    <section class="mt-contact-banner style4" style="background-color: #F6F6F6">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h1>Categories</h1>
                    <!-- Breadcrumbs of the Page -->
                    <nav class="breadcrumbs">
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}">Home <i class="fa fa-angle-right"></i></a></li>
                            <li>Categories</li>
                        </ul>
                    </nav>
                    <!-- Breadcrumbs of the Page end -->
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <!-- sidebar of the Page start here -->
            <aside id="sidebar" class="col-xs-12 col-sm-4 col-md-3 wow fadeInLeft"
                   data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                <!-- shop-widget filter-widget of the Page start here -->

                <!-- shop-widget of the Page start here -->
                <section class="shop-widget">
                    <h2>CATEGORIES</h2>
                    <!-- category list start here -->
                    <ul class="list-unstyled category-list">
                        @foreach(\App\Models\Category::orderBy('created_at')->get() as $c)
                            <li>
                                <a href="{{ url('categories/'.$c->slug) }}">
                                    <span class="name">{{ $c->name }}</span>
                                    <span class="num"> {{ count($c->products) }} </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <!-- category list end here -->
                </section>
                <!-- shop-widget of the Page end here -->

                <!-- shop-widget of the Page start here -->
                <section class="shop-widget">
                    <h2>HOT SALE</h2>
                    @foreach(\App\Models\Product::where('sale_price', '>', 0)->take(5)->get() as $sp)
                        <div class="mt-product4 mt-paddingbottom20">
                            <div class="img">
                                <a href="{{ url('products/'.$sp->slug) }}">

                                    @if($sp->singleImages->isEmpty())
                                        <img src="{{ url('public/imgs/empty.jpg') }}" alt="image description" style="width: 80px; height: 80px">
                                    @else
                                        @foreach($sp->singleImages as $i)
                                            <img src="{{ url('public/uploads/'.$i->paths) }}" alt="image description" style="width: 80px; height: 80px">
                                        @endforeach
                                    @endif
                                </a>
                            </div>
                            <div class="text">
                                <div class="frame">
                                    <strong><a href="{{ url('products/'.$sp->slug) }}">{{ $sp->name }}</a></strong>
                                    <ul class="mt-stars">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                                <del class="off">${{ $sp->price }}</del>
                                <span class="price">${{ $sp->sale_price }}</span>
                            </div>
                        </div>
                    @endforeach

                </section><!-- shop-widget of the Page end here -->
            </aside><!-- sidebar of the Page end here -->

            <div class="col-xs-12 col-sm-8 col-md-9 wow fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                <header class="mt-shoplist-header"></header>
                <!-- mt productlisthold start here -->
                <ul class="mt-productlisthold list-inline">
                    @foreach($categories as $c)
                        <li>
                            <!-- mt product1 large start here -->
                            <div class="mt-product1 large">
                                <div class="box">
                                    <div class="b1">
                                        <div class="b2">
                                            <a href="{{ url('categories/'.$c->slug) }}">
                                                @if($c->img == null)
                                                    <img src="{{ url('public/imgs/empty.jpg') }}" alt="image description">
                                                @else
                                                    <img src="{{ url('public/uploads/category/'.$c->img) }}" alt="image description" style="width: 303px; height: 303px">
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="txt">
                                    <strong class="title"><a href="{{ url('categories/'.$c->slug) }}">{{ $c->name }}</a></strong>
                                    <span class="price"> <span>
                                            @if(!$c->products->isEmpty())
                                                @foreach($c->products as $p)
                                                    ${{ $p->min('price') }} - ${{ $p->max('price') }}
                                                    @break
                                                @endforeach
                                            @endif
                                    </span></span>

                                </div>
                            </div><!-- mt product1 center end here -->
                        </li>

                    @endforeach
                </ul><!-- mt productlisthold end here -->

                <div class="my-pagiantion">
                    {!! $categories->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
