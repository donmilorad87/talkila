<div class="innerMobileDiv smallFilterForMobile">
    <div class="small-12 jcsb w-100 smallFilter">
        <div class="subFilterItems posrelative">

            <select id="filterTypes" class="talkTypes default-select zi998 posrelative selectMultiple" name="typeG" multiple>
                <option value="0" class="dn">
                    0
                 </option>
                @if ($filters['videoCall'] && $filters['voiceCall'])
                    <option value="1" selected>
                        {{ __('ALL_TYPES') }}
                    </option>
                @endif
                @if ($filters['videoCall'])
                    <option value="2">
                        {{ __('VIDEO_TALK') }}
                    </option>
                @endif
                @if ($filters['voiceCall'])
                    <option value="3">
                        {{ __('PHONE_TALK') }}
                    </option>
                @endif
            </select>
            <div class="posabsolute w-100 l0 t0">
                <p class="pster pster1 zi111">{{ __('TYPE') }}</p>
                <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
            </div>

        </div>
        <div class="subFilterItems posrelative">
            @php

                $array_of_time   = [15,30,45,60,75,90,105,120,135,150,165,180];

            @endphp
            <select id="filterDuration" class="talkTypes default-select zi999 posrelative selectMultiple" name="durationG" multiple>
                <option value="0" class="dn">
                    0
                 </option>

                 @for ($i = 0; $i< count($array_of_time); $i++)
                    @if ($array_of_time[$i] > 120)
                        @if ($filters['durationOver120'])
                            <option value="{{$array_of_time[$i]}}">
                                {{$array_of_time[$i]}}
                            </option>
                        @endif
                    @else
                        @if ($filters['duration'.$array_of_time[$i]])
                            <option value="{{$array_of_time[$i]}}">
                                {{$array_of_time[$i]}}
                            </option>
                        @endif
                    @endif

                @endfor

            </select>
            <div class="posabsolute w-100 l0 t0">
                <p class="pster pster2">{{ __('DURATION') }}</p>
                <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
            </div>

        </div>
        <div class="subFilterItems zi998 posrelative">

            <select id="filterDays" class="talkTypes default-select zi999 posrelative selectMultiple" name="daysG" multiple>
                <option value="0" class="dn">
                   0
                </option>
                @if ($filters['availableDays']['1'])
                    <option value="1">
                        {{ __('DAY_MONDAY_LONG') }}
                    </option>
                @endif
                @if ($filters['availableDays']['2'])
                    <option value="2">
                        {{ __('DAY_TUESDAY_LONG') }}
                    </option>
                @endif
                @if ($filters['availableDays']['3'])
                    <option value="3">
                        {{ __('DAY_WEDNESDAY_LONG') }}
                    </option>
                @endif
                @if ($filters['availableDays']['4'])
                    <option value="4">
                        {{ __('DAY_THURSDAY_LONG') }}
                    </option>
                @endif
                @if ($filters['availableDays']['5'])
                    <option value="5">
                        {{ __('DAY_FRIDAY_LONG') }}
                    </option>
                @endif
                @if ($filters['availableDays']['6'])
                    <option value="6">
                        {{ __('DAY_SATURDAY_LONG') }}
                    </option>
                @endif
                @if ($filters['availableDays']['7'])
                    <option value="7">
                        {{ __('DAY_SUNDAY_LONG') }}
                    </option>
                @endif

            </select>
            <div class="posabsolute w-100 l0 t0">

                <p class="pster pster1">{{ __('DAYS') }}</p>
                <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
            </div>
        </div>
        <div class="subFilterItems zi999 posrelative">

            <select id="filterLanguage" class="talkTypes default-select zi999 posrelative selectMultiple" name="languageG" multiple>
                <option value="0" class="dn">
                    0
                 </option>


            </select>
            <div class="posabsolute w-100 l0 t0">
                <p class="pster pster3">{{ __('LANGUAGE') }}</p>
                <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
            </div>

        </div>
    </div>
</div>
