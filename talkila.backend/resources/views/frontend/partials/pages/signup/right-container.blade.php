<div class="large-7 posrelative p16mob m0a">
    <div class="authCont df aic jcc">

        <div class="login-right pt16 pb16">

                <div class="top-bar-left hauto">
                    <a href="/" class="logoSignUpReg">
                        @include('frontend.partials.svg.icons.talkila-logo')
                    </a>
                </div>
                <h2 class="loginTitle">{{ __('WELCOME_TO_TALKILA') }}</h2>
                <p class="text-heading-already">{{ __('ALREADY_HAVE_ACCOUNT') }}
                    <a href="{{ route('login') }}">{{ __('GO_TO_LOGIN') }}</a>
                </p>

                <form {{-- method="POST" --}} {{-- action="{{ route('user-register') }}" --}} id="signup-form">
                    @csrf
					<input type="hidden" id="timezoneOffset">
                    <div class="grid-x grid-padding-x">
                        <div class="medium-12 small-12">
                            <div>
                                <a class="btn redbutton df jcc aic w-100" href="{{ url('auth/google') }}" >
                                    <p class="df aic jcc m0">
                                        @include('frontend.partials.svg.icons.google-white')
                                        <span class="buttonText">{{ __('SIGN_UP_WITH_GOOGLE') }}</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="medium-12  small-12">
                            <div>
                                <a class="btn blue df jcc aic w-100 mt16 mb16" href="{{ url('auth/facebook') }}" >
                                    <p class="df aic jcc m0">

                                        @include('frontend.partials.svg.icons.facebook-white')
                                        <span class="buttonText">
                                            {{ __('SIGN_UP_WITH_FACEBOOK') }}
                                        </span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="medium-12  small-12 orReg">
                            <div class="or-mange-wrap">
                                <p class="text-center"> <span>{{ __('OR') }}</span></p>
                            </div>
                        </div>
                        <div class="small-12">
                            <div class="group">
                                <input class="name-input" type="text" name="name" required autocomplete="off"/>
                                <div class="verified-name-svg">@include('frontend.partials.svg.icons.check-verified')</div>
								<label class="count-label">0/50</label>
                                <button type="button" class="clear-button" tabindex="-1">✖</button>
                                <label class="name-warn">{{ __('VALIDATION_NAME_TWO_WORDS') }}</label>
                                <span class="bar"></span>
                                <label class="input-label">{{ __('YOUR_NAME') }}</label>
                            </div>
                        </div>
                        <div class="medium-12  small-12">
                            <div class="group">
                                <input class="email-input" type="text" name="email" required autocomplete="off"/>
                                <div class="verified-email-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                <button type="button" class="clear-button" tabindex="-1">✖</button>
                                <label class="email-warn">{{ __('VALIDATION_VALID_EMAIL') }}</label>
                                <span class="bar"></span>
                                <label class="input-label">{{ __('EMAIL') }}</label>
                            </div>
                        </div>
                        <div class="medium-12  small-12">
                            <div class="group">
                                <input class="password-input" type="password" name="password" required autocomplete="off"/>
                                <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                <button type="button" class="clear-button" tabindex="-1">✖</button>
								<label class="count-label">0/50</label>
                                <label class="password-warn">{{ __('WRONG_PASSWORD_FORMAT') }}</label>
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
                        </div>
                        <div class="small-12">


                            <div>
                                @if (
                                    config('services.google.recaptcha_sitekey')
                                )


                                <button
                                id="submit-button"
                                class="g-recaptcha btn w-100 mb16"
                                href="#"

                                data-sitekey="{{config('services.google.recaptcha_sitekey')}}"
                                data-callback='onSubmit'
                                data-action='submit'

                                >{{ __('CRATE_ACCOUNT') }}</button>
                                @else
                                <button
                                id="submit-button"
                                class="btn w-100 mb16"


                                >{{ __('CRATE_ACCOUNT') }}</button>
                                @endif

                            </div>
                        </div>
                        <div class="small-12 mb16">
                            <div class="check-filed-wrap">
                                <div class="checkbox-inner align-items-none">
                                    <input id="checkbox1" class="df aic jcc" type="checkbox">
                                    <label for="checkbox1">{{ __('NOTICE_CONFIRMATION_WITH_TERMS_PART_1') }}
                                        <a href="/legal/terms-and-conditions" target="_blank"> {{ __('TERMS_AND_CONDITIONS') }} </a> {{ __('NOTICE_CONFIRMATION_WITH_TERMS_PART_2') }}r <a href="/legal/privacy-policy" target="_blank"> {{ __('FOOTER_LINK_PRIVACY_POLICE') }} </a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="small-12 gta">
                            <div class="or-mange-wrap">
                                <p class="text-center"> <span>{{ __('GET_THE_APP') }} </span></p>
                            </div>
                        </div>
                    </div>
                    @include('frontend.partials.components.app_icons')
                </form>

        </div>
    </div>
</div>

<script>

    let timezoneInput = document.querySelector('#timezoneOffset');
    let timezone      = new Date().getTimezoneOffset();
    let socialLinks   = document.querySelectorAll('a[href*="auth"]');

    timezoneInput.value = timezone * -1;

    for (let i = 0; i < socialLinks.length; i++) {
        socialLinks[i].href += '?timezone_offset=' + timezone * -1;
    }

</script>
