
<section class="cell small-12">
    <div class="wrapper-video">

        @if(!empty(auth()->user()->youtube_video))
            <div class="inner-video">
                <h5>{{ __('VIDEO') }}</h5>
                <div class="inner-video-flex yTV">
                    <iframe
                        width="420"
                        height="315"
                        src="{{ str_replace('watch?v=', 'embed/', auth()->user()->youtube_video) }}"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>

                </div>
            </div>
        @endif
    </div>
</section>
