<section class="p16">
    <div class="inner-box-book fl w-100">
        <h6 class="heading-title-book">{{ __('PROFILE_WITH') }} Talkila </h6>
        <div class="benefit-item">
            <div class="icon-sn book-sn-icon shadow">
                @include('frontend.partials.svg.icons.shield-check')
            </div>
            <div class="heading-slider ">
                <h6>{{ __('PROFILE_SAFE_PAYMENT') }}</h6>
                <div class="social-box">
                    <ul>
                        <li>{{ __('PROFILE_SAFE_PAYMENT_TEXT') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="benefit-item">
            <div class="icon-sn book-sn-icon shadow">
                @include('frontend.partials.svg.icons.calendar-check')
            </div>
            <div class="heading-slider ">
                <h6>{{ __('PROFILE_WE_PROFILE_YOUR_TIMESLOT') }}</h6>
                <div class="social-box">
                    <ul>
                        <li>{{ __('PROFILE_WE_PROFILE_YOUR_TIMESLOT_TEXT') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="benefit-item">
            <div class="icon-sn book-sn-icon shadow">
                @include('frontend.partials.svg.icons.phone-call')
            </div>
            <div class="heading-slider ">
                <h6>{{ __('PROFILE_TALK_WITH_TALKILA') }}</h6>
                <div class="social-box">
                    <ul>
                        <li>{{ __('PROFILE_TALK_WITH_TALKILA_TEXT') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="benefit-item">
            <div class="icon-sn book-sn-icon shadow">
                @include('frontend.partials.svg.icons.phone-cancel')
            </div>
            <div class="heading-slider ">
                <h6>{{ __('PROFILE_FREE_CANCELLATION') }}</h6>
                <div class="social-box">
                    <ul>
                        <li>{{ __('PROFILE_FREE_CANCELLATION_TEXT') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a href="\faq" class="hollow btn db w-100">{{ __('PROFILE_READ_FAQ_BUTTON_TEXT') }}</a>
</section>
