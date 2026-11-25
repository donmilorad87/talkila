<div class="seccond-footer">
    {{-- <div class="grid-x">
        <ul class="menu align-center">
            <li><a href="#">{{ __('FOOTER_LINK_FOR_TALENTS') }}</a></li>
            <li><a href="#">{{ __('FOOTER_LINK_FOR_COMPANIES') }}</a></li>
            <li><a href="#">{{ __('FOOTER_LINK_FACEBOOK_GROUP') }}</a></li>
            <li><a href="#">{{ __('FAQ') }}</a></li>
        </ul>
    </div>
    <div class="grid-x">
        <ul class="menu align-center">
            <li><a href="#">{{ __('FOOTER_LINK_MEET_THE_TEAM') }}</a></li>
            <li><a href="#">{{ __('FOOTER_LINK_OUR_STORY') }}</a></li>
            <li><a href="#">{{ __('FOOTER_LINK_CAREER') }}</a></li>
        </ul>
    </div> --}}

    <div class="grid-x">
        <ul class="menu align-center">
            <li><a href="{{route('legal_pages', ['slug' => 'privacy-policy'])}}" target="_blank">{{ __('FOOTER_LINK_DATA_PRIVACY') }}</a></li>
            <li><a href="#" target="_blank">{{ __('FOOTER_LINK_CONTACT') }}</a></li>
            <li><a href="{{route('legal_pages', ['slug' => 'terms-and-conditions'])}}" target="_blank">{{ __('TERMS_AND_CONDITIONS') }}</a></li>
        </ul>
    </div>
    {{-- @include('frontend.partials.components.copyright') --}}
</div>
