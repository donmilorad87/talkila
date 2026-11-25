<div class="popupBase" id="extendTeacherAnswer" data-opened="0">
    <div class="popuper ppR">
        <div class="grid-x tac">
            <div class="w-100">
                <h5>{{ __('TALK_EXTEND') }}</h5>
            </div>
            <div class="w-100">
                <img id="pictureEx" src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
            </div>
            <div class="w-100">
                <h6 id="studentNameEx">Jessica Jefferson</h6>
                <p><span id="studentNameEx2">Jessica Jefferson</span> would like to extend this call for <b id="extendedTimeAmout"></b>m of time and <b id="extendAmountMoney"></b>€. Text explaining the option here.</p>
            </div>
            <div class="w-100 df jcsa">
                <button class="btn extendAnswerTrue" data-popup="extendAnswer">{{ __('I_ACCEPT') }}</button>
                <button class="btn hollow extendAnswerFalse" data-popup="extendAnswer">{{ __('CANCEL') }}</button>
            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
