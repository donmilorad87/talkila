<div class="choose-payment-box mt16 w-100 pt0">

    <div class="billingDropdown">
        <div class="df aic jcsb">
            <div>
                <b class="cblack">
                    {{-- @lang('BILLING_FOR_COUNTRY') --}}
                </b>
            </div>
            <div class="df g1rem pencilOpener" data-opened="0">
                <div id="countryNameBilling">
                    @if (isset($userAccounting) && !empty($userAccounting))
                        @foreach ($countries as $country)
                            @if ($country['id'] === $userAccounting['countries_id'])
                                {{ $country['country'] }}
                            @endif
                        @endforeach
                    @else
                        {{ $countries[20]['value'] }}
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
                <!-- <a class="hollow button" href="#">Finish Setup</a> <a href="/logged-in" class="btn ">Complete</a>-->
                <button class="btn warning fr submit-button mb16">@lang('UPDATE_BILLING_ADDRESS')</button>
            </div>
            <hr>
        </div>


    </div>



    <div class="fl w-100">

        <div class="box-payment active">
            <div class="box-payment__header">
                {{ __('TOTAL_COST') }}

                <small class="text-right">
                    <span data-price="{{ $bookingObj['bookingPrice'] }}" id="bookingStringPrace">
                        {{ priceFormater($bookingObj['bookingPrice']) }}</span>
                </small>
            </div>

            @if ($teacher['pays_vat'])
                <div class="box-payment__header">
                    {{ __('TOTAL_COST_BASE') }}
                    <small class="text-right">
                        <span id="bookingBase">
                            {{ priceFormater($bookingObj['bookingPrice'] - ($bookingObj['bookingPrice'] * (optional($user->vat)->toArray()['vat_value'])) / 100) }}</span>

                    </small>
                </div>

                <div class="box-payment__header">
                    <span>{{ __('VAT') }} (<span
                            id="bookingVATPercentage">{{ optional($user->vat)->toArray()['vat_value'] }}</span>%)</span>
                    <small class="text-right">
                        <span id="bookingVAT">
                            {{ priceFormater(($bookingObj['bookingPrice'] * (optional($user->vat)->toArray()['vat_value'])) / 100) }}</span>
                    </small>
                </div>
            @endif
        </div>
    </div>
    @if (!($user->wallet_balance >= $bookingObj['bookingPrice'] || $user->wallet_balance == 0))
        <div class="wallet_balance_section {{ $user->wallet_balance == 0 ? ' dn' : '' }}">
            <div class="d-flex Setup-payment-wrap">
                <div class="heading-title-tr d-flex w-100">
                    <div class="talkilaCoin"> @include('frontend.partials.svg.icons.favicon-ico-2') </div>
                    <h6 class="m0 w-100 df jcsb">

                        <span class="greenInfo"> {{ priceFormater($user->wallet_balance) }} @lang('AVAILABLE_COINS')</span>
                        @lang('WE_WILL_USE') @lang('TALKILA_COINS_BOOKING')
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
    @endif

    @if (!($user->wallet_balance >= $bookingObj['bookingPrice']))
        @if (!$threeDSuccessPointer)
            <ul class="tabs d-flex m0 mb16 w-100" id="paymentTabsUl">

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
                <div class="col-12 tabs-panel is-active" id="stripeerCont">
                    <div id="ccContainerBookingFunnel" class="stripe_cards_without_delete dzen peregarder">
                        @include('frontend.partials.pages.settings.stripe-card-with-delete')
                        @include('frontend.partials.pages.settings.card-templates')
                    </div>


                    <div class="cell small-12 large-12 df g1rem dzen">
                        <div class="warning expanded add-slot mb16 creditCardReset">

                            @include('frontend.partials.svg.icons.add-time-slot')
                            {{ __('ADD_NEW_CARD') }}
                        </div>

                        {{-- <a href="{{ route('add_paypal_account') }}" class="warning expanded add-slot mb16">

                            @include('frontend.partials.svg.icons.add-time-slot')
                            {{ __('ADD') . ' ' . __('PAYPAL') }}

                        </a> --}}

                    </div>


                </div>

                <div class="col-12 tabs-panel dn" id="paypalerCont">
                    <div class="">
                        @if (floatVal($bookingObj['bookingPrice']) - floatVal($user->wallet_balance) > 0)
                            <p class="tac mb24">{{ __('PAY_VIA_PAYPAL') }}:
                                <span class="online_amount cblack fw600" id="paypalAmount">
                                    {{ priceFormater(floatval($bookingObj['bookingPrice']) - floatval($user->wallet_balance)) }}
                                </span>
                                <input type="hidden" id="paypalAmountReal" value="{{floatval($bookingObj['bookingPrice']) - floatval($user->wallet_balance)}}">
                            </p>
                        @else
                            <input type="hidden" id="paypalAmountReal" value="{{floatval($bookingObj['bookingPrice'])}}">
                        @endif

                        <div id="paypalCheckoutContainer" class="payButton aic jcc df"></div>

                    </div>
                </div>

            </div>

        @endif

    @endif



    <form method="post" class="">
        <input type="hidden" name="talk_id" id="talk_id" value="{{ $bookingObj['id'] }}">
        <input type="hidden" name="teacher_id" id="teacher_id" value="{{ $teacher_id }}">
        <input type="hidden" name="booking_date_time" id="booking_date_time"
            value="{{ $bookingObj['bookingDateTime'] }}">
        <input type="hidden" name="anonym" id="anonym" value="{{ $bookingObj['anonymousMeeting'] }}">
        <input type="hidden" name="booking_amount" id="booking_amount" value="{{ $bookingObj['bookingPrice'] }}">
        <input type="hidden" name="available_balance" id="available_balance" value="{{ $user->wallet_balance }}">
        <input type="hidden" name="payment_type" id="payment_type" value="0">
        <input type="hidden" name="online_amount" id="online_amount" value="{{ $bookingObj['bookingPrice'] }}">

        <input type="hidden" id="shouldShowPayPalAndStripe"
            value={{ floatVal($bookingObj['bookingPrice']) <= floatVal($user->wallet_balance) ? 0 : 1 }}>

        <h6 class="dn">{{ __('YOUR_WALLET_BALANCE') }}
            <?= $user->wallet_balance ?>
        </h6>

        @if (!$threeDSuccessPointer)
            <div class="fl w-100 mb16 text-right payButton">

                @if (floatVal($bookingObj['bookingPrice']) <= floatVal($user->wallet_balance))

                    <button type="button" id="add_wallet_booking_cachier" class="btn h42 w-100"
                        data-payment="paymentTalkila">
                        <span class="online_amount"></span>
                        {{ __('PROCEED_TO_PAYMENT') }}
                    </button>
                @elseif (floatVal($bookingObj['bookingPrice']) > floatVal($user->wallet_balance) && $cards_data['count'] === 0)

                    <button type="button" id="add_wallet_booking_cachier" class="btn h42 w-100 dn">

                        {{ __('DEPOSIT_IN_WALLET') }} (
                        <span
                            class="online_amount">{{ priceFormater(floatVal($bookingObj['bookingPrice']) - floatVal($user->wallet_balance)) }}</span>)
                        &
                        {{ __('PROCEED_TO_PAYMENT') }}

                    </button>

                @elseif (floatVal($bookingObj['bookingPrice']) - floatVal($user->wallet_balance) > 0 && $cards_data['count']>0)

                    <button type="button" id="add_wallet_booking_cachier" class="btn h42 w-100">

                        {{ __('DEPOSIT_IN_WALLET') }} (
                        <span
                            class="online_amount">{{ priceFormater(floatVal($bookingObj['bookingPrice']) - floatVal($user->wallet_balance)) }}</span>)
                        &
                        {{ __('PROCEED_TO_PAYMENT') }}

                    </button>

                @endif
            </div>
        @endif

        <div class="w-100 tac mt16 termsandconditons">
            <p class="tac">{{ __('CALENDAR_CONFIRM_TEXT') }}
                <a href="/legal/terms-and-conditions" target="_blank">{{ __('TERMS_AND_CONDITIONS') }}
                </a> @lang('AND')
                <a href="/legal/privacy-policy" target="_blank">{{ __('FOOTER_LINK_PRIVACY_POLICE') }}.</a>
            </p>
        </div>

    </form>


</div>
