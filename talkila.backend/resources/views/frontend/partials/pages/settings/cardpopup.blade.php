<div id="carderPopuper">
    <div class="popupBase" id="cardPopUp" data-opened="0">
        <div class="popuper ppR">
            <div class="addCreditCardModal">

                <h5 class="tac">@lang('ADD_CARD_DETAIL')</h5>

                <div class="hiddenDiv" id="creditCardMesasge"></div>

                    <input type="hidden" name="payment_method" class="payment-method">

                    <div class="group mt32">

                        <input type="text" class="StripeElement default-input fw300" name="card_holder_name" id="card_holder_name" required autocomplete="off" />
                        <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                        <label class="count-label">0/50</label>
                        <label class="default-warn">@lang('STEP')</label>
                        <span class="bar"></span>
                        <label class="input-label">@lang('CARDHOLDER_NAME')</label>

                    </div>

                    <div id="card-element" class="bwhite"></div>

                    <div id="card-errors" role="alert"></div>

                    <button class="btn w-100 lh24" id="submitAddCreditCard">@lang('ADD_CARD_DETAIL')</button>

                @if (session('message'))
                    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif

                <input type="hidden" id="userCardsIntent" value="{{ $user_cards['intent'] ?? '' }}" />

            </div>

            <span class="closeSpanPopup">×</span>

        </div>
    </div>





</div>
