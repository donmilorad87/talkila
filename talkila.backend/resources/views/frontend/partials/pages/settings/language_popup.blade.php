<div class="popupBase" id="languagePopUp" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            <div class="df aic steperko CVHeading">

                    <span class="cz df" data-close-popup='languagePopUp'>
                        @include('frontend.partials.svg.icons.arrow-left')
                    </span>

                    <div class="tac fw languages mb0">@lang('LANGUAGES')</div>

            </div>

            <div class="grid-container">

                <div class="df bb1 languageItemList">
                    <input type="radio" class="languageSet" id="english_gb" name="languageSet" value="EN">
                    <label for="english_gb">{{ __('ENGLISH') }} (GB) @include('frontend.partials.svg.flags.gb')</label>
                </div>

                <div class="df bb1 languageItemList">
                    <input type="radio" class="languageSet" id="croatian" name="languageSet" value="HR">
                    <label for="croatian">{{ __('CROATIAN') }} @include('frontend.partials.svg.flags.cro')</label>
                </div>

                <div class="df bb1 languageItemList">
                    <input type="radio" class="languageSet" id="german" name="languageSet" value="DE">
                    <label for="german">{{ __('GERMAN') }} @include('frontend.partials.svg.flags.ger')</label>
                </div>

                <div class="df languageItemList">
                    <input type="radio" class="languageSet" id="polish" name="languageSet" value="PL">
                    <label for="polish">{{ __('POLISH') }} @include('frontend.partials.svg.flags.pol')</label>
                </div>

            </div>

        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
