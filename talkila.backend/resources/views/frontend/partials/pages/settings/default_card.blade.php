<div class="popupBase" id="defaultStripeCardPopUp" data-opened="0">
    <div class="popuper ppR">
        <div class="credit-model">
            <h5 class="text-center">{{ __('Are you sure want to default this card?') }}</h5>
            <div class="grid-x">
                @if(!empty($defaultCardData))
                    <input type="hidden" name="default_card_id" id="default_card_id" value="{{ $defaultCardData['card_id'] }}">
                @else
                    <input type="hidden" name="default_card_id" id="default_card_id" value="">
                @endif
                <input type="hidden" name="new_default_card_id" id="new_default_card_id" value="">
                <button class="button cancelbtn canceldefaultcard lh48" type="button">@lang('CANCEL')</button>
                <button class="button deletebtn makedefaultcard lh48" type="button">@lang('OK')</button>
            </div>
        </div>
    </div>
</div>
