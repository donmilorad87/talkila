@if (isset($cards_data) && !empty($cards_data))

  @if (isset($cards_data['credit_card']) && !empty($cards_data['credit_card']))

        @foreach ($cards_data['credit_card'] as $card)
            <div class="Setup-payment-wrap fl w-100">
                <div class="w-100 df jcsb set_default_card {{ $card['is_default'] ? 'pon' : '' }}" data-card-id="{{ $card['card_id'] }}">

                    <div class="df aic">

                        <div class="fl df cardIconHolder">
                            @include('frontend.partials.components.card_icon_display', [
                                'cardBrand' => $card['card_brand'],
                            ])
                        </div>

                        <div class="title-bank fl">
                            <p class="cardHolderName">{{ $card['name'] }}</p>
                            <span class="cNumber df cb aic">
                                <span class="cardDots">**** **** ****</span>
                                <span class="ml3 lastFourNumbers">{{ $card['card_last_four_digit'] }}</span>
                            </span>
                            <span class="df aic">
                                <span class="card_month_expire">{{ $card['card_month_expire'] }}</span>
                                <span>/</span>
                                <span class="card_year_expire">{{ $card['card_year_expire'] }}</span>
                            </span>
                        </div>

                    </div>

                    <div class="circle-check defaultCardButton">
                        <div class="card-select {{ $card['is_default'] ? 'active' : '' }}" data-card-id="{{ $card['card_id'] }}" data-pointer="stripe">
                            @include('frontend.partials.svg.icons.check-blue')
                        </div>
                    </div>

                </div>

                <div class="fr card_list_second">
                    <div class="df mr16 delete_card {{ ($card['is_default'] && $cards_data['count'] > 1) ? 'dn' : '' }}"
                        data-card-id="{{ $card['card_id'] }}">
                        @include('frontend.partials.svg.icons.garbage_can')
                    </div>
                </div>
            </div>
        @endforeach

    @endif


@else
    <p class="noCardsAdded text-center m0">{{ __('NO_CARDS') }}</p>
@endif
