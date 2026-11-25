@if (!empty($userFavoritesData))
<div class="innerMobileDiv">
    <div class="small-12 jcsb w-100 smallFilter grid-container">
        <div class="subFilterItems posrelative">

            <select id="filterTypes" class="talkTypes default-select zi999 posrelative" name="languageG">

                <option value="1" selected>
                    {{ __('ALL_TYPES') }}
                </option>
                <option value="2">
                    {{ __('VIDEO_TALK') }}
                </option>
                <option value="3">
                    {{ __('PHONE_TALK') }}
                </option>

            </select>
            <p class="pster pster1 zi111">{{ __('TYPE') }}</p>
        </div>
        <div class="subFilterItems posrelative">

            <select id="filterDuration" class="talkTypes default-select zi999 posrelative" name="languageG">

                <option value="15">
                   15
                </option>
                <option value="30">
                    30
                </option>
                <option value="45">
                    45
                </option>
                <option value="60">
                    60
                 </option>
                 <option value="75">
                     75
                 </option>
                 <option value="90">
                     90
                 </option>
                 <option value="105">
                    105
                 </option>
                 <option value="120">
                    120
                 </option>
                 <option value="121">
                     120+
                 </option>

            </select>
            <p class="pster pster2">{{ __('DURATION') }}</p>
        </div>
        <div class="subFilterItems zi999 posrelative">

            <select id="filterDays" class="talkTypes default-select zi999 posrelative" name="languageG">

                <option value="1">
                   {{__('DAY_MONDAY_LONG')}}
                </option>
                <option value="2">
                    {{__('DAY_TUESDAY_LONG')}}
                </option>
                <option value="3">
                    {{__('DAY_WEDNESDAY_LONG')}}
                </option>
                <option value="4">
                    {{__('DAY_THURSDAY_LONG')}}
                 </option>
                 <option value="5">
                    {{__('DAY_FRIDAY_LONG')}}
                 </option>
                 <option value="6">
                    {{__('DAY_SATURDAY_LONG')}}
                 </option>
                 <option value="7">
                    {{__('DAY_SUNDAY_LONG')}}
                 </option>


            </select>
            <p class="pster pster1">{{ __('DAYS') }}</p>
        </div>
        <div class="subFilterItems zi999 posrelative">

            <select id="filterLanguage" class="talkTypes default-select zi999 posrelative" name="languageG">

                @foreach($languagesData as $language)
                    <option value="{{ $language['id'] }}" >
                        {{ $language['value'] }}
                    </option>
                @endforeach


            </select>
            <p class="pster pster3">{{ __('LANGUAGE') }}</p>
        </div>
    </div>

</div>
@endif
