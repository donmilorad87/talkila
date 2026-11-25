@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="/frontend/assets/css/app.css?v={{ config('app.version') }}">
    <style>
        .password_reset>div>div.container {
            height: 100%;
            margin: 0px;
            padding: 0px;
            background: white;
            margin: auto;
        }

        .login-img {
            margin-right: 0em;
            margin-top: 0em;
            z-index: 1000;
            width: 145%;
            margin-left: -7em;
            max-width: 150%;
        }
    </style>
    <script defer="" src="/frontend/assets/js/main.js?v={{ config('app.version') }}"></script>
    <script defer="" src="/build/lang/de.js?v={{ config('app.version') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="user_id" content="">
    <meta name="app_language" content="{{ session('language') }}" />
    <meta name="access_token" content="{{ session('access_token') ?: '' }}" />
    <div class="dn" id="app_version">{{ Config::get('app.version') }}</div>
    @include('frontend.partials.components.configuration_parameters')
    <div style="display:none">
        <div id="localizationJson">
            {
            "weekDays":["{{ __('DAY_MONDAY_SHORT') }}", "{{ __('DAY_TUESDAY_SHORT') }}", "{{ __('DAY_WEDNESDAY_SHORT') }}",
            "{{ __('DAY_THURSDAY_SHORT') }}", "{{ __('DAY_FRIDAY_SHORT') }}", "{{ __('DAY_SATURDAY_SHORT') }}",
            "{{ __('DAY_SUNDAY_SHORT') }}"],
            "monthNames":["{{ __('MONTH_JANUARY_LONG') }}", "{{ __('MONTH_FEBRUARY_LONG') }}",
            "{{ __('MONTH_MARCH_LONG') }}", "{{ __('MONTH_APRIL_LONG') }}", "{{ __('MONTH_MAY_LONG') }}",
            "{{ __('MONTH_JUNE_LONG') }}", "{{ __('MONTH_JULY_LONG') }}", "{{ __('MONTH_AUGUST_LONG') }}",
            "{{ __('MONTH_SEPTEMBER_LONG') }}", "{{ __('MONTH_OCTOBER_LONG') }}", "{{ __('MONTH_NOVEMBER_LONG') }}",
            "{{ __('MONTH_DECEMBER_LONG') }}"]
            }
        </div>
    </div>

    <div class="p16mob container grid-x h-100">



        <section class="large-5 bg-grey align-right lleft">
            @include('frontend.partials.components.back-to-home', [
                'back_url' => '/',
                'back_text' => __('BACK'),
            ])
            <div class="login-left">
                <img class="login-img" src="{{ asset('frontend/assets/img/forgot-password.png') }}" alt="user" />
            </div>
        </section>


        <section class="cell large-7 small-order-1 large-order-2 posrelative">
            <div class="authCont">

                <div class="login-right pt16 pb16">
                    <div class="messageForEmail cblack fw600 mb16">

                    </div>
                    <div class="app-popup-right app-popup-pt">
                        <div class="top-bar-left hauto">
                            <a href="/" class="logoSignUpReg">
                                @include('frontend.partials.svg.icons.talkila-logo')
                            </a>
                        </div>
                        <h2 class="loginTitle">{{ __('FORGOT_PASSWORD_HEADLINE_H2') }}</h2>
                        <p class="text-heading-already">{{ __('FORGOT_PASSWORD_TEXT_1') }}


                        <form method="POST" action="{{ route('password.request') }}" id="password_reset_form">

                            @csrf

                            <input name="token" value="{{ $token }}" type="hidden">
                            <div class="grid-x">

                                <div class="medium-12 small-12">
                                    <div class="group">
                                        <input id="email" type="email" name="email"
                                            class="pon form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                            autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                                            value="{{ $email ?? old('email') }}">

                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <div class="medium-12 small-12">
                                    <div class="group">
                                        <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <input class="password-input" id="password" type="password" name="password"
                                            placeholder="{{ trans('global.login_password') }}" required>

                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="password-warn">{{ __('ADD_NEW') }}
                                            {{ __('VALIDATION_PASSWORD_FORMAT') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('NEW_PASSWORD') }}</label>
                                        @include('frontend.partials.components.password-eye')
                                        <div class="validationFields df fww g0dot5rem validationHeight">

                                        </div>
                                    </div>

                                </div>

                                <div class="medium-12 small-12">
                                    <div class="group">
                                        <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <input class="password-input" id="password-confirm" type="password"
                                            name="password_confirmation" required
                                            placeholder="{{ trans('global.login_password_confirmation') }}">


                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                        <label class="password-warn">{{ __('CONFIRM_NEW_PASSWORD_MASSAGE') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('CONFIRM_NEW_PASSWORD') }}</label>
                                        @include('frontend.partials.components.password-eye')
                                        <div class="validationFields df fww g0dot5rem validationHeight">

                                        </div>
                                    </div>

                                </div>

                                <div id="redXIcon" class="dn">
                                    @include('frontend.partials.svg.icons.red-x-icon')
                                </div>
                                <div id="greenCheckmarkIcon" class="dn">
                                    @include('frontend.partials.svg.icons.green-checkmark-icon')
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat"
                                            id="forgotPasswordEdit">
                                            {{ trans('global.reset_password') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </section>



    </div>
@endsection
