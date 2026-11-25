@if (isset($_COOKIE['allow_cookies']) && !empty($_COOKIE['allow_cookies']) && $_COOKIE['allow_cookies'] == true)
    @include('frontend.partials.components.google_tag_manager')
@endif
