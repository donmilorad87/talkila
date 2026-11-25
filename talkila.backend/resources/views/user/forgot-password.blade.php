@extends('layout.mainlayout-two')

@section('content')
    <!-- Login Area -->
    <div class="auth-main-content auth-bg-image">
        <div class="d-table">
            <div class="d-tablecell">
                <div class="auth-box">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-left-content">
                                <div class="auth-logo">
                                    <img src="{{ asset('assets/images/large-logo.png') }}" alt="Logo">
                                </div>

                                <div class="login-links">
                                    <a class="fb" href="#">
                                        <i data-feather="facebook" class="icon"></i>
                                        {{ __('SIGN_UP_WITH_FACEBOOK') }}
                                    </a>
                                    <a class="twi" href="#">
                                        <i data-feather="twitter" class="icon"></i>
                                        {{ __('SIGN_UP_WITH_TWITTER') }}
                                    </a>
                                    <a class="ema" href="#">
                                        <i data-feather="mail" class="icon"></i>
                                        {{ __('SIGN_UP_WITH_EMAIL') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-content">
                                <h1 class="heading">{{ __('FORGOT_PASSWORD') }}</h1>
                                <form >
                                    <div class="form-group">
                                        <label class="form-label">{{ __('EMAIL') }}</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('RESET_PASSWORD') }}</button>
                                        <a class="fp-link" href="/user/login">{{ __('SIGN_IN') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Login Area -->
@endsection
