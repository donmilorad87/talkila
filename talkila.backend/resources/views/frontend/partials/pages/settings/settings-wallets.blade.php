<div class="dn" id="loggedId">{{ $user->id }}</div>
<div class="setting-page white-box">
    {{-- <h1 class="page-title">{{ __('SETTINGS') }}</h1> --}}
    <div class="setting-inner">
        <div class="grid-x w-100">
            <div class='cell medium-12 pl16 pr16'>
                <div class="setting-tabs">
                    @include('frontend.partials.components.settings-menu', [
                        'pointer' => __('WALLET'),
                    ])
                    <div class="tabs-content">
                        <div class="tabs-panel is-active" id="Profile">
                            <div class="grid-x">
                                <div class="setting-inner small-12">
                                    <div class="form-wrapper">
                                        <h6 class="mb8">{{ __('YOUR_WALLET_BALANCE') }}
                                            <span class="available_balance">
                                                {{ priceFormater($user->wallet_balance, true) }}
                                            </span>
                                            <input type="hidden" value="{{$user->wallet_balance}}" name="user_wallet_balance" id="user_wallet_balance">
                                        </h6>

                                        <p class="mb25">{{ __('WALLET_DESCRIPTION_TEXT') }}</p>
                                    </div>
                                    {{-- @if (isset($user_cards['data']) && !empty($user_cards['data'])) --}}
                                    <button class="btn cp addCoinsToWalletPage w200px"
                                        data-popup="addCoinsPopUp">{{ __('ADD_COINS_TO_WALLET') }}</button>
                                    {{-- @endif --}}
                                </div>
                            </div>

                            <div class="fl oi card-list pt16">
                                @include('frontend.partials.pages.settings.stripe-card-with-delete')
                                @include('frontend.partials.pages.settings.card-templates')
                            </div>

                            <div class="fl mt0 mb16 mr16 w-100">

                                <button class="btn w200px creditCardReset">
                                    {{ __('ADD_NEW_CARD') }}
                                </button>

                            </div>
                            {{-- <div class="fl mt16 mb16 w-100">

                                <a href="{{ route('add_paypal_account') }}" class="btn w200px">
                                    {{ __('ADD_NEW_PAYPAL') }}
                                </a>

                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
