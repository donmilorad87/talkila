<section class="large-7 posrelative p16mob m0a">
    <div class="authCont df aic jcc">

        <div class="login-right alignVH pt16 pb16">

                <div class="top-bar-left hauto">
                    <a href="/" class="logoSignUpReg">
                        @include('frontend.partials.svg.icons.talkila-logo')
                    </a>
                </div>
                <h2 class="loginTitle">{{ __('FORGOT_PASSWORD_HEADLINE_H2') }}</h2>
                <p class="text-heading-already">{{ __('FORGOT_PASSWORD_TEXT_1') }}
                </p>
                <form method="post" action="{{ route('forgot-password') }}" id="forgot-form">
                    @csrf
                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <div class="medium-12  small-12">
                                <div class="group">
                                    <input class="email-input" type="text" required name="email"
                                        autocomplete="off">
                                    <div class="verified-email-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <label class="email-warn">{{ __('VALIDATION_VALID_EMAIL') }}</label>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('EMAIL') }}</label>

                                </div>
                            </div>
                            <div class="medium-12  small-12">
                                <div> <button id="submit-button" class="btn w-100 mb16" href="#">
                                        {{ __('SEND_LOGIN_LINK') }}
                                    </button>
                                </div>
                            </div>
                            <div class="medium-12  small-12">
                                <div class="or-mange-wrap">
                                    <p class="text-center"> <span>{{ __('OR') }}</span></p>
                                </div>
                            </div>
                            <div class="medium-12 small-12 mb5m">
                                <div class="text-center btn-white">
                                    <a class="hollow btn" href="/account/signup">{{ __('CREATE_NEW_ACCOUNT') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

        </div>
    </div>
</section>
