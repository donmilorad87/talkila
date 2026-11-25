<!doctype html>
<html class="no-js {{ session('language') }}" lang="{{ session('language') }}">

<head>
    @include('frontend.partials.components.head')
</head>

<body
    class="{{ Route::current()->getName() == 'home' && isset(auth()->user()->id) ? 'logged_in' : Route::current()->getName() }}">



    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (\Illuminate\Support\Facades\Session::has('alert-' . $msg))
                <p class="sessionClass alert alert-{{ $msg }}">
                    {{ \Illuminate\Support\Facades\Session::get('alert-' . $msg) }}
                </p>
            @endif
        @endforeach
    </div>

    @include('frontend.partials.components.google_tag_manager_body_top')





    <header>

        @include('frontend.partials.components.header')

        <div>
            @yield('popup_section')

            @include('frontend.partials.components.after_footer_globals')

            @yield('footer_scripts')

            @stack('after-scripts')
        </div>

    </header>

    <main>
        @yield('top_sticky_header')

        @yield('content')

    </main>

    <footer>

        @include('frontend.partials.components.footer')

    </footer>

</body>

</html>
