@extends('layout.mainlayout-two')

@section('content')
    <!-- Signup Area -->
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
                                    <a class="linkd" href="#">
                                        <i data-feather="linkedin" class="icon"></i>
                                        {{ __('SIGN_UP_WITH_LINKEDIN') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-content">
                                <h1 class="heading">{{ __('SIGN_UP') }}</h1>
                                <form class="">
                                    <div class="form-group">
                                        <label>{{ __('YOUR_NAME') }}</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('EMAIL') }}</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('PASSWORD') }}</label>
                                        <input type="password" class="form-control" id="password">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('SIGN_UP') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Signup Area -->
@endsection
