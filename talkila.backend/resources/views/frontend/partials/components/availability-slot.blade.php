
@if (!empty($availability))



    <div class="date-wrap-content d-flex g1rem bb1 mb8 pb8">

        <div class="date-time" data-time-slot-id="{{ $availability['id'] }}" onclick="editAvailability(this)">
            <p>
                <strong>
                    {{ substr(changeDateFormatLocaleDay('Y-m-d H:i:s', getTimeZonedDate('Y-m-d H:i:s', date('Y-m-d H:i:s', mktime(0, 0, 0, 8, $availability['weekday'], 2011)))), 0, -1) }}
                </strong>
            </p>
            <small>
                {{ date('H:i', strtotime($availability['start_time'])) }} - {{ date('H:i', strtotime($availability['end_time'])) }}
            </small>
        </div>

        <div class="button-switch switch">

            <input class="switch-input user-availability {{ $pointerForMobile ?? '' }}"
                id="availability-{{ $availability['id'] }}{{ $pointerForMobile ?? '' }}"
                type="checkbox"
                data-weekday="{{ $availability['weekday'] }}" data-startTime="{{ $availability['start_time'] }}"
                data-endTime="{{ $availability['end_time'] }}" data-localTimezone="{{ getLocalTimeZone() }}"
                name="availability" value="{{ $availability['id'] }}" @if ($availability['state']) checked @endif onchange="availabilityPauseUnpause(this)">


            <label class="switch-paddle" for="availability-{{ $availability['id'] }}{{ $pointerForMobile ?? '' }}">
                <span class="show-for-sr">{{ __('DOWNLOAD_KITTENS') }}</span>
            </label>
        </div>
        <span class="availability-delete" onclick="deleteAva(this)" data-id="{{ $availability['id'] }}">
            @include('frontend.partials.svg.icons.remove') </span>




    </div>
@endif
