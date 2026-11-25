<div class="setting-page white-box p16mob">

    <div class="setting-tabs">
        <div class="show-for-medium">
            @include('frontend.partials.components.settings-menu', [
                'pointer' => __('PAYOUT'),
            ])
        </div>
    </div>

    <div class="grid-x aic mb16">
        <div class="small-12 medium-6 tac mb16res">

            <h4 class="payoutTotalEarnings dib">
                {{ number_format($totalEarnings, 2) }}
                <span class="valuteSignPayout">€</span>
            </h4>

            <p>
                {{ __('YOUR_INCOME') }}
            </p>

            <button class="btn w-60 cp m0a mb80res lh24" data-popup="chosePaymentMethodPopup">
                {{ __('CHOOSE_PAYOUT_METHOD') }}
            </button>

        </div>

        <div class="small-12 medium-6 tac">
            <div class="paymentItemsContainer">
                <div class="df aic paymentItemsPaymentPage cpPayment" data-popup="payoutPopup"
                     data-payout="currentEarnings">
                    <div class="iconBox greenDivPayout pen">
                        @include('frontend.partials.svg.icons.bank-yellow')
                    </div>

                    <div class="tal pen">
                        <p class="m0 dateTextPayout">@lang('CURRENT_EARNINGS')</p>
                        <p class="m0 stateOfPaymentPayout"></p>
                    </div>

                    <div class="pricePayment pricePaymentGreen mla pen">
                        {{ $current_earnings }} €
                    </div>
                </div>
                @foreach ($payouts as $payout)

                    <div class="df aic paymentItemsPaymentPage cpPayment" data-popup="payoutPopup"
                        data-payout="{{ $payout->id }}">
                        <div class="iconBox greenDivPayout pen">
                            @include('frontend.partials.svg.icons.green_payout')
                        </div>

                        <div class="tal pen">
                            <p class="m0 dateTextPayout">
                                {{ Carbon\Carbon::parse($payout->payout_date)->format('F Y') }}
                            </p>
                            <p class="m0 stateOfPaymentPayout">@lang('PENDING')</p>
                        </div>

                        <div class="pricePayment pricePaymentGreen mla pen">
                            {{ number_format($payout->price, 2) }} €
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>




</div>
