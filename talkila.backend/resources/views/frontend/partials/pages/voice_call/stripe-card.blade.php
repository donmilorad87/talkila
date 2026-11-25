@if (isset($cards_data) && !empty($cards_data))
    @if (isset($cards_data['credit_card']) && !empty($cards_data['credit_card']))
        @foreach ($cards_data['credit_card'] as $card)
            <div class="Setup-payment-wrap fl w-100 card_details_{{ $card['card_id'] }}"
                id="card_details_{{ $card['card_id'] }}"
                data-card-id="{{ $card['card_id'] }}">
                <div class="w-100 df jcsb heading-title-tr fl card_list_first card_list_first_{{ $card['card_id'] }}"
                    data-card-id="{{ $card['card_id'] }}">

                    <div class="df aic">

                        <div class="fl df">
                            @include('frontend.partials.components.card_icon_display', [
                                'cardBrand' => $card['card_brand'],
                            ])
                        </div>

                        <div class="title-bank fl">
                            @if (!empty($card['name']))
                                <p>{{ $card['name'] }}</p>
                            @endif
                            <p class="cNumber">**** **** **** {{ $card['card_last_four_digit'] }}</p>
                            <span>{{ $card['card_month_expire'] . '/' . $card['card_year_expire'] }}</span>
                        </div>

                    </div>


                    <div class="circle-check grid-action defaultCardButton df aic">
                        <div class="card-select card-select_{{ $card['card_id'] }} {{ $card['is_default'] ? 'active' : '' }}"
                            data-card-id="{{ $card['card_id'] }}" data-pointer="stripe">
                            @include('frontend.partials.svg.icons.check-blue')
                        </div>

                    </div>
                </div>

            </div>
        @endforeach
    @endif

    @if (isset($cards_data['paypal']) && !empty($cards_data['paypal']))
        @foreach ($cards_data['paypal'] as $paypal_account)
            <div class="Setup-payment-wrap fl w-100 card_details_{{ $paypal_account['id'] }}"
                id="card_details_{{ $paypal_account['id'] }}" data-card-id="{{ $paypal_account['id'] }}">
                <div class="w-100 df jcsb heading-title-tr h56px fl card_list_first card_list_first_{{ $paypal_account['id'] }}"
                    data-card-id="{{ $paypal_account['id'] }}" data-pointer="paypal">

                    <div class="df aic">
                        <div class="fl df">
                            @include('frontend.partials.svg.icons.paypal')
                        </div>

                        <div class="title-bank fl">
                            <p>{{ $paypal_account['email'] }}</p>
                        </div>
                    </div>

                    <div class="circle-check grid-action defaultCardButton">
                        <div class="card-select card-select_{{ $paypal_account['id'] }} {{ $paypal_account['is_default'] ? 'active' : '' }}"
                            data-card-id="{{ $paypal_account['id'] }}" data-pointer="paypal">
                            @include('frontend.partials.svg.icons.check-blue')
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@else
    <p class="text-center m0 mb16">{{ __('NO_CARDS') }}</p>
@endif
