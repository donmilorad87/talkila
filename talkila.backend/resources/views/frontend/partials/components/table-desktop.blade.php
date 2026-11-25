<div class="data-table-wrap">

    @php

        $start  = !empty($userLowestAvailability) ? strtotime($userLowestAvailability) : strtotime('00:00');
        $end    = !empty($userHighestAvailability) ? $userHighestAvailability === '00:00' ? strtotime('23:45') : strtotime($userHighestAvailability) : strtotime('23:45');

        function getTimeAvailabilityId($time, $ua, $day){
            $times = $time.':00';
            for($i=0; $i < count($ua); $i++){
                for($j=0; $j < count($ua[$i]); $j++){
                    if($ua[$i]['weekday'] == $day){
                        if($ua[$i]['start_time'] <= $times && $ua[$i]['end_time'] >= $times){
                            echo 'yello" data-time-slot-id="' . $ua[$i]['id'] . '"';
                            break;
                        }
                    }
                }
            }
        }

    @endphp
    <table class="bookTable">
        <thead>
            <tr>
                <th>
                </th>
                <th @if(!empty($takenTime[1])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_MONDAY_SHORT') }}</a>
                </th>
                <th @if(!empty($takenTime[2])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_TUESDAY_SHORT') }}</a>
                </th>
                <th @if(!empty($takenTime[3])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_WEDNESDAY_SHORT') }}</a>
                </th>
                <th @if(!empty($takenTime[4])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_THURSDAY_SHORT') }}</a>
                </th>
                <th @if(!empty($takenTime[5])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_FRIDAY_SHORT') }}</a>
                </th>
                <th @if(!empty($takenTime[6])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_SATURDAY_SHORT') }}</a>
                </th>
                <th @if(!empty($takenTime[7])) class="active-th" @endif >
                    <a href="#">{{ __('DAY_SUNDAY_SHORT') }}</a>
                </th>
            </tr>
        </thead>
        <tbody>

            @for($i=$start;$i<=$end;$i = $i + (15*60))

                <tr class="active">
                    <td>{{ date('H:i',$i) }}</td>
                    <td class="bg-color-{{ empty($takenTime['1']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['1']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 1)) }}" onclick="editAvailability(this)"></td>
                    <td class="bg-color-{{ empty($takenTime['2']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['2']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 2)) }}" onclick="editAvailability(this)"></td>
                    <td class="bg-color-{{ empty($takenTime['3']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['3']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 3)) }}" onclick="editAvailability(this)"></td>
                    <td class="bg-color-{{ empty($takenTime['4']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['4']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 4)) }}" onclick="editAvailability(this)"></td>
                    <td class="bg-color-{{ empty($takenTime['5']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['5']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 5)) }}" onclick="editAvailability(this)"></td>
                    <td class="bg-color-{{ empty($takenTime['6']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['6']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 6)) }}" onclick="editAvailability(this)"></td>
                    <td class="bg-color-{{ empty($takenTime['7']) ? "gray" : (in_array( date('H:i:00',$i), $takenTime['7']) ? "gray" : getTimeAvailabilityId( date('H:i',$i), $userAvailability, 7)) }}" onclick="editAvailability(this)"></td>
                </tr>
            @endfor
        </tbody>
    </table>
    <div class="available-tabs">
        <div class="yellow-text"><span></span>
            <p>{{ __('AVAILABLE_TIME') }}</p>
        </div>
        <div class="gray-text"><span></span>
            <p>{{ __('UNAVAILABLE_TIME') }}</p>
        </div>
    </div>
</div>

<input type="hidden" id="userAvailabilites" value="{{ json_encode($userAvailability2) }}">
