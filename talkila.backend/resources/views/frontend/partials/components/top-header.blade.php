@guest
    @if (!$isApple['isIOSDevice'])
        <div class="ptbo">
            <div class="container">
                <div class="gcTop">

                    <div class="thl logoHT">
                        @include('frontend.partials.svg.icons.favicon')
                    </div>
                    <div class="thl logoTextHT">
                        <div class="topHeaderText">
                            <h6 class="topHeaderText1">{{ __('TALKILA_APP') }}</h6>
                            <p class="topHeaderText2">{{ __('TALKILA_SE') }}</p>
                        </div>
                    </div>
                    <div class="thl butHT mla df aic">
                        <span class="btn butHTI cp" data-popup="appStorePupUp">{{ __('APP_HEADER_BUTTON_INSTALL') }}
                        </span>
                    </div>
                    <div class="xSingHT cblack">
                        <span aria-hidden="true">&times;</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endguest
