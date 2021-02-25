<div class="sidebar" @if (app()->getLocale() == 'ar') style="right = 0;" @endif data-color="purple"
    data-background-color="black" data-image="/assets/img/sidebar-2.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag 
-->
    <div class="logo">
        <a href="{{route('home.index')}}" class="simple-text logo-normal" target="_blank">
            @lang('site.awfrlk')
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('home.index')}}">
                    <i class="material-icons">dashboard</i>
                    <p>@lang('site.home')</p>
                </a>
            </li>
            <li class="nav-item {{ (request()->group == 'emp' ? 'active' :(request()->group == null ? is_active('users') : ''))}}">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="material-icons">person</i>
                    <p>@lang('site.users')</p>
                </a>
            </li>

            <li class="nav-item {{( request()->group == 'user' ? 'active' : is_active('showUser'))}}">
                <a class="nav-link" href="{{route('users.usersShow')}}">
                    <i class="material-icons">person</i>
                    <p>@lang('site.usersShow')</p>
                </a>
            </li>

            <li class="nav-item {{ request()->group == 'delivery' ? 'active' : is_active('showDelivey')}}">
                <a class="nav-link" href="{{route('users.delivery')}}">
                    <i class="material-icons">person</i>
                    <p>@lang('site.delivery')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('usersalaries')}}">
                <a class="nav-link" href="{{route('usersalaries.index')}}">
                    <i class="material-icons">shop</i>
                    <p>@lang('site.usersalaries')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('blacklist')}}">
                <a class="nav-link" href="{{route('users.showblacklist')}}">
                    <i class="material-icons">person</i>
                    <p>@lang('site.black_list')</p>
                </a>
            </li>
            
            <li class="nav-item {{is_active('categories')}}">
                <a class="nav-link" href="{{route('categories.index')}}">
                    <i class="material-icons">category</i>
                    <p>@lang('site.categories')</p>
                </a>
            </li>
            
            <li class="nav-item {{is_active('products')}}">
                <a class="nav-link" href="{{route('products.index')}}">
                    <i class="material-icons">cake</i>
                    <p>@lang('site.products')</p>
                </a>
            </li>
            {{-- shico code --}}
            <li class="nav-item {{is_active('offers')}}">
                <a class="nav-link" href="{{route('offers.index')}}">
                    <i class="material-icons">local_offer</i>
                    <p>@lang('site.offers')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('areas')}}">
                <a class="nav-link" href="{{route('areas.index', ['parent' => 0])}}">
                    <i class="material-icons">location_on</i>
                    <p>@lang('site.areas')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('deliverymotocycles')}}">
                <a class="nav-link" href="{{route('deliverymotocycles.index')}}">
                    <i class="material-icons">two_wheeler</i>
                    <p>@lang('site.deliverymotocycles')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('useroffers')}}">
                <a class="nav-link" href="{{route('useroffers.index')}}">
                    <i class="material-icons">redeem</i>
                    <p>@lang('site.useroffers')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('orders')}}">
                <a class="nav-link" href="{{route('orders.index')}}">
                    <i class="material-icons">shop</i>
                    <p>@lang('site.orders')</p>
                </a>
            </li>
            <!-- <li class="nav-item {{is_active('orderdetails')}}">
                <a class="nav-link" href="{{route('orderdetails.index')}}">
                    <i class="material-icons">shopping_cart</i>
                    <p>@lang('site.orderdetails')</p>
                </a>
            </li> -->
            <li class="nav-item {{is_active('promocodes')}}">
                <a class="nav-link" href="{{route('promocodes.index')}}">
                    <i class="material-icons">gift</i>
                    <p>@lang('site.promocodes')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('advances')}}">
                <a class="nav-link" href="{{route('advances.index')}}">
                    <i class="material-icons">money</i>
                    <p>@lang('site.advances')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('sliders')}}">
                <a class="nav-link" href="{{route('sliders.index')}}">
                    <i class="material-icons">picture</i>
                    <p>@lang('site.sliders')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('showReport') .' ' . is_active('showmoney')}}">
                <a class="nav-link" href="{{route('advances.counts')}}">
                    <i class="material-icons">gift</i>
                    <p>@lang('site.counts')</p>
                </a>
            </li>
            
            <li class="nav-item {{is_active('analysis') .' ' . is_active('analysis')}}">
                <a class="nav-link" href="{{route('analysis')}}">
                    <i class="material-icons">gift</i>
                    <p>@lang('site.counts')</p>
                </a>
            </li>
            <!-- your sidebar here -->
        </ul>
    </div>
</div>
