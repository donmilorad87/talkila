<div class="popupBase" id="extendAnswerAwait" data-opened="0">
    <div class="popuper ppBbb tac">
        <div class="grid-x talkilium">

             @include('frontend.partials.pages.video_conference.breadcrumb_extend',['pointer' => 2])

            <div class="w-100">

                <canvas id="loadingCanvas2"></canvas>
            </div>
            <div class="w-100">
                <h4>{{ __('AWAITING_SUPPLIER_APROVAL') }}</h4>
                <p>{{ __('TALK_SELECTED_AMOUT_MESSAGE') }}</p>
            </div>
          {{--   <div class="w-100">
                <button class="btn hollow">{{ __('CANCEL') }}</button>
            </div> --}}
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
