<div class="mHeader">
    <div class="container m0auto">

        <div class="logoCont">
            <a class="logoLink" href="/">@include('frontend.partials.svg.icons.favicon')</a>
            <h1 class="page-title m0">{{ $page_name ?? 'Talkila' }}
            </h1>
        </div>
            <div class="menuIconCont">
                <span class="menuIcon" data-is-open="0">
                    <div></div>
                </span>
            </div>
            @include('frontend.partials.components.header-language', ['class' => 'dn'])
            <ul class="deskUl">
                <li><a href="{{route('login-user')}}">{{ __('SIGN_IN') }}</a></li>
                <li><a href="{{route('signup')}}">{{ __('SING_UP') }}</a></li>


            </ul>
            <nav class="mobileNav">
                <div class="mobileNavLogo">
                    <a href="{{ route('home') }}">
                        @include('frontend.partials.svg.icons.favicon')
                    </a>

                </div>
                <ul>
                    <li><a href="{{route('login-user')}}">{{ __('SIGN_IN') }}</a></li>
                    <li><a href="{{route('signup')}}">{{ __('SING_UP') }}</a></li>

                </ul>
            </nav>

    </div>
</div>
