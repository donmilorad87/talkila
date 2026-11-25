<div class="position-span">
    <div class=" optionButton oButtonVideoCall" data-opened="0">
        @include('frontend.partials.svg.icons.v-dots')
        <ul class="dropdown-menu-field">
            <li class="muteCall">@include('frontend.partials.svg.icons.no-audio') <span>{{ __('MUTE_USER') }}</span></li>
            <li class="turnOffVideo" data-video="1">@include('frontend.partials.svg.icons.no-video') <span>{{ __('TURN_OFF_VIDEO') }}</span></li>
            <li class="pinStudent" data-pinned="0">@include('frontend.partials.svg.icons.pin') <span> {{ __('PIN_USER') }} </span></li>
        </ul>
    </div>
</div>