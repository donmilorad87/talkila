@php
    $displayedDates = [];
@endphp

@foreach($notificationsData['notifications'] as $item)
    @php
        $notificationDate   = date('Y-m-d', strtotime($item['pushed_at']));
    @endphp
    @if($notificationDate  == date('Y-m-d') && empty($displayedDates[$notificationDate]))
        <h6>Today</h6>
    @else
        @if(empty($displayedDates[$notificationDate]))
            <h6 style="margin-top: 10px; margin-bottom: 5px;">{{ date('F j Y', strtotime($item['pushed_at'])) }}</h6>
        @endif
    @endif

    @if(in_array($item['values'], $haveRedirects))
        <a href="{{ route('notification_redirect', ['notification' => $item]) }}">
    @endif
        <div class="notificatoin-box">

            <small>{{date('H:i', strtotime($item['pushed_at']))}}</small>
            @if ($item['profile_picture'])
                <img id="profile-img" width="32" src="{{ $item['profile_picture'] }}"
                alt="{{$item['payload']['name_of_talk'] ?? 'notification'}}" />
            @else
                @include('frontend.partials.svg.icons.placeholder-profile')
            @endif
            <p>
                @if(!empty($item['payload']) && isset($item['payload']['name_of_talk']))
                    <strong>{{$item['payload']['name_of_talk']}}</strong>
                @endif
                {{$item['message']}}
            </p>
        </div>
    @if(in_array($item['values'], $haveRedirects))
        </a>
    @endif

    @php
        $displayedDates[$notificationDate]  = true;
    @endphp
@endforeach
