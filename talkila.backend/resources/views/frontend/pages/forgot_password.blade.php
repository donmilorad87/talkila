@extends('frontend.layouts.frontendlayout')

@section('content')

        <div class="p16mob grid-x container h-100">
            @include('frontend.partials.pages.forgot_password.left-container')
            @include('frontend.partials.pages.forgot_password.right-container')
        </div>

@endsection
