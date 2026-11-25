<section class="large-7 posrelative p16mob m0a">
    <div class="authCont df aic jcc" data-verification="1">
        <div class="login-right">

            <div class="top-bar-left hauto">
                <a href="/" class="logoSignUpReg">
                    @include('frontend.partials.svg.icons.talkila-logo')
                </a>
            </div>
            <div id="succesUpload">
                <div class="mobile-verification doc-uploaded text-center" style="position: relative;">
                    @include('frontend.partials.svg.icons.uploaded-ok')
                    <h5 style="z-index: 2;" id="uplText">{{ __('DOCUMENTS_UPLOADED') }}</h5>

                    @include('frontend.partials.svg.icons.talkila-city')
                </div>
            </div>
            <div id="verificationForm">

                <div class="hide-for-large tac">
                    <img src="{{ asset('frontend/assets/img/verify.png') }}" alt="user" style="margin:0 auto" />

                </div>

                <h5 class="tac tal1024 mt16">{{ __('VERIFICATION_YOUR_ACCOUNT') }}</h5>
                <p class="text-heading-already mb16">{{ __('YOUR_NAME_ON_ID_IMAGE') }}</p>

                <form action="method" id="verification-form">

                    <div class="group align-left">
                        <input class="name-input" id="verificationFullName" type="text" name="name"
                            data-name-identifier="1" />
                        <div class="verified-name-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                        <label class="count-label">0/50</label>
                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                        <label class="name-warn">{{ __('VALIDATION_NAME_TWO_WORDS') }}</label>
                        <span class="bar"></span>
                        <label class="input-label">{{ __('YOUR_NAME') }}</label>
                    </div>

                    @include('frontend.partials.components.upload-drop-area', [
                        'id' => '1',
                        'pointer' => $pointer ?? '',
                    ])
                    <small class="w-100 fl">
                        @lang('UPLOAD_ID_INFO_TEXT')
                    </small>
                    <span class="btn fr dn checkImageBeforeUpload" id="checkImageBeforeUploadVerification"
                        data-verification="verificationId">{{ __('SUBMIT_DOCUMENTS') }}</span>

                </form>
            </div>

        </div>
    </div>
</section>
