<div class="quixnav-scroll">
    <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('/admin/home') }}">Home</a></li>
                    <li><a href="{{ route('users.index') }}">Users</a></li>
                </ul>
            </li>
            <li class="nav-label first">Products Menu</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-cart-simple"></i><span class="nav-text">Products</span></a>
                <ul aria-expanded="false">
{{--                    <li><a href="{{ route('attributes.index') }}">Attributes</a></li>--}}
{{--                    <li><a href="{{ route('options.index') }}">Options</a></li>--}}
                    <li><a href="{{ route('brands.index') }}">Brands</a></li>
                    <li><a href="{{ route('categories.index') }}">Categories</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('coupons.index') }}">Coupons</a></li>
                    <li><a href="{{ route('shippings.index') }}">Shipping</a></li>
                </ul>
            </li>
    </ul>
</div>


