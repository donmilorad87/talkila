<div class="popupBase cancelExtend" id="extendAnswer" data-opened="0">
    <div class="popuper ppB tac">
        <div class="grid-x talkilium">

            @include('frontend.partials.pages.video_conference.breadcrumb_extend',['pointer' => 3])

            <div class="w-100">
                <h5>@lang('SUPPLIER') <span id="teacherExAnswerFullName"></span></h5>
            </div>

            <div class="w-100">
                <img id="teacherExAnswerPicture" src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
            </div>

            <div class="w-100" id>
                <h6 id="approvedStatus"></h6>
                <p class="da w-80 m0a mb16" id="acceptContainerMesage">
                    <span>@lang('YOU_WILL_BE_ABLE_TO_EXTEND') </span>
                    <span id="extendTimeAccepted"></span> <span>{{ strtolower(__('MINUTES')) }}</span>
                    <span>@lang('AFTER_YOU_FINISH_PAYMENT')</span>
                    <span class="df aic jcc">(<b id="extendAmoutAccepted"></b>)</span>

                </p>
            </div>

            <div class="w-100" id="answerButtonCont">

                <div id="acceptedExt" class="df aic jcc">
                    <button class="btn cz" data-close-popup="extendAnswer">{{ __('OK') }}</button>
                </div>

                <div id="rejectedExt" class="df aic jcc">
                    <button class="btn m0a getcddata" data-popup="paymentPopUp">{{ __('PAYMENT') }}</button>
                </div>

            </div>

        </div>
        <span class="closeSpanPopup cancelExtend">×</span>
    </div>
</div>
