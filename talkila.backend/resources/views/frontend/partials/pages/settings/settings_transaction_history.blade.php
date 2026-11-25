<div class="grid-x setting-page white-box">
    <div class="cell setting-tabs">
        <div class="show-for-medium">
            @include('frontend.partials.components.settings-menu', ['pointer' => __('TRANSACTIONS')])
        </div>
        <div class="tabs-content p16mob">
            <div class="tabs-panel is-active" id="Profile">
                <div class="cell medium-12 large-12">
                    <div class="setting-inner">

                        <h6 class="mb25">{{ __('YOUR_WALLET_BALANCE') }}
                            {{ priceFormater($user->wallet_balance, true) }}
                        </h6>
                        <p class="subTitle">{{ __('TRANSACTION_HISTORY_DESCRIPTION') }}</p>

                        @if (isset($history_data) && !empty($history_data))
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col" class="w74px bl0bt0"></th>
                                        <th scope="col" class="w164px grayHeading">{{ __('TRANSACTION_TYPE') }}</th>
                                        <th scope="col" class="w144px grayHeading">{{ __('DATE') }}</th>
                                        <th scope="col" class="w178px grayHeading">{{ __('TRANSACTION_ID') }}</th>
                                        <th scope="col" class="w379px grayHeading">{{ __('CREDIT_CARD_DETAILS') }}</th>
                                        <th scope="col" class="w68px grayHeading">{{ __('COINS') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($history_data['transactions'] as $history)

                                        <tr @if (!empty($history['booking_id']) && $history['payment_type'] ===  \App\Models\WalletHistory::PAYMENT['paid_with_credit_card']) data-booking="{{ route('booking_details', ['id' => $history['booking_id']]) }}" @endif
                                        class="table-inner-heading transactionHistoryLink @if (!empty($history['booking_id']) && $history['payment_type'] === \App\Models\WalletHistory::PAYMENT['paid_with_credit_card']) cpointer @endif">
                                            @if ($history['transaction_type'] == 'debit' || $history['transaction_type'] == 'extend')

                                                <td class="w74px">

                                                    @include('frontend.partials.components.payment_history_icon',[
                                                        'payment_type' => $history['payment_type']
                                                    ])


                                                </td>
                                                <td scope="row" data-label="Transaction type" class="w164px">
                                                    @include('frontend.partials.pages.settings.transaction_type_switch', [
                                                        'transaction_type' => $history['source']
                                                    ])
                                                </td>
                                                <td data-label="Date" class="w144px">
                                                    {{ changeDateFormatLocale('Y-m-d H:i:s', getTimeZonedDate('Y-m-d H:i:s', $history['date'])) }}
                                                    {{ getTimeZonedDate('H:i', $history['date']) }}
                                                </td>
                                                <td data-label="Transaction ID" class="w178px">
                                                    @if (!empty($history['booking_id']))
                                                        {{ __('BOOKING_DETAILS') }}:
                                                        <a href="{{ route('booking_details', [$history['booking_id']]) }}">
                                                            {{ $history['talk_name'] }}
                                                        </a>
                                                    @endif
                                                </td>

                                                <td data-label="Credit Card Details" class="w379px">
                                                    {{ __('INTERNAL_TALKILA_TRANSACTION_WITH_COINS') }}
                                                </td>
                                            @else

                                                <td class="w74px">

                                                    @include('frontend.partials.components.payment_history_icon',['payment_type' => $history['payment_type']])

                                                </td>

                                                <td scope="row" data-label="Transaction type" class="w164px">
                                                    @include('frontend.partials.pages.settings.transaction_type_switch', ['transaction_type' => $history['source']])
                                                </td>

                                                <td data-label="Date" class="w144px">
                                                    {{ changeDateFormatLocale('Y-m-d H:i:s', getTimeZonedDate('Y-m-d H:i:s', $history['date']), $_COOKIE['activeLang']) }}
                                                    {{ getTimeZonedDate('H:i', $history['date']) }}
                                                </td>
                                                <td data-label="Transaction ID" class="w178px">

                                                    <div>
                                                        @lang('REFERENCE') @lang('ID')
                                                        {{ $history['transaction_id'] }}
                                                    </div>
                                                </td>

                                                @if ($history['payment_type'] === \App\Models\WalletHistory::PAYMENT['paid_with_wallet'] || $history['payment_type'] === \App\Models\WalletHistory::PAYMENT['coins_bought_credit_card'])

                                                    <td data-label="Credit Card Details" class="w379px">
                                                        {{ __('Card Holder Name:') }}
                                                        {{ $history['card_holder_name'] }}
                                                        <br>{{ __('Card Expiry:') }}
                                                        {{ $history['card_expiry'] }}
                                                        <br>{{ __('Card Type:') }}
                                                        @include('frontend.partials.pages.settings.transaction-card-icons',
                                                            ['cardBrand' => $history['card_type']]){{ ' * ' . $history['card_number'] }}
                                                    </td>
                                                @elseif($history['payment_type'] === \App\Models\WalletHistory::PAYMENT['coins_bought_paypal'])

                                                    <td data-label="Credit Card Details" class="w379px">
                                                        {{ __('YOU_CAN_SEE_CREDIT_CARD_DETAILS') }}</td>

                                                @elseif($history['source'] === \App\Models\WalletHistory::PAYMENT['refund_coins'])
                                                    <td data-label="Credit Card Details" class="w379px">
                                                        {{ __('COINS_REFUND_POSTPONE_TEXT') }}</td>
                                                @endif
                                            @endif

                                            <td data-label="Coins"
                                                class="w68px
                                                {{ $history['transaction_type'] == 'debit' || $history['transaction_type'] == 'extend' ? 'payout-red' : 'payout-green' }}
                                                ">
                                                <div class="tac">

                                                    @if ($history['transaction_type'] == 'debit' || $history['transaction_type'] == 'extend')
                                                        {{ $history['amount'] }}
                                                    @else
                                                        {{ $history['amount'] }}
                                                    @endif</div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="not-found text-center">
                                <img src="{{ asset('frontend/assets/img/payout.png') }}" alt="user" />
                                <h5>{{ __('NO_TRANSACTIONS') }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
