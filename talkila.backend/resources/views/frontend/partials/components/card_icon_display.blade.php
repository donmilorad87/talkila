@switch(trim($cardBrand))
    @case('visa')
        @include('frontend.partials.svg.icons.visa-square')
    @break

    @case('mastercard')
        @include('frontend.partials.svg.icons.mastercard-square')
    @break

    @case('amex')
        <div class="df americanExpresIcon">
            @include('frontend.partials.svg.icons.american_express')
        </div>
    @break

    @case('Discover')
        <div class="df americanExpresIcon">
            @include('frontend.partials.svg.icons.discover')
        </div>
    @break

    @case('Diners Club')
        <div class="df americanExpresIcon">
            @include('frontend.partials.svg.icons.diners-club')
        </div>
    @break

    @case('UnionPay')
        <div class="df unionPayIcon">
            @include('frontend.partials.svg.icons.union_pay')
        </div>
    @break

    @case('JCB')
        <div class="df unionPayIcon">
            @include('frontend.partials.svg.icons.jcb_pay')
        </div>
    @break

    @case('Cartes Bancaires')
        <div class="df unionPayIcon">
            @include('frontend.partials.svg.icons.cartes-bancaires')
        </div>
    @break

    @case('paypal')
        @include('frontend.partials.svg.icons.paypal')
    @break

    @case('Interac')
        <div class="df interacIcon">
            @include('frontend.partials.svg.icons.interac')
        </div>
    @break
@endswitch
