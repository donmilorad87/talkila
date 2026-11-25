@extends('layouts.app')
@section('content')

    <style>
        .affiliate__tabs {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 0;
        }

        .affiliate__tab {
            display: block;
            text-align: center;
            width: 50%;
            outline: 1px solid;
        }

        .affiliate__tab p {
            margin: 0;
            padding: 10px;
        }

        .affiliate__forms {
            display: none;
        }

        .affiliate__forms.is-open {
            display: block;
        }

        .logoSignUpReg svg {
            width: 220px;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    {{--                <h1>{{ trans('panel.site_title') }}</h1>--}}
                    <p class="text-center logoSignUpReg">
                        {{--                        <img src="{{ asset('/assets/images/talkila-logo.png') }}" alt="Logo" class="large-logo">--}}
                        @include('frontend.partials.svg.icons.talkila-logo')
                    </p>

                    @if (session('alert-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('alert-success') }}</strong>
                        </div>
                    @endif

                    @if(session('alert-danger'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('alert-danger') }}</strong>
                        </div>
                    @endif

                    <ul class="affiliate__tabs">
                        <li class="affiliate__tab">
                            <p class="text-muted" data-tab="login">{{ trans('global.login') }}</p>
                        </li>
                        <li class="affiliate__tab">
                            <p class="text-muted" data-tab="register">{{ trans('global.register') }}</p>
                        </li>
                    </ul>

                    @if(session('message'))
                        <div class="alert alert-info" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" class="affiliate__forms is-open" data-tab="login"
                          action="{{ route('affiliate.login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                            </div>

                            <input id="email" name="email" type="text"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                   autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                                   value="{{ old('email', null) }}">

                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>

                            <input id="password" name="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                                   placeholder="{{ trans('global.login_password') }}">

                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-4">
                            <div class="form-check checkbox">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember"
                                       style="vertical-align: middle;"/>
                                <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                    {{ trans('global.remember_me') }}
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ trans('global.login') }}
                                </button>
                                <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>

                            </div>
                            <div class="col-6 text-right">
                                @if(Route::has('password.request'))
                                    <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        {{ trans('global.forgot_password') }}
                                    </a><br>
                                @endif
                                <a class="btn btn-link px-0" href="{{ route('register') }}">
                                    {{ trans('global.register') }}
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <h3 class="text-center"> Social Login</h3>
                                <a href="/login/facebook" class="mr-2">
                                    <i class="fab fa-facebook-square fa-2x"></i>
                                </a>
                                <a href="/login/google">
                                    <i class="fab fa-google fa-2x"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                    <form method="POST" class="affiliate__forms" data-tab="register"
                          action="{{ route('affiliate.register') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                            </div>
                            <input type="text" name="name"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required
                                   autofocus placeholder="{{ trans('global.user_name') }}"
                                   value="{{ old('name', null) }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope fa-fw"></i>
                            </span>
                            </div>
                            <input type="email" name="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                   placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                            </div>
                            <input type="password" name="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                                   placeholder="{{ trans('global.login_password') }}">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control" required
                                   placeholder="{{ trans('global.login_password_confirmation') }}">
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ trans('global.register') }}
                                </button>
                                <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>

                            </div>
                            <div class="col-6 text-right">
                                @if(Route::has('password.request'))
                                    <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        {{ trans('global.forgot_password') }}
                                    </a><br>
                                @endif
                                <a class="btn btn-link px-0" href="{{ route('register') }}">
                                    {{ trans('global.register') }}
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <h3 class="text-center"> Social Login</h3>
                                <a href="/login/facebook" class="mr-2">
                                    <i class="fab fa-facebook-square fa-2x"></i>
                                </a>
                                <a href="/login/google">
                                    <i class="fab fa-google fa-2x"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let tabLinks = document.querySelectorAll('.affiliate__tabs p');
        let tabs = document.querySelectorAll('.affiliate__forms');

        for (let i = 0; i < tabLinks.length; i++) {
            tabLinks[i].addEventListener('click', changeTab.bind(event, tabLinks[i].getAttribute('data-tab')));
        }

        function changeTab(tab) {
            for (let i = 0; i < tabs.length; i++) {
                if (tabs[i].getAttribute('data-tab') === tab) {
                    tabs[i].classList.add('is-open');
                } else {
                    tabs[i].classList.remove('is-open');
                }
            }
        }

    </script>
@endsection

{{--@section('scripts')--}}
{{--    <script>--}}
{{--        function onSignIn(googleUser) {--}}
{{--            // Useful data for your client-side scripts:--}}
{{--            var profile = googleUser.getBasicProfile();--}}
{{--            console.log("ID: " + profile.getId()); // Don't send this directly to your server!--}}
{{--            console.log('Full Name: ' + profile.getName());--}}
{{--            console.log('Given Name: ' + profile.getGivenName());--}}
{{--            console.log('Family Name: ' + profile.getFamilyName());--}}
{{--            console.log("Image URL: " + profile.getImageUrl());--}}
{{--            console.log("Email: " + profile.getEmail());--}}

{{--            // The ID token you need to pass to your backend:--}}
{{--            var id_token = googleUser.getAuthResponse().id_token;--}}
{{--            console.log("ID Token: " + id_token);--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
