<div class="popupBase" id="videoPopup" data-opened="0">
    <div class="popuper ppB">
        <div class="grid-x">
            <input type="hidden" id="youTubeIframe" value='<iframe width="420" height="315" src="{{ str_replace('watch?v=', 'embed/', $userData['youtube_video']) }}" frameborder="0" allowfullscreen></iframe>'>
            <div class="inner-video">
                <h5>{{ __('VIDEO') }}</h5>
                <div class="inner-video-flex" id="innerVideoContainer">

                </div>
            </div>

        </div>
        <span class="closinger">×</span>
    </div>
</div>
