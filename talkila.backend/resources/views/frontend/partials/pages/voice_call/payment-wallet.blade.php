<div class="popupBase cancelExtend" id="paymentWalletPopUp">
    <div class="popuper ppBbb">

        <div class="credit-model talkilium">
            <div class="phoneTopLine"></div>


            <div class="d-flex step steperko caki CVHeading">
                <span class="closerIngP cancelExtend">
                    @include('frontend.partials.svg.icons.arrow-left')
                </span>

                <div class="tac fw">{{__('BILLING_INFORMATION') }}</div>

            </div>
            <div class="billingDropdown mt48res">
                <div class="df aic jcsb">
                    <div>
                        <b class="cblack">
                            @lang('BILLING_FOR_COUNTRY')
                        </b>
                    </div>
                    <div class="df g1rem pencilOpener" data-opened="0">
                        <div id="countryNameBilling">
                            @if (isset($userAccounting) && !empty($userAccounting))
                                @foreach ($countries as $country)
                                    @if ($country['id'] === $userAccounting['countries_id'])
                                        {{$country['country']}}
                                    @endif
                                @endforeach
                            @else
                                {{$countries[20]['value']}}
                            @endif
                        </div>
                        <div class="pencilBilling">
                            @include('frontend.partials.svg.icons.pencil')
                        </div>
                    </div>

                </div>

                <div class="billingDropdownForm hiddenForm">
                    <div cllass="df fdc aic jcfs">
                        <div class="df aic mt16">


                            <h5 class="m0">
                                @lang('ADD') @lang('BILLING_ADDRESS')
                            </h5>
                        </div>
                        @include('frontend.partials.pages.jtc.billing-informations')

                    </div>
                    <hr>

                    <div class="cell text-right">

                        <button class="btn warning fr submit-button mb16">@lang('UPDATE_BILLING_ADDRESS')</button>
                    </div>
                    <hr>
                </div>


            </div>
            <div class="fl w-100 mb16">
                <div id="errorMessageVideoTalk" class="dn" style="color:red">

                </div>
                <div class="fl w-100 df aic jcsb bb1 pb4">
                    <p class="headBolder m0 fs14">{{ __('TALK_DURATION_EXTENDION') }}</p>

                    <div>
                        <p class="headBolder m0 tar fs13 lh16 dn"><span id="nameOfTalkForPaymentExtension"></span></p>
                        <p class="headBolder m0 tar fs13 lh16 dn"><span id="nameOfTeacherForPaymentExtension"></span></p>
                        <p class="m0 tar fs12 lh16"> <span class="extend_call_time"></span> {{ __('MINUTES') }}</p>
                    </div>
                </div>

                <div class="fl w-100 df aic jcsb pt4" style="flex-wrap: wrap">
                    <div class="w-100 df aic jcsb mb4">
                        <p class="headBolder m0 fs14">{{ __('TOTAL') }}</p>
                        <div>
                            <p class="headBolder m0 tar fs13"> <span class="extend_call_price"></span> €</p>
                        </div>
                    </div>
                    @if (optional($booking)->pays_vat)
                        <div class="w-100 df aic jcsb mb4">
                            <p class="headBolder m0 fs14">{{ __('BASE_PRICE') }}</p>
                            <div>
                                <p class="headBolder m0 tar fs13"> <span
                                        class="">{{ $booking->price - ($booking->price * $booking->vat_value) / 100 }}</span>
                                    €</p>
                            </div>
                        </div>
                        <div class="w-100 df aic jcsb mb4">
                            <p class="headBolder m0 fs14">{{ __('VAT') }} ({{ $booking->vat_value }}%)</p>
                            <div>
                                <p class="headBolder m0 tar fs13">
                                    <span class="">{{ ($booking->price * $booking->vat_value) / 100 }}</span> €
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <h5 class="add-time-title text-center line-height dn">@lang('YOUR_WALLET_BALANCE')
                <span class="wallet_balance" id="upperBallance">
                    {{ $user->wallet_balance }}
                </span> €</h5>




            <div class="wallet_balance_section fl w-100 peregarder{{ $user->wallet_balance <= 0 ? ' dn' : '' }}">
                <div class="d-flex Setup-payment-wrap w-100 {{ $user->wallet_balance == 0 ? ' dn' : '' }}">
                    <div class="heading-title-tr d-flex w-100">
                        <div class="talkilaCoin"> @include('frontend.partials.svg.icons.favicon-ico-2') </div>
                        <h6 class="m0  w-100 df jcsb">
                            @if (isset($user->wallet_balance))
                                <span class="greenInfo" data-real-price={{$user->wallet_balance}}> {{ priceFormater((float) $user->wallet_balance) }} @lang('AVAILABLE_COINS')</span>
                                @lang('WE_WILL_USE') {{ priceFormater((float) $user->wallet_balance) }}
                            @endif
                        </h6>
                        <label id="walletCheck" class="custom-checkbox dn" data-checked="1">
                            <div class="airporten chch checkBoxPayment" data-checked-checkbox="0">
                                <div class="beforeCheck backgroundCheckedCheck"></div>
                                <div class="afterCheck checkedCheck"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <h5 class="tac w-100 fl peregarder mb16res"> {{ __('PAYMENT_METHODS') }}</h5>
            <ul class="tabs df m0 mb16 w-100 jcc aic peregarder" id="paymentTabsUl">
                <li class="tabs-title is-active calculateHeighter">
                    <button id="stripeerButton" class="w-100">
                        @include('frontend.partials.svg.icons.credit-card-yellow')
                        <p>@lang('CREDIT_CARD')</p>
                    </button>
                </li>
                <li class="tabs-title calculateHeighter">
                    <button id="paypalerButton" class="w-100 h-100">
                        @include('frontend.partials.svg.icons.paypal-color')
                        <p>{{ __('PAYPAL') }}</p>
                    </button>
                </li>
            </ul>

            <div class="tl-pt-wrap fl w-100 tabs-content cardsF" id="payStripeConts">
                {{-- STRIPE PAYMENT SECTION START --}}
                <div class="col-12 tabs-panel is-active " id="stripeerCont">
                    <div id="ccContainerBookingFunnel" class="stripe_cards_without_delete dzen peregarder">
                        @include('frontend.partials.pages.settings.stripe-card-with-delete')
                        @include('frontend.partials.pages.settings.card-templates')
                    </div>


                    <div class="cell small-12 fl mountingNewCard peregarder peregarder2 df g1rem">
                        <span class="add-slot mb16 creditCardReset">
                            @include('frontend.partials.svg.icons.add-time-slot') {{ __('ADD_NEW_CARD') }}
                        </span>



                    </div>

                    <div class="w-100 tac">
                        <button class="btn mt16 w-100s lh24" type="button" name="pay_via_stripe" id="pay_via_stripe_cachsier">

                            {{ __('PAY_USING_STRIPE') }}

                            <span class="pl4" id="payAmountStripeVideoExtend">

                            </span>

                        </button>
                    </div>

                </div>
                <div class="col-12 tabs-panel test dn" id="paypalerCont">
                    <p class="df aic jcc fw600 cblack">@lang('PAY_VIA_PAYPAL') : <span class="online_payment_amount" id="paypalVideoExtendViewAmount"></span>
                        €</p>

                    <div id="paypalCheckoutContainer"></div>
                </div>
            </div>
            <div class="medium-12 large-12 small-12 cell text-center">
                <input type="hidden" name="online_payment_amount" id="online_payment_amount" value="">
            </div>
        </div>
    </div>
</div>
</div>
@include('frontend.partials.pages.settings.cardpopup')
<input type="hidden" name="vat_id" id="vat_id" value="{{ $user->id }}">
