<div class="sidebar" data-color="purple" data-background-color="black" data-image="/assets/img/sidebar-2.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
    <div class="logo">
        <a href="{{route('home.index')}}" class="simple-text logo-normal" target="_blank">
           Awfrlk
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{is_active('home')}}">
                <a class="nav-link" href="{{route('home.index')}}">
                    <i class="material-icons">dashboard</i>
                    <p>@lang('site.home')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('users')}}">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="material-icons">person</i>
                    <p>@lang('site.users')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('categories')}}">
                <a class="nav-link" href="{{route('categories.index')}}">
                    <i class="material-icons">library_books</i>
                    <p>@lang('site.categories')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('products')}}">
                <a class="nav-link" href="{{route('products.index')}}">
                    <i class="material-icons">library_books</i>
                    <p>@lang('site.products')</p>
                </a>
            </li>
            {{-- shico code --}}
            <li class="nav-item {{is_active('offers')}}">
                <a class="nav-link" href="{{route('offers.index')}}">
                    <i class="material-icons">library_books</i>
                    <p>@lang('site.offers')</p>
                </a>
            </li>

            <li class="nav-item {{is_active('areas')}}">
                <a class="nav-link" href="{{route('areas.index')}}">
                    <i class="material-icons">library_books</i>
                    <p>@lang('site.areas')</p>
                </a>
            </li>
            
            <li class="nav-item {{is_active('deliverymotocycles')}}">
                <a class="nav-link" href="{{route('deliverymotocycles.index')}}">
                    <i class="material-icons">library_books</i>
                    <p>@lang('site.deliverymotocycles')</p>
                </a>
            </li>
            <li class="nav-item {{is_active('useroffer')}}">
                <a class="nav-link" href="{{route('useroffers.index')}}">
                    <i class="material-icons">library_books</i>
                    <p>@lang('site.useroffers')</p>
                </a>
            </li>
            <!-- your sidebar here -->
        </ul>
    </div>
</div>