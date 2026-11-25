<div class="small-12 medium-3 large-3 white-box-rounded fl filteringCorrections pr24" id="filterTalks">
    <div class="select-wrap">
        <h6 class="filterTitle specialDesktopPaddings2">{{ __('FILTER_OPTIONS') }}</h6>
        <form class="specialDesktopPaddings2" {{-- method="post" action="{{ route('favorites_talks_form') }}" --}} id="filter-form">
            @csrf
            <div class="dn" id="talkCategoriesObj">{{ 'a' }}</div>
            <div class="check-filed-wrap" id="durationFilters">
                <h6 data-title="{{ strtolower(__('DURATION')) }}">{{ __('DURATION') }}</h6>

                @if($filters['duration15'])
                    <div class="checkbox-inner">
                        <input id="checkbox015" name="filter[duration][15][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox015" data-minutes="15">15 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration30'])
                    <div class="checkbox-inner">
                        <input id="checkbox030" name="filter[duration][30][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox030" data-minutes="30">30 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration45'])
                    <div class="checkbox-inner">
                        <input id="checkbox045" name="filter[duration][45][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox045" data-minutes="45">45 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration60'])
                    <div class="checkbox-inner">
                        <input id="checkbox060" name="filter[duration][60][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox060" data-minutes="60">60 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration75'])
                    <div class="checkbox-inner">
                        <input id="checkbox075" name="filter[duration][75][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox075" data-minutes="75">75 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration90'])
                    <div class="checkbox-inner">
                        <input id="checkbox090" name="filter[duration][90][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox090" data-minutes="90">90 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration105'])
                    <div class="checkbox-inner">
                        <input id="checkbox0105" name="filter[duration][105][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox0105" data-minutes="105">105 {{ __('global.minutes') }}</label>
                    </div>
                @endif
                @if($filters['duration120'])
                    <div class="checkbox-inner">
                        <input id="checkbox0120" name="filter[duration][120][1]" type="checkbox" data-checked2="0">
                        <label for="checkbox0120" data-minutes="120">120 {{ __('global.minutes') }}</label>
                    </div>
                @endif
            </div>
            <div class="check-filed-wrap" id="priceFilters">
                <h6 data-title="{{ strtolower(__('PRICE_RANGE')) }}">{{ __('PRICE_RANGE') }}</h6>

                @if ($filters['price1_10'])
                    <div class="checkbox-inner">
                        <input id="checkbox3" name="filter[price_range][1_10][1]" type="checkbox" data-price="1_10" data-checked2="0"><label for="checkbox3">1 - 10 €</label>
                    </div>
                @endif

                @if ($filters['price10_50'])
                    <div class="checkbox-inner">
                        <input id="checkbox4" name="filter[price_range][10_50][2]" type="checkbox" data-price="10_50" data-checked2="0"><label for="checkbox4">10 - 50€</label>
                    </div>
                @endif

                @if ($filters['priceOver50'])
                    <div class="checkbox-inner">
                        <input id="checkbox5" name="filter[price_range][over50][3]" type="checkbox" data-price="over50" data-checked2="0"><label for="checkbox5">50+ €</label>
                    </div>
                @endif

                @if ($filters['priceOver100'])
                    <div class="checkbox-inner">
                        <input id="checkbox6" name="filter[price_range][over100][4]" type="checkbox" data-price="over100" data-checked2="0"><label for="checkbox6">100+ €</label>
                    </div>
                @endif

            </div>
            <div class="check-filed-wrap" id="availabilityFilters">
                <h6 data-title="{{ strtolower(__('AVAILABILITY')) }}">{{ __('AVAILABILITY') }}</h6>
                @if ($filters['availableDays'][1])
                    <div class="checkbox-inner">
                        <input id="checkbox11" name="filter[availability][monday][1]" type="checkbox" data-value="1" data-day="monday" data-checked2="0">
                        <label for="checkbox11">{{ __('DAY_MONDAY_LONG') }}</label>
                    </div>
                @endif
                @if ($filters['availableDays'][2])
                    <div class="checkbox-inner">
                        <input id="checkbox22" name="filter[availability][tuesday][2]" type="checkbox" data-value="2" data-day="tuesday" data-checked2="0">
                        <label for="checkbox22">{{ __('DAY_TUESDAY_LONG') }}</label>
                    </div>
                @endif
                @if ($filters['availableDays'][3])
                    <div class="checkbox-inner">
                        <input id="checkbox33" name="filter[availability][wednesday][3]" type="checkbox" data-value="3" data-day="wednesday" data-checked2="0">
                        <label for="checkbox33">{{ __('DAY_WEDNESDAY_LONG') }}</label>
                    </div>
                @endif
                @if ($filters['availableDays'][4])
                    <div class="checkbox-inner">
                        <input id="checkbox44" name="filter[availability][thursday][4]" type="checkbox" data-value="4" data-day="thursday" data-checked2="0">
                        <label for="checkbox44">{{ __('DAY_THURSDAY_LONG') }}</label>
                    </div>
                @endif
                @if ($filters['availableDays'][5])
                    <div class="checkbox-inner">
                        <input id="checkbox55" name="filter[availability][friday][5]" type="checkbox" data-day="friday" data-value="5" data-checked2="0">
                        <label for="checkbox55">{{ __('DAY_FRIDAY_LONG') }}</label>
                    </div>
                @endif
                @if ($filters['availableDays'][6])
                    <div class="checkbox-inner">
                        <input id="checkbox66" name="filter[availability][saturday][6]" type="checkbox" data-value="6" data-day="saturday" data-checked2="0">
                        <label for="checkbox66">{{ __('DAY_SATURDAY_LONG') }}</label>
                    </div>
                @endif
                @if ($filters['availableDays'][7])
                    <div class="checkbox-inner">
                        <input id="checkbox77" name="filter[availability][sunday][7]" type="checkbox" data-day="sunday" data-value="7" data-checked2="0">
                        <label for="checkbox77">{{ __('DAY_SUNDAY_LONG') }}</label>
                    </div>
                @endif
            </div>

            <div class="check-filed-wrap" id="typeFilters">
                <h6 data-title="{{ strtolower(__('TALKS')) }}">{{ __('TALKS') }}</h6>
            {{--     @if ($filters['calls']->contains(1) && $filters['calls']->contains(2))
                    <div class="checkbox-inner">
                        <input id="checkbox1-001" name="filter[talks][all]" type="checkbox" value="all" data-type="all" data-checked2="0">
                        <label for="checkbox1-001">  {{ __('ALL_TYPES') }}</label>
                    </div>
                @endif --}}
                @if ($filters['videoCall'])
                    <div class="checkbox-inner">
                        <input id="checkbox1-1" name="filter[talks][video]" type="checkbox" value="video" data-type="video" data-checked2="0">
                        <label for="checkbox1-1">{{ __('VIDEO_TALKS') }}</label>
                    </div>
                @endif
                @if ($filters['voiceCall'])
                    <div class="checkbox-inner">
                        <input id="checkbox-2" name="filter[talks][voice]" type="checkbox" value="voice" data-type="voice" data-checked2="0">
                        <label for="checkbox-2">{{ __('VOICE_TALKS') }}</label>
                    </div>
                @endif
            </div>

            @if ($filters['anonymAllowed'])
                <div class="check-filed-wrap" id="anonTypeFilters">
                    <h6 data-title="anonTalks">{{ __('ANON_TALKS') }}</h6>

                    <div class="checkbox-inner">
                        <input id="checkbox-3" name="filter[talks][anonTalk]" type="checkbox" data-type="anonTalk" data-checked2="0">
                        <label for="checkbox-3">{{ __('ANON_TALKS') }}</label>
                    </div>

                </div>
            @endif

            <div class="check-filed-wrap languageFilterCor" id="languageDeskFilters">
                <div class="df aic jcsb" id="languageFilterEnableDisable" data-enabled="0">
                    <h6 data-title="{{ strtolower(__('LANGUAGES')) }}">{{ __('LANGUAGES') }}</h6>
                    <svg class="svgLanguageFilterCor" width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.40117e-08 8.825L3.825 5L1.05237e-07 1.175L1.18333 2.5253e-07L6.18333 5L1.18333 10L1.40117e-08 8.825Z" fill="#172B4D"></path>
                    </svg>
                </div>

                @foreach ($filters['languages']['languages'] as $language)
                    <div class="checkbox-inner">
                        <input id="checkbox-{{ $language['id'] }}" name="filter[languages]" type="checkbox" data-id="{{ $language['id'] }}" data-checked2="0">
                        <label for="checkbox-{{ $language['id'] }}">
                            {{ $language['value'] }}
                        </label>
                    </div>
                @endforeach

                @if (count($filters['languages']['languages']) > 5)
                    <span class="btn w-100 mt16 smoreButer" id="showMoreLanguagesButton">{{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}</span>
                @endif
            </div>
        </form>

        <div class="cell small-6 medium-4 ovh submitFilterParent mt16 dn" id="serachFilterButton">
            <span class="btn fl ml10per submit-button mb0 submitFilterZ" id="submitFilter">{{ __('FILTER') }}</span>

        </div>
    </div>
</div>
