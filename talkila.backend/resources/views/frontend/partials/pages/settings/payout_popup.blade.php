<div class="popupBase" id="payoutPopup" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

        <div class="step-heading-wrap mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => 'Payout May 2022',
                'page_back_link' => '',
                'save_button' => '0',
                'step_progress_text' => 'Step 3 of 5',
                'back_popup' => 'payoutPopup',
                'saveButtonText' => 'saveButtonText',
            ])

            <div class="m16 payoutPopupMethod oh">
                <div class="payoutPopupMethodTop">
                    <p class="payoutPopupMethodTotal">
                        €450.00
                    </p>
                    <p class="payoutPopupMethodTotalSub">
                        2 @lang('TALKS') / 2hr 45min
                    </p>
                </div>
                <div class="p1rem">
                    <p class="payoutPopupBoldText">
                        @lang('MONEY_SUCCESFULLY_TRANSFERED') 25.02.2022 14:21
                    </p>
                    <hr>
                    <div>
                        <div class="df aic jcsb">
                            <p class="payoutPopupTableGrayText m0">
                                @lang('PAYOUT_MTHODS')
                            </p>
                            <p class="payoutTableBlackText iban m0">
                                DE40******************
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="df aic jcsb">
                            <p class="payoutPopupTableGrayText m0">
                                @lang('NAME')
                            </p>
                            <p class="payoutTableBlackText name m0">
                                Max Mustermann
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="df aic jcsb">
                            <p class="payoutPopupTableGrayText m0">
                                Invoice-Nr
                            </p>
                            <p class="payoutTableBlackText m0">
                                1484-2356-123
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="df aic jcsb">
                            <p class="payoutPopupTableGrayText m0">
                                Transaction-ID
                            </p>
                            <p class="payoutTableBlackText m0">
                                156546
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="paymentItemsContainer mt42">
                <div class="df aic jcsb m06 paymentItemsPaymentPopup">
                    <div>
                        <p class="payoutTableBlackText fw600 tal m0">
                            English for Beginner
                        </p>
                        <p class="m0 stateOfPaymentPayout">
                            16.11.2022 15:00 - 15:30
                        </p>
                    </div>
                    <div>
                        <div class="pricePayment pricePaymentGreen mla">
                            43,21 €
                        </div>
                    </div>
                </div>
                <div class="df aic jcsb m06 paymentItemsPaymentPopup">
                    <div>
                        <p class="payoutTableBlackText fw600 tal m0">
                            English for Beginner
                        </p>
                        <p class="m0 stateOfPaymentPayout">
                            16.11.2022 15:00 - 15:30 (@lang('CANCELLED'))
                        </p>
                    </div>
                    <div>
                        <div class="pricePayment pricePaymentGreen mla">
                            0 €
                        </div>
                    </div>
                </div>
                <div class="df aic jcsb m06 paymentItemsPaymentPopup">
                    <div>
                        <p class="payoutTableBlackText fw600 tal m0">
                            English for Beginner
                        </p>
                        <p class="m0 stateOfPaymentPayout">
                            16.11.2022 15:30 - 15:45 (@lang('EXTENDION'))
                        </p>
                    </div>
                    <div>
                        <div class="pricePayment pricePaymentGreen mla">
                            15,04 €
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 tac">
                <button class="btn">
                    @lang('GET_SUMMARY_VIA_EMAIL')
                </button>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
