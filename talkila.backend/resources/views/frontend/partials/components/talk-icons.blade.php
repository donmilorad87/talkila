<ul class="iconsSearchItem">
    @if ($call_type == CallTypes::ONE_TO_ONE)
        <li>@include('frontend.partials.svg.icons.schollar_cap') {{ __('PRIVATE_TALK') }}</li>
    @elseif ($call_type == CallTypes::GROUP)
        <li>@include('frontend.partials.svg.icons.chat-users') {{ __('GALLERY_TALK') }}</li>
    @endif

    <li class="phoneIcon {{ $talk_type == TalkTypes::VOICE_CALL ? 'df' : 'dn' }}">
        @include('frontend.partials.svg.icons.phone') {{ __('PROFILE_PHONE') }}</li>


    <li class="cameraIcon {{ $talk_type == TalkTypes::VIDEO_CALL ? 'df' : 'dn' }}">
        @include('frontend.partials.svg.icons.video-camera') {{ __('VIDEO_TALK') }}</li>


    <li class="annonContainer {{ isset($is_anonymous_allowed) && $is_anonymous_allowed == 1 ? 'df' : 'dn' }}">
        @include('frontend.partials.svg.icons.anonymous')
        {{ __('ANONS_ALLOWED') }}
    </li>



</ul>
