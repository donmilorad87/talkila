<div class="popupBase zi9999" id="newFilterPopup" data-opened="0">
    <div class="popuper ppR">
        @include('frontend.partials.pages.jtc.mobile-steps-navigation-6', [
            'page_title' => __('FILTER_YOUR_TALKS'),
            "clear_button" => TRUE
        ])
        <div class="credit-model">

            <div class="newMainFilterDiv">
                <form id="newFilterForm" class="hi oh p8">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="pb4 typeAvaF">
                        <div class="grid-x filterType fter">
                            <h4 class="w-100 fl headingFilter"> {{ __('TYPE') }} </h4>
                            <div class="df w-100">
                               {{--  @if ($filters['calls']->contains(1) && $filters['calls']->contains(2))
                                    <span class="filterTypeBadge" data-type="all" data-clicked="0"
                                          data-checked2="0">
                                        {{ __('ALL_TYPES') }}
                                    </span>
                                @endif --}}
                                @if ($filters['videoCall'])
                                    <span class="filterTypeBadge" data-type="video" data-clicked="0" data-checked2="0">
                                        {{ __('VIDEO_TALK') }}
                                    </span>
                                @endif
                                @if ($filters['voiceCall'])
                                    <span class="filterTypeBadge" data-type="voice" data-clicked="0" data-checked2="0">
                                        {{ __('PHONE_TALK') }}
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="grid-x filterPrice fter">
                            <h4 class="w-100 fl headingFilter"> {{ __('BASE_PRICE') }} </h4>
                            <div class="df w-100">

                                @if ($filters['price1_10'])
                                    <span class="filterPriceBadge" data-price="1_10" data-checked="0" data-checked2="0">
                                        1 - 10 €
                                    </span>
                                @endif

                                @if ($filters['price10_50'])
                                    <span class="filterPriceBadge" data-price="10_50" data-checked="0"
                                          data-checked2="0">
                                        10 - 50 €
                                    </span>
                                @endif

                                @if ($filters['priceOver50'])
                                    <span class="filterPriceBadge" data-price="over50" data-checked="0" data-checked2="0">
                                        50+ €
                                    </span>
                                @endif

                                @if ($filters['priceOver100'])
                                    <span class="filterPriceBadge" data-price="over100" data-checked="0" data-checked2="0">
                                        100+ €
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid-x filterLength fter">
                            <h4 class="w-100 fl headingFilter">
                                {{ __('LENGTH') }} ({{ __('MINUTES_SHORT') }})
                            </h4>

                            <div id="lengthAvailability" class="owl-carousel ">


{{--                                @foreach ($filters['durations'] as $duration)--}}

{{--                                        <div--}}
{{--                                            class="filterLengthBadge duration{{$duration}}"--}}
{{--                                            data-length="{{ $duration }}"--}}
{{--                                            data-checked="0"--}}
{{--                                            data-checked2="0"--}}
{{--                                        >--}}
{{--                                            {{ $duration }}--}}
{{--                                        </div>--}}

