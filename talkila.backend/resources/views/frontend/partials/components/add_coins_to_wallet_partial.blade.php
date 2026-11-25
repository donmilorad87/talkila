<h5 class="df jcc">{{ __('ADD_MONEY_TO_WALLET') }}</h5>
<div class="box-payment bb1 mt32">
    @lang('TOTAL') @lang('AMOUNT')
    <small class="text-right df aib g2px jcc">
        <span class="text-right fs22">{{ $amount }}</span>
        €
    </small>
</div>
<input type="hidden" name="online_amount" id="online_amount" value="{{ $amount }}">
<input type="hidden" name="payment_type" id="payment_type" value="1">
<div class="choose-payment-box w-100">

    <ul class="tabs d-flex m0 w-100 mb8" id="paymentTabsUl">

        <li class="tabs-title is-active calculateHeighter">
            <button id="stripeerButton" class="w-100">
                @include('frontend.partials.svg.icons.credit-card-yellow')
                <p class="m0">@lang('CREDIT_CARD')</p>

            </button>
        </li>
        <li class="tabs-title calculateHeighter">
            <button id="paypalerButton" class="w-100 h-100">
                @include('frontend.partials.svg.icons.paypal-color')
                <p class="m0">{{ __('PAYPAL') }}</p>
            </button>
        </li>
    </ul>

    <div class="bwhite fl w-100 tabs-content p0" id="payStripeConts">

        <div class="tabs-panel is-active mt0" id="stripeerCont">
            <div class="stripe_cards_without_delete fl">
                @include('frontend.partials.pages.settings.stripe-card-with-delete')

            </div>

            <div class="cell small-12 fl df g1rem">
                <div class="add-slot creditCardReset mt0">
                    @include('frontend.partials.svg.icons.add-time-slot') {{ __('ADD_NEW_CARD') }}
                </div>

            </div>


            <div class="grid-x fl w-100 @if (empty($cards_data)) dn @endif" id="walletStripeButtonCont">
                <div class="small-12 text-center">
                    <button class="btn mt16" type="button" name="pay_via_stripe" id="pay_via_stripe_cachsier">
                        {{ __('PAY_USING_STRIPE') }}
                    </button>
                </div>
            </div>


        </div>

        <div class="tabs-panel dn mt0" id="paypalerCont">

            <div id="paypalCheckoutContainer"></div>
        </div>
    </div>

</div>
