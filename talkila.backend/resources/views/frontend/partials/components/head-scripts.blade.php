{{-- The Sentry SDK (head.blade.php) is disabled, but the frontend reports errors with Sentry.captureException() in
     ~190 places. Without this fallback every such call throws "Sentry is not defined" and hides the real error.
     It logs to the browser console instead; loading a real Sentry SDK first takes precedence over it. --}}
<script>
    window.Sentry = window.Sentry || {
        captureException: function (error) { console.error('[captured]', error); },
        captureMessage: function (message) { console.warn('[captured]', message); },
    };
</script>
<script defer src="{{ asset('frontend/assets/js/main.js?v=').Config::get('app.version') }}"></script>
<script defer src="/build/lang/{{strtolower(app()->getLocale())}}.js?v={{Config::get('app.version') }}"></script>

{{-- @if (Route::current()->getName() == 'video_conference')
    <script type="module" async src="/frontend/assets/js/socket.js?v={{Config::get('app.version') }}"></script>
@endif --}}
