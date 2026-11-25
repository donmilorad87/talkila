@if (isset($userData['profile_picture']) && !empty($userData['profile_picture']))
    <div class="posrelative">
        @auth
            @if ($userData['id'] !== $user->id)
                <div class="bwhite posOptons r1rem">
                    {{-- @include('frontend.partials.components.notifications') --}}
                    <div class="optionButton" data-opened="0">
                        {{-- @include('frontend.partials.svg.icons.v-dots') --}}
                        @include('frontend.partials.svg.icons.three_dots')
                        <ul>
                            <li class="noselect userBlcok cp"
                                @if ($userData['blocked']) onclick="userUnblock(this)" @else onclick="userBlock(this)" @endif
                                data-user-id="{{ $userData['id'] }}">
                                @if ($userData['blocked'])
                                    {{ __('UNBLOCK') }}
                                @else
                                    {{ __('BLOCK') }}
                                @endif
                            </li>
                            <li class="noselect cp"> {{ __('REPORT') . ' ' . __('USER') }} </li>
                            <li class="noselect cp"> {{ __('CANCEL') }}</li>
                        </ul>
                    </div>

                </div>
            @endif

        @endauth
        <div class="imageOfProfile m1dot5rem">
            <img src="{{ $userData['profile_picture'] }}" alt="{{ $userData['username'] }}" />
        </div>
        @if (!empty($userData['youtube_video']))
            <div class="playButtonProfile">
                @include('frontend.partials.svg.icons.play_button')
                @include('frontend.partials.pages.profile.video_popup')
            </div>
        @endif
    </div>
@else
    <div class="posrelative">
        @auth
        @if ($userData['id'] !== $user->id)
            <div class="bwhite posOptons r1rem">
                {{-- @include('frontend.partials.components.notifications') --}}
                <div class="optionButton" data-opened="0">
                    {{-- @include('frontend.partials.svg.icons.v-dots') --}}
                    @include('frontend.partials.svg.icons.three_dots')
                    <ul>
                        <li class="noselect userBlcok cp"
                            @if ($userData['blocked']) onclick="userUnblock(this)" @else onclick="userBlock(this)" @endif
                            data-user-id="{{ $userData['id'] }}">
                            @if ($userData['blocked'])
                                {{ __('UNBLOCK') }}
                            @else
                                {{ __('BLOCK') }}
                            @endif
                        </li>
                        <li class="noselect cp"> {{ __('REPORT') . ' ' . __('USER') }} </li>
                        <li class="noselect cp"> {{ __('CANCEL') }}</li>
                    </ul>
                </div>

            </div>
        @endif

    @endauth
        <div class="imageOfProfile">
            @include('frontend.partials.svg.icons.no_profile_bigger')
        </div>
        @if (!empty($userData['youtube_video']))
            <div class="playButtonProfile">
                @include('frontend.partials.svg.icons.play_button')
                @include('frontend.partials.pages.profile.video_popup')
            </div>
        @endif
    </div>

@endif


<div class="m1dot5rem">

    <div class="df aic">
        <h4 class="m0 mr8 usernameProfile">
            {{ $userData['name'] }}
        </h4>
        @include('frontend.partials.svg.icons.blue_checkmark')
    </div>


</div>
