@switch($payment_type)
    @case(0)
        @include('frontend.partials.svg.icons.credit_card')
    @break

    @case(1)
        @include('frontend.partials.svg.icons.paypal_TH')
    @break

    @case(2)
        @include('frontend.partials.svg.icons.coins')
    @break

    @case(3)
        @include('frontend.partials.svg.icons.credit_card')
    @break

    @case(4)
        @include('frontend.partials.svg.icons.paypal_TH')
    @break

    @case(5)
        @include('frontend.partials.svg.icons.credit_card_coins')
    @break

    @case(6)
        @include('frontend.partials.svg.icons.paypal_coins')
    @break

    @case(7)
        @include('frontend.partials.svg.icons.refund_coins')
    @break

    @case(8)
        @include('frontend.partials.svg.icons.refund_money')
    @break

@endswitch
