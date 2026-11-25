<section class="cell small-12">
    <div class="wrapper-video">
        {{-- @if(!empty($userData['description']))
            <h5>{{ __('ABOUT_ME') }}</h5>
            <p>
                {{ $userData['description'] }}
            </p>
        @endif --}}
        @if(!empty($userData['youtube_video']))
            <div class="inner-video">
                <h5>{{ __('VIDEO') }}</h5>
                <div class="inner-video-flex">
                    {{--                    <img class="width-video" src="{{ asset('frontend/assets/img/video-img.png') }}" alt="video img" />--}}
                    <iframe width="420" height="315" src="{{ str_replace('watch?v=', 'embed/', $userData['youtube_video']) }}" frameborder="0" allowfullscreen></iframe>
                    {{--                    <div class="play-icon">--}}
                    {{--                        @include('frontend.partials.svg.icons.play-icon')--}}
                    {{--                    </div>--}}
                </div>
            </div>
        @endif
    </div>
</section>
