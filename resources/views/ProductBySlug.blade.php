@extends('layouts.web')

@section('title', $product['name'])

@section('styles')
<style>
    .mySlides{
        display: none;
    }
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }
    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
    }
    .img_ht{
        height: 600px;
    }
    .cart-btn{
        width: 173px !important;
        padding: 12px 10px 10px !important;
        text-align: center !important;
        text-transform: uppercase !important;
        display: block !important;
        font-size: 14px !important;
        line-height: 20px !important;
        font-family: "Montserrat", sans-serif !important;
        font-weight: 700 !important;
        border: none !important;
        outline: none !important;
        border-radius: 25px;
        -webkit-transition: all 0.25s linear !important;
        -o-transition: all 0.25s linear !important;
        transition: all 0.25s linear !important;
        background: #FBA421 !important;
        color: #fff !important;
    }
    input#cart_btn:disabled {
        opacity: 0.5;
    }
    .r-success {
        padding: 10px;
        background-color: #b0e3a5;
    }
    h3#success-r {
        color: green;
    }
    .r-error {
        padding: 10px;
        background-color: #e1808e;
    }
    h3#error-r {
        color: #240202;
    }
</style>
@endsection

@section('content')

    <main id="mt-main">
        <!-- Mt Product Detial of the Page -->
        <section class="mt-product-detial wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="my-alert-success" style="display: none">
                            <h3 id="success"></h3>
                        </div>
                        <div class="my-alert-error" style="display: none">
                            <h3 id="error"></h3>
                        </div>
                        <!-- Slider of the Page -->
                        <div class="slider">
                            <!-- Comment List of the Page -->
                            <ul class="list-unstyled comment-list">

                            </ul>
                            <!-- Comment List of the Page end -->


                            <div class="product-slider slick-initialized slick-slider">
                                <div class="slick-list draggable">
                                    <div style="opacity: 1; width: 2440px;">
                                        @if( !$product->images->isEmpty() )
                                            @foreach($product->images as $i)
                                                <div class="slide slick-slide mySlides" id="slider_{{ $i->id }}">
                                                    <img src="{{ url('public/uploads/'.$i->paths) }}" alt="image descrption" class="img_ht">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="slide slick-slide">
                                                <img src="{{ url('public/imgs/empty.jpg') }}" alt="image descrption">
                                            </div>
                                        @endif
                                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Slider of the Page end -->

                        <!-- Detail Holder of the Page -->
                        <div class="detial-holder">
                            <!-- Breadcrumbs of the Page -->
                            <ul class="list-unstyled breadcrumbs">
                                <li><a href="{{ url('categories') }}">Category<i class="fa fa-angle-right"></i></a></li>
                                <li><a href="{{ url('categories/'.$product->category->slug) }}">{{ $product->category->name }}</a></li>
                            </ul>
                            <!-- Breadcrumbs of the Page end -->
                            <h2>{{ $product->name }} <span id="stock">{{ $product->in_stock == 0 ? 'Out Of Stock' : '' }}</span></h2>
                            <!-- Rank Rating of the Page -->
                            <div class="rank-rating">
                                <ul class="list-unstyled rating-list">
                                    @php $rr1 = round( $average );  @endphp
                                    @for($i = 0; $i < 5; $i++)
                                        @if($rr1 > 0)
                                            <li><i class="fa fa-star"></i></li>
                                        @else
                                            <li><i class="fa fa-star-o"></i></li>
                                        @endif
                                        @php $rr1 = $rr1 - 1;  @endphp
                                    @endfor
                                </ul>
                                <span class="total-price">Reviews ({{ count($reviews) }})</span>
                            </div>
                            <!-- Rank Rating of the Page end -->
                            <ul class="list-unstyled list">
                                @php $wishlist = \Illuminate\Support\Facades\Session::get('wishlist') @endphp
                                @if( isset($wishlist[$product->id]) )
                                    <li><a href="#" id="wishlist"><i class="fa fa-heart" style="color: #FBA421"></i>REMOVE FROM WISHLIST</a></li>
                                @else
                                    <li><a href="#" id="wishlist"><i class="fa fa-heart"></i>ADD TO WISHLIST</a></li>
                                @endif
                            </ul>
                            <div class="txt-wrap">
                                <p>{{ \Illuminate\Support\Str::limit($product->short_description, 150, '.....')  }}</p>
                            </div>
                            <div class="text-holder">
                                @if($product->has_attributes == 1)
                                    <span class="price">$ <span id="price-change">
                                                {{ $product->variation_values->min('price') }} - {{ $product->variation_values->max('price') }}
                                        </span></span>
                                @else
                                    @if($product->sale_price > 0)
                                        <span class="price"> $<span id="price-change">{{ $product->sale_price }} <del>${{ $product->price }}</del></span></span>
                                    @else
                                        <span class="price"> $<span id="price-change">{{ $product->price }}</span></span>
                                    @endif
                                @endif
                            </div>
                            <!-- Product Form of the Page -->
                            <form action="#" class="product-form">
                                @if( !$product->_attributes->isEmpty() )
                                    @foreach($product->_attributes as $a)
                                        <div class="row" style="margin: 0px !important;">
                                            <label for="qty">{{ $a->name }}</label>
                                            <select style="width: 200px;margin-bottom: 10px" onchange="comboCheck(this.value)" id="select_{{ $a->id }}">
                                                <option value="" selected>Please Select</option>
                                                @foreach($a->_options as $o)
                                                    <option value="{{ $o->name }}">{{ $o->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                @endif
                                <fieldset>
                                    <div class="row-val">
                                        <label for="qty">qty</label>
                                        <input type="number" id="qty" placeholder="0" value="">
                                    </div>
                                    <div class="row-val">
{{--                                        <button type="submit" id="cart_btn" disabled>ADD TO CART</button>--}}
                                        <input type="submit" id="cart_btn" value="ADD TO CART" class="cart-btn">
                                    </div>
                                </fieldset>
                            </form>
                            <!-- Product Form of the Page end -->
                        </div>
                        <!-- Detail Holder of the Page end -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Mt Product Detial of the Page end -->

        <div class="product-detail-tab wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="mt-tabs text-uppercase">
                            <li><a href="#tab1" class="active">DESCRIPTION</a></li>
                            <li><a href="#tab2">INFORMATION</a></li>
                            <li><a href="#tab3">REVIEWS ({{ count($reviews) }})</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="active">
                                <p>{{ $product->short_description }}</p>
                            </div>
                            <div id="tab2" class="js-tab-hidden">
                                <p>{{ $product->long_description }}</p>
                            </div>

                            <div id="tab3" class="js-tab-hidden">
                                <div class="product-comment">
                                    @foreach($reviews as $r)
                                        <div class="mt-box">
                                            <div class="mt-hold">
                                                <ul class="mt-star">
                                                    @php $rr = $r->rating;  @endphp
                                                    @for($i = 0; $i < 5; $i++)
                                                        @if($rr > 0)
                                                            <li><i class="fa fa-star"></i></li>
                                                        @else
                                                            <li><i class="fa fa-star-o"></i></li>
                                                        @endif
                                                        @php $rr = $rr - 1;  @endphp
                                                    @endfor
                                                </ul>
                                                <span class="name">{{ $r->user->name }}</span>
                                                <time datetime="2016-01-01">{{ \Carbon\Carbon::parse($r->created_at)->format('H:i M, d Y') }}</time>
                                            </div>
                                            <p>{{ $r->review }}</p>
                                        </div>
                                    @endforeach
                                    @if(Auth::check())
                                        <form action="#" class="p-commentform">
                                            <fieldset>
                                                <h2>Add  Comment</h2>
                                                <div class="mt-row">
                                                    <label>Rating</label>
                                                    <ul class="mt-star">
                                                        <li><i class="fa fa-star rating-star" data-index="0"></i></li>
                                                        <li><i class="fa fa-star rating-star" data-index="1"></i></li>
                                                        <li><i class="fa fa-star rating-star" data-index="2"></i></li>
                                                        <li><i class="fa fa-star rating-star" data-index="3"></i></li>
                                                        <li><i class="fa fa-star rating-star" data-index="4"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="mt-row">
                                                    <label>Review</label>
                                                    <textarea class="form-control" id="txt_review"></textarea>
                                                </div>
                                                <button type="submit" class="btn-type4" id="btn_review">ADD REVIEW</button>
                                            </fieldset>
                                            <div class="r-success" style="display: none">
                                                <h3 id="success-r">vsdf</h3>
                                            </div>
                                            <div class="r-error" style="display: none">
                                                <h3 id="error-r">vsdf</h3>
                                            </div>
                                        </form>
                                    @else
                                        <h3>You need to be logged in to give a review.</h3>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- related products start here -->
    </main>

@endsection

@section('scripts')
    <script src="{{ url('public/js/my-js.js') }}"></script>
<script>
    var ratedIndex = -1;

    function resetStarColors(){
        $('.rating-star').css('color', 'black');
    }

    function setStars(max) {
        for (var i=0; i <= max; i++)
            $('.rating-star:eq('+i+')').css('color', '#E6C376');
    }

    $( document ).ready( function() {

        resetStarColors();

        $('.rating-star').on('click', function () {
            ratedIndex = parseInt($(this).data('index'));
        });

        $('.rating-star').mouseover(function () {
            resetStarColors();
            var currentIndex = parseInt($(this).data('index'));
            setStars(currentIndex);
        });

        $('.rating-star').mouseleave(function () {
            resetStarColors();

            if (ratedIndex != -1)
                setStars(ratedIndex);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#btn_review').click( (e) => {
            e.preventDefault();
            var pid = {!! $product->id !!};
            var txt = $('#txt_review').val();
            if (  txt === '' || ratedIndex === -1){
                alert('Review and rating can not be empty')
                return;
            }
            $.ajax({
                type: "POST",
                url: main_url+"post-review",
                dataType: 'json',
                data: {
                    ratedIndex: ratedIndex,
                    txt:txt,
                    product_id:pid
                },
                success: (data) => {
                    $('#success-r').html('Review added');
                    $('.r-success').show();
                    $('.r-success').fadeOut(3000);
                    setTimeout( () => { location.reload() }, 3000)
                },
                error: (err) => {
                    $('#error-r').html('Some error ocurred');
                    $('.r-error').show();
                    $('.r-error').fadeOut(3000);
                }
            });
        });

        var product = {!! $product !!};
        var $submit = $('#cart_btn');
        if (product.quantity == 0){ $('#cart_btn').attr('disabled','disabled') }
        if (product.in_stock == 0){ $submit.prop('disabled', true); }
        if ($('#qty').val() == 0){ $submit.prop('disabled', true); }

        $('#qty').change( () => {
            var qty = $('#qty').val();
            if (qty == 0){
                $submit.prop('disabled', true);
            }
            else{
                $submit.prop('disabled', false);
            }
        })


        $('#cart_btn').click( (e) => {
            e.preventDefault();
            var price = '';
            var att_op = '';
            if(product.has_attributes == 1){
                var att = {!!  $product->_attributes !!};
                if ( att.length > 0){
                    $.each(att, (i,v) => {
                        if ( $('#select_'+v.id).val() == '' ){
                            price = (product.sale_price > 0) ? product.sale_price : product.price;
                        }else{
                            att_op += $('#select_'+v.id).val()+' ,';
                            price = $('#price-change').text();
                        }
                    })
                }
            }else{
                price = (product.sale_price > 0) ? product.sale_price : product.price;
            }
            var qty = $('#qty').val();
            var productBunch = {
                'id': product.id,
                'qty': qty,
            };
            $.ajax({
                type: 'POST',
                url: main_url+'addToCart',
                dataType: 'JSON',
                data: { id:product.id, qty:qty, price:price, att:att_op },
                success: (data) => {
                    if (data.status == true){
                        $('#success').html(data.msg)
                        $('.my-alert-success').show()
                        $('.my-alert-success').fadeOut(5000)
                        window.location = main_url+'cart';
                    }
                },
                error: (err) => {},
            })
        })

        $('#wishlist').click( (e) => {
            $.ajax({
                type: 'GET',
                url: main_url + 'addToWishlist/'+product.id,
                dataType: 'JSON',
                success: (data) => {
                    if (data.status == true){
                        $('#success').html(data.msg)
                        $('.my-alert-success').show()
                        $('.my-alert-success').fadeOut(5000)
                        location.reload();
                    }
                }
            })
        })
    })

    function comboCheck(e) {
        var prePrice = $('#price-change').html();
        var variations = null;
        var att = null;
        var product = {!! $product !!};
        var variation_values = null;
        if(product.has_attributes == 1){
            att = {!!  $product->_attributes !!}
            variations = {!! $product->variations !!}
            variation_values = {!! $product->variation_values !!}
        }

        var att_val = '';
        if ( att.length > 0){
           $.each(att, (i,v) => {
                att_val +=  '|'+$('#select_'+v.id).val()
           })
        }

        if ( variations.length > 0){
            $.each(variations, (i, v) => {
                if( v.option_name == att_val ){
                    variation_values.map( (e) => {
                        if ( e.combo_id == v.id){
                            var price = (e.sale_price > 0) ? e.sale_price : e.price
                            $('#price-change').html( price )
                        }
                    })
                }
            })
            var newPrice = $('#price-change').html()
            if (prePrice === newPrice){
                var price = (product.sale_price > 0) ? product.sale_price : product.price
                $('#price-change').html( price )
            }
        }

    }


    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex-1].style.display = "block";
    }
</script>
@endsection
