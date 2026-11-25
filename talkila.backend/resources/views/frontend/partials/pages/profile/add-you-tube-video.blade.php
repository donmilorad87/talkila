<div class="popupBase" id="addYouTubeVideo" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => __('YOUTUBЕ_URL'),
                        'page_back_link' => "/jtc/welcome",
                        "save_button"=>"0",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'addYouTubeVideo',
                        'saveButtonText' => 'saveButtonTextEducation'
                    ]
                )

            <div class="grid-x">
                <h5 class="small-12 mt8 mb24"> {{ __('YOUTUBЕ_URL') }} </h5>
      {{--           <p class="small-12"> YouTube URL</p> --}}
                <div class="small-12">
                    <form class="" id="edit_you_tube_video">
                        <div id="_token">
                            @csrf
                        </div>
                        <div class="grid-x grid-margin-x">

                            <div class="cell small-12">
                                <div class="group">
                                    <input class="default-input name-input {{ !empty(auth()->user()->youtube_video) ? 'ok' : '' }}"
                                           type="text"
                                           name="youTubeVideo"
                                           placeholder="{{ __('PASTE_YT_VIDEO_URL_HERE') }}"
                                           required
                                           value="@if (!empty(auth()->user()->youtube_video)) {{ auth()->user()->youtube_video }} @endif"
                                           autocomplete="off" />
                                    <div class="verified-name-svg {{ !empty(auth()->user()->youtube_video) ? 'active' : '' }}">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <label class="count-label">0/50</label>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="name-warn">{{ __('YOUTUBE_LINK_REGULAR_FORMAT') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('YOUTUBЕ_URL') }}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="flex-content-right">
                        <button class="btn warning submit-button" id="editYouTubeLink">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
