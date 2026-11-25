<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

@if (config('app.top_server') || Route::current()->getName() === 'legal_pages')
    <meta name="robots" content="noindex,nofollow" />
@endif

<link rel="shortcut icon" href="{{ asset('frontend/assets/img/favicon.ico') }}">
<title>

    @if (Route::current()->getName() === 'profile')
        {{ $userData['name'] }} - {{ $userData['username'] }}
    @else
        {{ trans('panel.site_title') }} @yield('title')
    @endif
</title>

@if (Route::current()->getName() === 'profile')
    @yield('title')

    <meta property="og:title" content="{{ $userData['name'] }} - {{ $userData['username'] }}" />
    <meta property="og:image"
        content="{{ $userData['profile_picture'] ?? 'https://api.talkila.top/assets/images/avatar.svg' }}" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    <meta property="og:image:alt" content="{{ $userData['name'] }}" />
    <meta property="og:type" content="website" />
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
    <meta property="og:description" content="{{ $userData['description'] ?? $userData['username'] }}" />
    <meta property="og:url" content="{{ config('app.appUrl') }}/{{ $userData['username'] }}" />
    <meta property="og:locale" content="{{ session('language') }}" />
    <meta property="og:site_name" content="{{ trans('panel.site_title') }}" />
@endif

@if ($isApple['isIOSDevice'])<meta name="apple-itunes-app" content="app-id={{ config('app.ios_store_app_id') }}@if (isset($requestParams) && isset($pratnerData)) , app-argument={{ config('app.appUrl') }}/f/{{ isset($pratnerData) ? (isset($pratnerData->slug) ? $pratnerData->slug : '') : '' }}?te={{ $requestParams->te }}{{ isset($requestParams->tu) ? '&tu=' . $requestParams->tu : '' }}{{ isset($requestParams->td) ? '&td=' . $requestParams->td : '' }}{{ isset($requestParams->ti) ? '&ti=' . $requestParams->ti : '' }}@endif">@endif
<link rel="stylesheet" href="{{ asset('frontend/assets/css/app.css?v=') . Config::get('app.version') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="app_language" content="{{ session('language') }}" />
<meta name="access_token" content="{{ session('access_token') ?: '' }}" />
<meta name="user_id" content="{{ $user->id ?? '' }}" />

@if ($user)
    @if ($user->jtc && $user->jtc?->state !== 1)
        @if ( $user->partner)
            <meta name="partner_id" content="{{  $user->partner->id ?? '0' }}" />
            <meta name="jtc_progress"
                content="{{ '{"step1":"' . ($user->jtc?->step_1 ?? '0') . '","step2":"' . ($user->jtc?->step_2 ?? '0') . '", "step3":"' . ($user->jtc?->step_3 ?? '0') . '","step4":"' . ($user->jtc?->step_4 ?? '0') . '"}' }}" />
        @endif
    @endif

@endif


{{-- <script

  src="https://browser.sentry-cdn.com/6.11.0/bundle.tracing.min.js"
  integrity="sha384-XuDodOP4mgLWA8eRlqZJWs+mtmznHF6ES/nOotK0fE7SHjj0Ec3YMVIzjh5ytsKH"
  crossorigin="anonymous"
></script>

<script>
  Sentry.onLoad(function() {


   });

   Sentry.init({
        dsn: "https://583cffb9147143dda42cf9791ef53ed5@o541567.ingest.sentry.io/5913878",
        maxBreadcrumbs: 100,
        integrations: [new Sentry.Integrations.Breadcrumbs({ console: false })],
        debug: false,
        release: "talkila-we@1.0",
    });

</script> --}}

@include('frontend.partials.components.head-scripts')

@if (isset($_COOKIE['allow_cookies']) && !empty($_COOKIE['allow_cookies']))

    @php
        $cookieObject = json_decode($_COOKIE['allow_cookies'], true);
    @endphp

    @if (isset($cookieObject['cookieConsentManager']))
        {{--    <script>
            console.log('cookieConsentManager enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['stripeSDK']))
        {{--  <script>
            console.log('stripeSDK enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['payPalSDK']))
        {{--    <script>
            console.log('payPalSDK enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['bingAds']))
        {{--    <script>
            console.log('bingAds enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['googleAds']))
        {{--   <script>
            console.log('googleAds enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['googleDoubleClick']))
        {{--   <script>
            console.log('googleDoubleClick enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['googleTagManager']))
        {{-- <script>
            console.log('googleTagManager enabled');
        </script> --}}
        @include('frontend.partials.components.google_tag_manager_head')
    @endif

    @if (isset($cookieObject['googleAnalytics']))
        {{-- <script>
            console.log('googleAnalytics enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['hotjarBehaviorAnalyrics']))
        {{-- <script>
            console.log('hotjarBehaviorAnalyrics enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['googleReCaptcha']))
        {{-- <script>
            console.log('googleReCaptcha enabled');
        </script> --}}
    @endif

    @if (isset($cookieObject['googleFonts']))
        {{--       <script>
            console.log('googleFonts enabled');
        </script> --}}
    @endif

@endif
