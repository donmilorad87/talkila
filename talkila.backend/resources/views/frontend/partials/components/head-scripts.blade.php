<script defer src="{{ asset('frontend/assets/js/main.js?v=').Config::get('app.version') }}"></script>
<script defer src="/build/lang/{{strtolower(app()->getLocale())}}.js?v={{Config::get('app.version') }}"></script>

{{-- @if (Route::current()->getName() == 'video_conference')
    <script type="module" async src="/frontend/assets/js/socket.js?v={{Config::get('app.version') }}"></script>
@endif --}}
