<section class="cell large-7 small-order-1 large-order-2 posrelative">
    <div class="authCont">

        <div class="login-right pt16 pb16">
            <div class="messageForEmail cblack fw600 mb16">

            </div>
            <div class="app-popup-right app-popup-pt">
                <div class="top-bar-left">
                    <a href="/" class="logoSignUpReg">
                        @include('frontend.partials.svg.icons.talkila-logo')
                    </a>
                </div>

                <h2 class="loginTitle">{{ __('WELCOME_BACK') }}</h2>
                <p class="text-heading-already">{{ __('DONT_HAVE_ACCOUNT') }}
                    <a href="{{ route('signup') }}">{{ __('SIGN_UP') }}</a></p>


                <form id="login-form">
                    @csrf
                    <input type="hidden" id="timezoneOffset">
                    <div class="grid-x grid-padding-x">
                        <div class="medium-12 small-12">
                            <div>
                                <a class="btn redbutton df jcc aic w-100" href="{{ url('auth/google') }}{{isset($decodedCookie) ? '?partner_id='. $decodedCookie->pratnerData->id . '&partner_email='. $decodedCookie->requestParams->te : ''}}">
                                    <p class="df aic jcc m0">
                                        @include('frontend.partials.svg.icons.google-white')
                                        <span class="buttonText">
                                            {{ __('LOGIN_WITH') }} Google
                                        </span>
                                    </p>
                                </a>
                            </div>
                        </div>

                        <div class="medium-12  small-12">
                            <div>
                                <a class="btn blue df jcc aic w-100 mt16 mb16" href="{{ url('auth/facebook') }}{{isset($decodedCookie) ? '?partner_id='. $decodedCookie->pratnerData->id . '&partner_email='. $decodedCookie->requestParams->te : ''}}">
                                    <p class="df aic jcc m0">
                                        @include('frontend.partials.svg.icons.facebook-white')
                                        <span class="buttonText">
                                            {{ __('LOGIN_WITH') }} Facebook
                                        </span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="medium-12  small-12 orReg">
                            <div class="or-mange-wrap">
                                <p class="text-center"><span>{{ __('OR') }}</span></p>
                            </div>
                        </div>
                        <div class="medium-12 small-12">
                            <div class="group">
                                <input class="email-input" type="text" name="email"
                                    @if (session()->has('user_email'))
                                        value="{{session()->get('user_email')}}"
                                    @endif required />
                                <div class="verified-email-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                <button type="button" class="clear-button" tabindex="-1">✖</button>
                                <label class="email-warn">{{ __('VALIDATION_VALID_EMAIL') }}</label>
                                <span class="bar"></span>
                                <label class="input-label">{{ __('EMAIL') }}</label>
                            </div>
                        </div>
                        <div class="medium-12 small-12">
                            <div class="group">
                                <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                <input class="password-input" type="password" name="password" required {{--autocomplete="off"--}} />
                                <button type="button" class="clear-button" tabindex="-1">✖</button>
                                <label class="count-label">0/50</label>
                                <label class="password-warn">{{ __('VALIDATION_PASSWORD_FORMAT') }}</label>
                                <span class="bar"></span>
                                <label class="input-label">{{ __('PASSWORD') }}</label>
                                @include('frontend.partials.components.password-eye')
                                <div class="validationFields df fww g0dot5rem validationHeight">

                                </div>
                                <div id="redXIcon" class="dn">
                                    @include('frontend.partials.svg.icons.red-x-icon')
                                </div>
                                <div id="greenCheckmarkIcon" class="dn">
                                    @include('frontend.partials.svg.icons.green-checkmark-icon')
                                </div>
                            </div>
                            <a href="{{ route('forgot_password') }}" class="fpass noselect cblack">{{ __('FORGOT_PASSWORD') }}?</a>
                        </div>


                        <div class="medium-12  small-12">

                            <div>
                                <button id="loginSubmit" class="btn w-100 mb16 db">{{ __('SIGN_IN') }} </button>
                            </div>

                        </div>
                        <div class="medium-12 small-12 gta">
                            <div class="or-mange-wrap">
                                <p class="text-center"><span>{{ __('GET_THE_APP') }}</span></p>
                            </div>
                        </div>
                    </div>
                    @include('frontend.partials.components.app_icons')
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    let timezoneInput = document.querySelector('#timezoneOffset');
    let timezone      = new Date().getTimezoneOffset();
    let socialLinks   = document.querySelectorAll('a[href*="auth"]');

    timezoneInput.value = timezone * -1;

    for (let i = 0; i < socialLinks.length; i++) {
        socialLinks[i].href += '?timezone_offset=' + timezone * -1;
    }
</script>
