<section class="carousel_slider mobileCarousel" id="mobileCarousel" data-desktop="0" data-mobile="1">
    <div class="mobile-view-block hide-for-large">
        <div class="container">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-12 large-6 mobSliderTwo">
                    <h2 class="heading-Talkila">{!! __('SLIDER_1_HEADLINE') !!}</h2>
                    <div id="mobile-slider-one" class="owl-carousel owl-theme">
                        <div class="item">
                            <a class="slider-item url" href="#three">
                                <div class="icon-sn">
                                    @include('frontend.partials.svg.icons.offer-your-time')
                                </div>
                                <div class="heading-slider">
                                    <h6>{{ __('SLIDER_1_HEADLINE_1') }}</h6>
                                    <p>{{ __('SLIDER_1_TEXT_1') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a class="slider-item url" href="#three">
                                <div class="icon-sn">
                                    @include('frontend.partials.svg.icons.rethinking-privacy')
                                </div>
                                <div class="heading-slider">
                                    <h6>{{ __('SLIDER_1_HEADLINE_2') }}</h6>
                                    <p>{{ __('SLIDER_1_TEXT_2') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a class="slider-item url" href="#three">
                                <div class="icon-sn">
                                    @include('frontend.partials.svg.icons.safe-payment')
                                </div>
                                <div class="heading-slider">
                                    <h6>{{ __('SLIDER_1_HEADLINE_3') }}</h6>
                                    <p>{{ __('SLIDER_1_TEXT_3') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-12 large-6 mobSliderTwo">
                    <h2 class="heading-Talkila">{{ __('SLIDER_2_HEADLINE_TABLET') }}</h2>
                    <div id="mobile-slider-two" class="owl-carousel owl-theme">
                        <div class="item">
                            <a class="slider-item url" href="#three">
                                <div class="icon-sn">
                                    @include('frontend.partials.svg.icons.offer-everything')
                                </div>
                                <div class="heading-slider">
                                    <h6>{{ __('SLIDER_2_HEADLINE_1') }}</h6>
                                    <p>{{ __('SLIDER_2_TEXT_1') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a class="slider-item url" href="#three">
                                <div class="icon-sn">
                                    @include('frontend.partials.svg.icons.influenser')
                                </div>
                                <div class="heading-slider">
                                    <h6>{{ __('SLIDER_2_HEADLINE_2') }}</h6>
                                    <p>{{ __('SLIDER_2_TEXT_2') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class="item">
                            <a class="slider-item url" href="#three">
                                <div class="icon-sn">
                                    @include('frontend.partials.svg.icons.toutoring')
                                </div>
                                <div class="heading-slider">
                                    <h6>{{ __('SLIDER_2_HEADLINE_3') }}</h6>
                                    <p>{{ __('SLIDER_2_TEXT_3') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
