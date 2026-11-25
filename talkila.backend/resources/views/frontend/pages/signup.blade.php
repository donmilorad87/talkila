@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="p16mob grid-x container h-100">
        @if (config('services.google.recaptcha_sitekey'))
            <input type="hidden" name="reCapatchaInputero" id="reCapatchaInputero" value="{{config('services.google.recaptcha_sitekey') ? true : false}}">
            <script src="https://www.google.com/recaptcha/api.js"></script>
        @endif
        @include('frontend.partials.pages.signup.left-container')
        @include('frontend.partials.pages.signup.right-container')
    </div>

@endsection
