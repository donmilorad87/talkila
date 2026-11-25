<div class="wpader">
    <div class="container">
        <div class="grid-x small-12">
            <div class="grid-x medium-12 small-12 large-7 small-up-1 medium-up-3">
                <div class="cell">
                    <div class="heading-title-fr">
                        <h5>{{ __('FOOTER_COMMUNITY') }}</h5>
                        <div class="vertical menu">
                            <a href="{{route('legal_pages', ['slug' => 'privacy-policy'])}}" target="_blank">

                                    {{ __('FOOTER_LINK_PRIVACY_POLICE') }}

                            </a>
                        </div>
                    </div>
                </div>
                <div class="cell">
                    <div class="heading-title-fr">
                        <h5>{{ __('FOOTER_HEADLINE_ABOUT_US') }}</h5>
                        <div class="vertical menu">
                            <a href="#">

                                    {{ __('FOOTER_LINK_CONTACT') }}

                            </a>
                        </div>
                    </div>
                </div>
                <div class="cell">
                    <div class="heading-title-fr">
                        <h5>{{ __('FOOTER_HEADLINE_USEFUL') }}</h5>
                        <div class="vertical menu">
                            <a href="{{route('legal_pages',['slug' => 'terms-and-conditions'])}}" target="_blank">
                                {{ __('TERMS_AND_CONDITIONS') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-x medium-12 large-5 cell small-12">
                <div class="cell hide-for-small-only hide-for-medium-only">
                    <div class="heading-title-fr">
                        <h5>{{ __('INPUT_SMS_NUMBER_HEADLINE') }}</h5>
                        <p class="title-footer-bt footerTerms">
                            {{ __('FOOTER_TEXT_1') }}
                            <a href="{{route('legal_pages', ['slug' => 'terms-and-conditions'])}}" target="_blank">
                                {{ __('TERMS_AND_CONDITIONS') }}</a>
                            {{ __('FOOTER_TEXT_2') }}
                            <a href="{{route('legal_pages', ['slug' => 'privacy-policy'])}}" target="_blank">{{ __('FOOTER_LINK_DATA_PRIVACY') }}</a>
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
