<!doctype html>
<html lang="en">
<head>
    <title>{{ trans('panel.site_title') }}</title>
    @include('layout.partials.head')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.18.1/adyen.css"
          integrity="sha384-5K4T5NNVv7ZBvNypROEUSjvOL45HszUg/eYfYadY82UF4b+hc+TPQ4SsfTGXufJp"
          crossorigin="anonymous">
    <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
</head>

<body>
<!-- Preloader -->
@include('layout.partials.loader')

<!-- Top Navbar -->
@include('layout.partials.top-nav')

<!-- Side Menu -->
@include('layout.partials.sidemenu')

<!-- Main Content Wrapper -->
<div class="main-content d-flex flex-column">
    <!--Global flash messages -->
@include('layout.partials.flash-message')

<!-- Main Content Layout -->
@yield('content')

<!-- Footer -->
    @include('layout.partials.footer')
</div>
<!-- End Main Content Wrapper -->
<!-- Footer Scripts -->
@include('layout.partials.footer-scripts')
@yield('footer_scripts')

@yield('scripts')
@stack('after-scripts')
</body>
</html>
