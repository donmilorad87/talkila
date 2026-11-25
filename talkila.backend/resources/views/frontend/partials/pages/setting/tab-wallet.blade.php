<div class="grid-x">
    <div class="medium-12 large-10">
        <div class="setting-inner">
            <div class="form-wrapper">
                <h6>{{ __('PROFILE_SETTINGS') }}</h6>
                <p>{{ __('JTC_STEP_1') }}</p>
            </div>
        </div>
        <div class="credit-card-wrapper">
            <div class="credit-card" data-open="exampleModal2" aria-controls="exampleModal2" aria-haspopup="true"
                tabindex="0">
                @include('frontend.partials.svg.icons.visa')
                <p>{{ __('CREDIT_CARD') }} **** 5489</p>
            </div>
            <div class="credit-card" data-open="exampleModal2" aria-controls="exampleModal2" aria-haspopup="true"
                tabindex="0">
                @include('frontend.partials.svg.icons.master-card')
                <p>{{ __('CREDIT_CARD') }} **** 4488</p>
            </div>
            <div class="credit-card" data-open="exampleModal2" aria-controls="exampleModal2" aria-haspopup="true"
                tabindex="0">
                @include('frontend.partials.svg.icons.paypal-color')
                <p>helentran@paypal.com</p>
            </div>
        </div>
    </div>
    <div class="small-12 medium-12 large-2">
        <a class="btn expanded btn-custom cp" data-popup="cardPopUp" href="#cardPopUp">{{ __('ADD_NEW') }}</a>
    </div>
</div>
