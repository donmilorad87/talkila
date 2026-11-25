<div class="popupBase" id="appStorePupUp" data-opened="0">
    <div class="popuper">
        <div class="grid-x">

            <div class="popupImage">
                <img src="/frontend/assets/img/model-mobile-app-blue.png" alt="Popup picture">
            </div>

            <div class="popupText">
                <div class="app-popup-right">
                    <div class="innerPopUp">
                        <h3>{{ __('EXITLAYER_HEADLINE') }}</h3>
                        <p class="popuperText">{{ __('EXITLAYER_TEXT_1') }}</p>

                        <div class="mb32">
                            <div class="media-object">
                                <div class="media-object-section">
                                    <div class="thumbnail">
                                        @include('frontend.partials.svg.icons.offer-everything')
                                    </div>
                                </div>
                                <div class="media-object-section main-section">
                                  <p>{{ __('EXITLAYER_TEXT_2') }}</p>
                              </div>
                            </div>

                            <div class="media-object">
                                <div class="media-object-section">
                                    <div class="thumbnail">
                                        @include('frontend.partials.svg.icons.rethinking-privacy')
                                    </div>
                                </div>
                                <div class="media-object-section main-section">
                                    <p>{{ __('EXITLAYER_TEXT_3') }}</p>
                                </div>
                            </div>
                            <div class="media-object">
                                <div class="media-object-section">
                                    <div class="thumbnail">
                                        @include('frontend.partials.svg.icons.safe-payment')
                                    </div>
                                </div>
                                <div class="media-object-section main-section">
                                    <p>{{ __('EXITLAYER_TEXT_4') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('frontend.partials.components.app_icons')
                </div>
            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
