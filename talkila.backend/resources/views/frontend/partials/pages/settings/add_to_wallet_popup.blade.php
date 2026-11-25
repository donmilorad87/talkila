<div class="popupBase" id="addCoinsPopUp" data-opened="0">
    <div class="popuper ppR" tabindex="0">
        <div class="credit-model">
            <h5 class="text-center mb16">{{ __('ADD_MONEY_TO_WALLET') }}</h5>
            <p>{{ __('ADD_MONEY_TO_WALLET_DESCRIPTION')}}</p>
            <div id="addCoinsToWalletForm" class="mt32" tabindex="0">
                <div class="grid-x">


                    <div class="cell medium-12 small-12 large-12">
                        <div class="group">

                            <input class="default-input"
                                   id="coins"
                                   type="number"
                                   name="coins"
                                   {{-- placeholder="Input amount of coinst to add to your wallet" --}}
                                   min="1"
                                   required
                                   autocomplete="off"

                            />
                            <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                            <button type="button" class="clear-button" tabindex="-1">✖</button>

                            <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                            <span class="bar"></span>
                            <label class="input-label">@lang('ADD_COINS')</label>
                        </div>

                    </div>


                </div>
                <div class="grid-x">
                    <div class="small-12 text-center">
                        <div class="btn" id="add_coins" tabindex="0">{{ __('ADD_COINS') }}</div>
                    </div>
                </div>
            </div>

        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
