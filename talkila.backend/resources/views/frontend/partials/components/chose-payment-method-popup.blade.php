<div class="popupBase" id="chosePaymentMethodPopup" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-x mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => 'Payout method',
                'page_back_link' => '/jtc/welcome',
                'save_button' => '1',
                'step_progress_text' => 'Step 3 of 5',
                'back_popup' => 'chosePaymentMethodPopup',
                'saveButtonText' => 'payoutMethodsubmitButton',
            ])

            <div class="small-12">

                <div class="step-heading-wrap">
                    <h6>{{ __('WHERE_SHOULD_WE') }} {{ __('TRANSFER_YOUR_MONEY') }}</h6>
                    <br>
                    <div class="Setup-payment-wrap bankTansferStuff"
                        @if (!empty($userPayoutMethods['iban'])) data-opened="1" style="height: 240px" @else data-opened="0" style="height: 82px;" @endif>
                        <div class="d-flex mb16 bankTansferStuffInner">
                            <div class="heading-title-tr d-flex">
                                @include('frontend.partials.svg.icons.bank-square')
                                <div class="title-bank">
                                    <p>{{ __('BANK_TRANSFER') }}</p>

                                </div>
                            </div>
                            <div class="circle-check">
                                @include('frontend.partials.svg.icons.check-blue')
                            </div>
                        </div>


                        <form class="step4Form mobileStep4Form"
                            @if (!empty($userPayoutMethods['iban'])) style="height: 144px" @else style="height: 0px;" @endif>
                            <div id="token">
                                @csrf
                            </div>
                            <div class="grid-x">
                                <div class="medium-12  small-12">
                                    <div class="group">
                                        <input
                                            class="password-input  {{ !empty($userPayoutMethods['iban']) ? 'ok' : '' }}"
                                            type="text" name="iban" required autocomplete="off"
                                            @if (!empty($userPayoutMethods['iban'])) value="{{ $userPayoutMethods['iban'] }}" @endif />
                                        <div
                                            class="verified-password-svg {{ !empty($userPayoutMethods['iban']) ? 'active' : '' }}">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="password-warn">{{ __('VALIDATION_WRONG_IBAN_FORMAT') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">IBAN</label>
                                    </div>
                                </div>

                                <div class="small-12">
                                    <div class="group">
                                        <input
                                            class="name-input  {{ !empty($userPayoutMethods['iban_recipient']) ? 'ok' : '' }}"
                                            type="text" name="name" required autocomplete="off"
                                            value="{{ $userPayoutMethods['iban_recipient'] ?? $loggedUserData['name'] }}" />
                                        <div
                                            class="verified-name-svg {{ !empty($userPayoutMethods['iban_recipient']) ? 'active' : '' }}">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="name-warn">{{ __('VALIDATION_NAME_TWO_WORDS') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('ACCOUNT_HOLDER') }}</label>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                    <div class="Setup-payment-wrap">


                        <div class="Profession-input pay-pal-input-holder">
                            <div class="pay-pal-holder">

                                <span id='paypal-button-container2'></span>
                            </div>
                        </div>

                    </div>
                </div>
                <br>



            </div>

        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
