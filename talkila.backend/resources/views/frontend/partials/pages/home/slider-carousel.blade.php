<section class="carousel_slider desktopCarousel" id="desktopCarousel1" data-desktop="1" data-mobile="0">

    <div class="container" id="sliderDesktop-One">
        <h2 class="heading-Talkila-Tablet show-for-tablet mt4rem">{!! __('FIRST_SLIDER_TITLE_TABLET') !!}</h2>
        <div class="grid-x grid-margin-x">
            <div class="cell small-12 medium-6 large-6">
                <h2 class="heading-Talkila show-for-large pt3rem">{!! __('SLIDER_1_HEADLINE') !!}</h2>
                <div id="carousel-one">
                    <div class="slider-item one url active" data-owl-index="0">
                        <div class="icon-sn">
                            @include('frontend.partials.svg.icons.offer-your-time')
                        </div>
                        <div class="heading-slider">
                            <h6>{{ __('SLIDER_1_HEADLINE_1') }}</h6>
                            <p>{{ __('SLIDER_1_TEXT_1') }}</p>
                        </div>
                    </div>
                    <div class="slider-item url" data-owl-index="1">
                        <div class="icon-sn">
                            @include('frontend.partials.svg.icons.rethinking-privacy')
                        </div>
                        <div class="heading-slider">
                            <h6>{{ __('SLIDER_1_HEADLINE_2') }}</h6>
                            <p>{{ __('SLIDER_1_TEXT_2') }}</p>
                        </div>
                    </div>
                    <div class="slider-item three url" data-owl-index="2">
                        <div class="icon-sn">
                            @include('frontend.partials.svg.icons.safe-payment')
                        </div>
                        <div class="heading-slider">
                            <h6>{{ __('SLIDER_1_HEADLINE_3') }}</h6>
                            <p>{{ __('SLIDER_1_TEXT_3') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cell small-12 medium-6 large-6">
                <div class="carouselOne">
                    <div id="slider-one" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="slide-img"><img  loading="lazy"
                                    src="/frontend/assets/img/webp/big/offer-youre-time.webp"  alt="{{ __('SLIDER_1_HEADLINE_1') }}"></div>
                        </div>
                        <div class="item">
                            <div class="slide-img"><img  loading="lazy"
                                    src="/frontend/assets/img/webp/big/rethinking-privacy.webp"  alt=">{{ __('SLIDER_1_HEADLINE_2') }}"></div>
                        </div>
                        <div class="item">
                            <div class="slide-img"><img  loading="lazy"
                                    src="/frontend/assets/img/webp/big/safe-payment.webp"  alt="{{ __('SLIDER_1_HEADLINE_3') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="carousel_slider desktopCarousel mt16" id="desktopCarousel2" data-desktop="1" data-mobile="0">
    <div class="container pt-5" id="sliderDesktop-Two">
        <h2 class="heading-Talkila-Tablet show-for-tablet ">{{ __('SLIDER_2_HEADLINE_TABLET') }}</h2>
        <div class="grid-x grid-margin-x">
            <div class="cell small-12 medium-6 large-6">
                <div class="carouselTwo">
                    <div id="slider-two" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="slide-img"><img loading="lazy"
                                    src="/frontend/assets/img/webp/big/offer-everything.webp" alt="{{__('OFFER')}} {{__('EVERYTHING')}}"></div>
                        </div>
                        <div class="item">
                            <div class="slide-img"><img loading="lazy"
                                    src="/frontend/assets/img/webp/big/influencer.webp" alt="{{__('INFLUENCER')}}"></div>
                        </div>
                        <div class="item">
                            <div class="slide-img"><img loading="lazy"
                                    src="/frontend/assets/img/webp/big/tutoring.webp" alt="{{__('TUTORING')}}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="carousel-two" class="cell small-12 medium-6 large-6 pb4rem">
                <h2 class="heading-Talkila show-for-large">{!! __('SLIDER_2_HEADLINE') !!}</h2>
                <div class="slider-item url one active" data-owl-index="0">
                    <div class="icon-sn">
                        @include('frontend.partials.svg.icons.offer-everything')
                    </div>
                    <div class="heading-slider">
                        <h6>{{ __('SLIDER_2_HEADLINE_1') }}</h6>
                        <p>{{ __('SLIDER_2_TEXT_1') }}</p>
                    </div>
                </div>
                <div class="slider-item url" data-owl-index="1">
                    <div class="icon-sn">
                        @include('frontend.partials.svg.icons.influenser')
                    </div>
                    <div class="heading-slider">
                        <h6>{{ __('SLIDER_2_HEADLINE_2') }}</h6>
                        <p>{{ __('SLIDER_2_TEXT_2') }}</p>
                    </div>
                </div>
                <div class="slider-item three url" data-owl-index="2">
                    <div class="icon-sn">
                        @include('frontend.partials.svg.icons.toutoring')
                    </div>
                    <div class="heading-slider">
                        <h6>{{ __('SLIDER_2_HEADLINE_3') }}</h6>
                        <p>{{ __('SLIDER_2_TEXT_3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
