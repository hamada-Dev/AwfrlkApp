<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">{{$nav_title}}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            @yield('search')
            <ul class="navbar-nav">
                {{--language dropdown--}}
                <li class="nav-item dropdown show">
                    <a class="nav-link" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="material-icons" style="font-size: 18px">power_settings_new</i>
                        <p class="d-lg-none d-md-block">
                            power_settings_new
                        </p>
                        <div class="ripple-container"></div></a>
                    <div class="dropdown-menu  @if (app()->getLocale() == 'ar') dropdown-menu-left @else dropdown-menu-right @endif  " aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" style="font-size: 16px" rel="alternate" hreflang="" href="{{route('logout')}}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                @lang('site.logout')
                            </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>

                {{--language dropdown--}}
                <li class="nav-item dropdown show">
                    <a class="nav-link" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="material-icons" style="font-size: 16px">language</i>
                        <p class="d-lg-none d-md-block">
                            @lang('language')
                        </p>
                        <div class="ripple-container"></div></a>
                    <div class="dropdown-menu @if (app()->getLocale() == 'ar') dropdown-menu-left @else dropdown-menu-right @endif " aria-labelledby="navbarDropdownMenuLink">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="dropdown-item" style="font-size: 16px" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                        @endforeach
                    </div>
                </li>
                {{$slot}}
                <!-- your navbar here -->
            </ul>
        </div>
    </div>
</nav>
