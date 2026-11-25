@switch(trim($cardBrand))
    @case('visa')
        @include('frontend.partials.svg.icons.visa-th')
        @break
    @case('mastercard')
        @include('frontend.partials.svg.icons.mastercard')
        @break
    @case('amex')
        @include('frontend.partials.svg.icons.american_expressTh')
        @break
    @case('Discover')
        <div class="americanExpresIcon">
            @include('frontend.partials.svg.icons.discover')
        </div>
        @break
    @case('Diners Club')
        <div class="americanExpresIcon">
            @include('frontend.partials.svg.icons.diners-club')
        </div>
        @break
    @case('UnionPay')
        <div class="unionPayIcon">
            @include('frontend.partials.svg.icons.union_pay')
        </div>
        @break
    @case('JCB')
        <div class="unionPayIcon">
            @include('frontend.partials.svg.icons.jcb_pay')
        </div>
        @break
    @case('Cartes Bancaires')
    <div class="unionPayIcon">
        @include('frontend.partials.svg.icons.cartes-bancaires')
    </div>
        @break
    @case('Interac')
        <div class="interacIcon">
            @include('frontend.partials.svg.icons.interac')
        </div>
        @break

@endswitch
