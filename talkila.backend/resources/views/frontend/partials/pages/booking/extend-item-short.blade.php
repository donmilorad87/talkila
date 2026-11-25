@if (isset($item['extends']) && !empty($item['extends']))
    <div class="fl w-100 mt16">
        @foreach ($item['extends'] as $extendItem)
            <div class="posrelative white-box fr mb16 w-100 p1rem pt3rem oh">
                <div class="posabsolute bookingBadge">

                    <div class="fv600 o07 grayBooking tac h22 fs16">
                        @include('frontend.partials.svg.icons.info-icon') @lang('EXTENDION')
                    </div>

                </div>

                <div class='d-flex'>
                    <div class="d-flex timing-box-left">
                        <div class="inner-box-timing width64px duration{{ $extendItem['duration'] }}">
                            <h6>{{ $item['duration'] }}</h6>
                            <p>
                                @if ($item['duration'] > 1)
                                    {!! __('PROFILE_MINUTES') !!}
                                @else
                                    {!! __('PROFILE_MINUTE') !!}
                                @endif
                            </p>
                        </div>




                    </div>

                    <div class="timing-box-right ">
                        <div class="timezone-inner">

                            <p data-postpone-time="{{ $item['start_call'] }}" class="lh1">
                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $extendItem['start_call'])->format('H:i') }}
                                -
                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $extendItem['end_call'])->format('H:i') }}
                            </p>
                            <span>
                                {!! __('TIMEZONE') !!} ( {{ getLocalTimeZoneName() }} )
                            </span>
                        </div>
                    </div>
                </div>






            </div>
        @endforeach
    </div>

@endif
