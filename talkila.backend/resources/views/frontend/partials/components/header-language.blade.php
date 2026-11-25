
@php
    $menuLanguages = \Illuminate\Support\Facades\Config::get('menu_languages.menuLanguages');
    $sessionLanguage = session()->get('language') ?? 'en';

    $activeLanguage = $menuLanguages[$sessionLanguage];

@endphp

<div class="langCont">
    <div class="lanugageMainCont">
        <div data-platform="{{ $sessionLanguage }}" data-opened="0" class="languageCell noselect df aic h32" id="mainLanguageCell">
            <span class="df pon" id="languageCellFlag">
                {!! $activeLanguage['flag'] !!}
            </span>

            <div class="df pon aZubizareta aic {{$class}}">
                <span id="languageListStringContainer">
                    {{$activeLanguage['name']}}
                </span>
                <div class="rotate90">@include('frontend.partials.svg.icons.arrow-right')</div>
            </div>
        </div>
    </div>

    <div class="noselect languageList" data-filled="0">
        @foreach($menuLanguages as $language => $flag)
            <a href="{{ url()->current() }}?hl={{ $language }}" data-platform="{{ $language }}"  class="languageListCell {{ $language == $sessionLanguage ? 'dnone' : ''}}">
                <p class="languageP"> {{ $flag['name'] }}</p>
            </a>
        @endforeach
    </div>
</div>
