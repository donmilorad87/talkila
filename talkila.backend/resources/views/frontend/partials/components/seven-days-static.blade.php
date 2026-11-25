<div class="st-filed-wrap w-100 fl">
    <h5>{{ __('SELECT_DAY') }}</h5>
    <div class="date-scheduler-wrap">
        <div @if(empty($requestedTalk['weekday']) || $requestedTalk['weekday'] == 1) class="active" @endif data-index="1"> {{ __('DAY_MONDAY_SHORT') }} </div>
        <div @if(!empty($requestedTalk['weekday']) && $requestedTalk['weekday'] == 2) class="active" @endif data-index="2"> {{ __('DAY_TUESDAY_SHORT') }} </div>
        <div @if(!empty($requestedTalk['weekday']) && $requestedTalk['weekday'] == 3) class="active" @endif data-index="3"> {{ __('DAY_WEDNESDAY_SHORT') }} </div>
        <div @if(!empty($requestedTalk['weekday']) && $requestedTalk['weekday'] == 4) class="active" @endif data-index="4"> {{ __('DAY_THURSDAY_SHORT') }} </div>
        <div @if(!empty($requestedTalk['weekday']) && $requestedTalk['weekday'] == 5) class="active" @endif data-index="5"> {{ __('DAY_FRIDAY_SHORT') }} </div>
        <div @if(!empty($requestedTalk['weekday']) && $requestedTalk['weekday'] == 6) class="active" @endif data-index="6"> {{ __('DAY_SATURDAY_SHORT') }} </div>
        <div @if(!empty($requestedTalk['weekday']) && $requestedTalk['weekday'] == 7) class="active" @endif data-index="7"> {{ __('DAY_SUNDAY_SHORT') }} </div>
    </div>
</div>