{{--                                @endforeach--}}

                                @if($filters['duration15'])
                                    <div
                                        class="filterLengthBadge duration15"
                                        data-length="15"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        15
                                    </div>
                                @endif
                                @if($filters['duration30'])
                                    <div
                                        class="filterLengthBadge duration30"
                                        data-length="30"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        30
                                    </div>
                                @endif
                                @if($filters['duration45'])
                                    <div
                                        class="filterLengthBadge duration45"
                                        data-length="45"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        45
                                    </div>
                                @endif
                                @if($filters['duration60'])
                                    <div
                                        class="filterLengthBadge duration60"
                                        data-length="60"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        60
                                    </div>
                                @endif
                                @if($filters['duration75'])
                                    <div
                                        class="filterLengthBadge duration75"
                                        data-length="75"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        75
                                    </div>
                                @endif
                                @if($filters['duration90'])
                                    <div
                                        class="filterLengthBadge duration90"
                                        data-length="90"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        90
                                    </div>
                                @endif
                                @if($filters['duration105'])
                                    <div
                                        class="filterLengthBadge duration105"
                                        data-length="105"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        105
                                    </div>
                                @endif
                                @if($filters['duration120'])
                                    <div
                                        class="filterLengthBadge duration120"
                                        data-length="120"
                                        data-checked="0"
                                        data-checked2="0"
                                    >
                                        120
                                    </div>
                                @endif



                            </div>
                        </div>

                        <div class="grid-x filterAvailability fter avaSmallFilter">
                            <h4 class="w-100 fl headingFilter"> {{__('AVAILABILITY')}} </h4>
                            <div class="df w-100">
                                @if ($filters['availableDays'][1])
                                    <span class="filterDayBadge" data-day="monday" data-value="1" data-checked="0" data-checked2="0">
                                        {{ __('DAY_MONDAY_SHORT') }}
                                    </span>
                                @endif
                                @if ($filters['availableDays'][2])
                                    <span class="filterDayBadge" data-day="tuesday" data-value="2" data-checked="0" data-checked2="0">
                                        {{ __('DAY_TUESDAY_SHORT') }}
                                    </span>
                                @endif
                                @if ($filters['availableDays'][3])
                                    <span class="filterDayBadge" data-day="wednesday" data-value="3" data-checked="0"
                                          data-checked2="0">
                                        {{ __('DAY_WEDNESDAY_SHORT') }}
                                    </span>
                                @endif
                                @if ($filters['availableDays'][4])
                                    <span class="filterDayBadge" data-day="thursday" data-value="4" data-checked="0" data-checked2="0">
                                        {{ __('DAY_THURSDAY_SHORT') }}
                                    </span>
                                @endif
                                @if ($filters['availableDays'][5])
                                    <span class="filterDayBadge" data-day="friday" data-value="5" data-checked="0" data-checked2="0">
                                        {{ __('DAY_FRIDAY_SHORT') }}
                                    </span>
                                @endif
                                @if ($filters['availableDays'][6])
                                    <span class="filterDayBadge" data-day="saturday" data-value="6" data-checked="0" data-checked2="0">
                                        {{ __('DAY_SATURDAY_SHORT') }}
                                    </span>
                                @endif
                                @if ($filters['availableDays'][7])
                                    <span class="filterDayBadge" data-day="sunday" data-value="7" data-checked="0" data-checked2="0">
                                        {{ __('DAY_SUNDAY_SHORT') }}
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="grid-x filterLanguage fter">
                            <div class="rangeSlidas w-100">
                                <div class="firstFooterLeft df aic">
                                    <div class="df aic jcc w-100 labelCheckbox" id="labelCheckbox" data-clicked="0">
                                        <input id="checkLanguageMobile" name="checkLanguageMobile" type="checkbox" class="p0 m0 inputLanCorFix">
                                        <label for="checkLanguageMobile" class="lh1">
                                            <h4 class=" w-100 fl headingFilter mb0"> {{ __('LANGUAGE') }} </h4>
                                        </label>
                                    </div>
                                    <select id="languageGg" disabled class="default-select {{ !empty($requestedTalk) && $requestedTalk['talk_type'] == 2 && !empty($requestedTalk['languages_id'])? 'ok': '' }}" name="languageG" data-checked2="0">
                                        @foreach ($filters['languages']['languages'] as $language)
                                            <option value="{{ $language['id'] }}" @if ($language['id'] == 33) selected @endif data-id="{{ $language['id'] }}">
                                                {{ $language['value'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid-x filterAnonAllowed fter bb0">

                            <div class="date-wrap-content w-100">
                                <div class="button-switch switch switch-re-edit d-flex">
                                    <input class="switch-input" id="annonTalks" type="checkbox" name="annonTalks"
                                           ata-type="anonTalk" data-checked2="0">
                                    <div class="posrelative anonim d-flex aic">
                                        {{-- @include('frontend.partials.svg.icons.anonymous2') --}}
                                        <p class="headingFilter posrelative mb0">
                                            {{ __('ALLOW_ANONYMOUS_TALKS') }}
                                        </p>
                                    </div>
                                    <label class="switch-paddle" for="annonTalks">
                                        <span class="show-for-sr">{{ __('DOWNLOAD_KITTENS') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bbut">
                        <span class="btn w-100 db fw600 mt8 submitFilterZ" id="newFilterSubmit">
                            {{ __('SHOW_TALKS') }}
                        </span>
                    </div>
                </form>
            </div>


        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
