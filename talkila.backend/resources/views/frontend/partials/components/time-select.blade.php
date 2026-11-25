<div class="w-100 fl posrelative rollers">
    <div class="date_range outside">
        <div class="date_range_container">
            <div class="date_range_from">
                <div class="date_range_header date_range_from_header">
                    <span class="title noselect">{{ __('START_TIME') }}</span>
                    <span class="selection noselect startTime">
                        <span class="fromHours">12</span>:<span class="fromMinutes">00</span>
                    </span>
                </div>
                @php
                    if(!empty($requestedTalk['start_time_call'])) {
                        $start_hours    = date('H', strtotime($requestedTalk['start_time_call']));
                        $start_minutes  = date('i', strtotime($requestedTalk['start_time_call']));
                    } else {
                        $start_hours    = null;
                        $start_minutes  = null;
                    }
                    if(!empty($requestedTalk['end_time_call'])) {
                        $end_hours     = date('H', strtotime($requestedTalk['end_time_call']));
                        $end_minutes   = date('i', strtotime($requestedTalk['end_time_call']));
                    } else {
                        $end_hours = null;
                        $end_minutes = null;
                    }
                @endphp
                <div class="form_div">
                    <div class="lines">
                        <div>:</div>
                    </div>
                    <select class="date from_hours" onchange="fromHourChange(this)" name="from_hours">
                        @for($i = 23; $i >= 0; $i--)
                            <option value="{{$i < 10 ? '0'.$i : $i }}" @if(!empty($start_hours) && $start_hours == $i) selected @endif>{{ $i < 10 ? '0'.$i : $i }}</option>
                        @endfor
                    </select>
                    <select class="date from_minutes" onchange="fromMinuteChange(this)" name="from_minutes">
                        @for($i = 0; $i <= 4; $i++)
                            <option value="45" @if(!empty($start_minutes) && $start_minutes == 45) selected @endif>45</option>
                            <option value="30" @if(!empty($start_minutes) && $start_minutes == 30) selected @endif>30</option>
                            <option value="15" @if(!empty($start_minutes) && $start_minutes == 15) selected @endif>15</option>
                            <option value="00"  @if(!empty($start_minutes) && $start_minutes == 0)  selected @endif>00</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="date_range_to">
                <div class="date_range_header date_range_to_header">
                    <span class="title noselect">{{ __('END') }}</span>
                    <span class="selection noselect endTime">
                        <span class="toHours">13</span>:<span class="toMinutes">00</span>
                    </span>
                </div>
                <div class="form_div">
                    <div class="lines">
                        <div>:</div>
                    </div>
                    <select class="date to_hours" onchange="toHourChange(this)" name="to_hours">
                        @for($i = 23; $i >= 0; $i--)
                            <option value="{{ $i < 10 ? '0'.$i : $i }}" @if(!empty($end_hours) && $end_hours == $i) selected @endif>{{ $i < 10 ? '0'.$i : $i }}</option>
                        @endfor
                    </select>
                    <select class="date to_minutes" onchange="toMinuteChange(this)" name="to_minutes">
                        @for($i = 0; $i <= 4; $i++)
                            <option value="45" @if(!empty($end_minutes) && $end_minutes == 45) selected @endif>45</option>
                            <option value="30" @if(!empty($end_minutes) && $end_minutes == 30) selected @endif>30</option>
                            <option value="15" @if(!empty($end_minutes) && $end_minutes == 15) selected @endif>15</option>
                            <option value="00"  @if(!empty($end_minutes) && $end_minutes == 0)  selected @endif>00</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
