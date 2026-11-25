{{-- <script async type="module" src="{{ asset('frontend/assets/js/app.js') }}"></script> --}}
<div class="dn" id="app_version">{{Config::get('app.version')}}</div>

<script src="{{ asset('frontend/assets/js/main.js?v=').Config::get('app.version') }}"></script>
<script src="/build/lang/{{strtolower(app()->getLocale())}}.js?v={{Config::get('app.version') }}"></script>

{{-- @if (Route::current()->getName() == 'video_conference')
    <script type="module" async src="/frontend/assets/js/socket.js?v={{Config::get('app.version') }}"></script>
@endif --}}
