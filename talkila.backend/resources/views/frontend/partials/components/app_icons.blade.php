<div class="button-group apps-inner df g1rem jcc aic mt32 mb32 bgroupsvg" id="appButtonsContainer">

    <a class="{{($isApple['isIOSDevice'] || $isApple['isMacDevice']) ? 'df' : 'dn'}} aic jcfs" id="appleApp" href="{{ config('app.iosStoreLink') }}" target="_blank">@include('frontend.partials.svg.icons.apple-app-store')</a>
    <a class="{{ ($isApple['isIOSDevice'] || $isApple['isMacDevice']) ? 'dn' : 'df'}} aic jcfs" id="androidApp" href="{{ config('app.androidStoreLink') }}@if (isset($requestParams) && isset($pratnerData))&referrer={{ config('app.appUrl') }}/f/{{ isset($pratnerData) ? (isset($pratnerData->slug) ? $pratnerData->slug : '') : '' }}?te={{ $requestParams->te }}{{ isset($requestParams->tu) ? '&tu=' . $requestParams->tu : '' }}{{ isset($requestParams->td) ? '&td=' . $requestParams->td : '' }}{{ isset($requestParams->ti) ? '&ti=' . $requestParams->ti : '' }}@endif" target="_blank">@include('frontend.partials.svg.icons.google-play-store-2')</a>

</div>
