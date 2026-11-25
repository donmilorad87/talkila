@guest
    @include('frontend.partials.components.cookie-notice')
@endguest

@auth
    @if (Route::current()->getName() !== 'video_conference')
        @include('frontend.partials.components.call-popup')
    @endif

    @include('frontend.partials.pages.settings.permissions_popup')
@endauth
@if (Route::current()->getName() !== 'booking')
    @include('frontend.partials.pages.video_conference.loading-popup')
@endif


@include('frontend.partials.components.scroll-to-top')

@include('frontend.partials.components.configuration_parameters')
