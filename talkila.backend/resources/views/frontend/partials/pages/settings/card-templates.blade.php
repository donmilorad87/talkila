
<template id="cardItemTemplate">
    <div class="Setup-payment-wrap fl w-100">
        <div class="w-100 df jcsb set_default_card pon" data-card-id="">

            <div class="df aic">

                <div class="fl df cardIconHolder">

                </div>

                <div class="title-bank fl">
                    <p class="cardHolderName"></p>
                    <span class="cNumber df cb aic"><span class="cardDots">**** **** ****</span><span class="ml3 lastFourNumbers"></span></span>
                    <span class="df aic"><span class="card_month_expire"></span><span>/</span><span class="card_year_expire"></span></span>
                </div>

            </div>


            <div class="circle-check defaultCardButton">
                <div class="card-select active" data-card-id="" data-pointer="stripe">
                    @include('frontend.partials.svg.icons.check-blue')
                </div>
            </div>
        </div>

        <div class="fr card_list_second">
            <div class="df mr16 delete_card dn" data-card-id="">
                @include('frontend.partials.svg.icons.garbage_can')
            </div>
        </div>
    </div>
</template>

<template id="visaCard">
    @include('frontend.partials.svg.icons.visa-square')
</template>

<template id="mastercardCard">
    @include('frontend.partials.svg.icons.mastercard-square')
</template>

<template id="amexCard">
    <div class="df americanExpresIcon">
        @include('frontend.partials.svg.icons.american_express')
    </div>
</template>

<template id="discoverCard">
    <div class="df americanExpresIcon">
        @include('frontend.partials.svg.icons.discover')
    </div>
</template>

<template id="dinersClubCard">
    <div class="df americanExpresIcon">
        @include('frontend.partials.svg.icons.diners-club')
    </div>
</template>

<template id="unionPayCard">
    <div class="df unionPayIcon">
        @include('frontend.partials.svg.icons.union_pay')
    </div>
</template>

<template id="JCBCard">
    <div class="df unionPayIcon">
        @include('frontend.partials.svg.icons.jcb_pay')
    </div>
</template>

<template id="cartesBancairesCard">
    <div class="df unionPayIcon">
        @include('frontend.partials.svg.icons.cartes-bancaires')
    </div>
</template>

<template id="paypalCard">
    @include('frontend.partials.svg.icons.paypal')
</template>

<template id="interacCard">
    <div class="df interacIcon">
        @include('frontend.partials.svg.icons.interac')
    </div>
</template>
