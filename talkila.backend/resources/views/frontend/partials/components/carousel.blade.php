@if (!empty($suggestedUsers))

    <div id="suggestedProfilesDesk" class="owl-carousel owl-theme @if (count($suggestedUsers) > 2) {{ $classCarousel }} @else{{ $idCarousel2 }} @endif">
        @foreach ($suggestedUsers as $item)
            <div class="itemInner">

                <div class="card-divider d-flex ">
                    <div class="users-title">@include('frontend.partials.svg.icons.user-black')
                        {{ !empty($item['total_followers']) ? $item['total_followers'] : 0 }} </div>

                </div>

                <div class="card-section text-center">
                    <a href="{{ route('profile', $item['username']) }}">
                        @if (isset($item['profile_picture']) && !empty($item['profile_picture']))
                            <img class="imagePicRadius" src="{{ $item['profile_picture'] }}" alt="user" />
                        @else
                            <div class="noImgSvg">
                                @include('frontend.partials.svg.icons.no-profile-picture')
                            </div>
                        @endif
                        <h6>{{ $item['username'] }}</h6>
                        <p class="m0">{{ $item['name'] }}</p>
                    </a>
                    <p class="profession">
                        {{ $item['first_talk_category'] }}
                    </p>
                    <a href="{{ route('user-follow', $item['id']) }}">
                        <div class="w-60 m0a maxw96">
                            <span class="btn">
                                {{ __('FOLLOW') }}
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@endif
