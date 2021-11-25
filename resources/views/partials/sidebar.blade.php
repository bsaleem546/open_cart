<div class="quixnav-scroll">
    <ul class="metismenu" id="menu">
        @if(Auth::user()->role == 'ADMIN')
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
                        class="icon icon-single-04"></i><span class="nav-text">Products</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('brands.index') }}">Brands</a></li>
                    <li><a href="{{ route('categories.index') }}">Categories</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>


