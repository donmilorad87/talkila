<div class="popupBase" id="errorPopup" data-opened="0">
    <div class="popuper ppR">

        <div class="w-100 fl">
            <div class="fl w-20 errorWarn df br6">

                @include('frontend.partials.svg.icons.talkila-x-white')

            </div>

            <div class="fl w-80 pl32">
                <h6 id="errorMsgtitle"> Jessica Jefferson</h6>
                <p id="errorMsgText"> {{ __('CAMERA_ERROR_MESSAGE_1') }} </p>
                <p id="errorMsgAdvice"> {{ __('CAMERA_ERROR_MESSAGE_2') }} </p>
            </div>
            <div class="w-100 fl mt16">
            <button class="btn w-100 hollow mt32 closeSpanPopups closePopup m0 buttonErrorPopup" data-close-popup='errorPopup'>{{ __('OK') }}</button>
        </div>
        </div>



        <span class="closeSpanPopup">×</span>
    </div>
</div>
