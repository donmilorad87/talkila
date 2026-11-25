

@switch($transaction_type)
    @case(0)
        @lang('TALK_PAYMENT')
        @break
    @case(1)
        @lang('REFUND')
        @break
    @case(2)
        @lang('POSTPONE')
        @break
    @case(3)
        @lang('WALLET_TRANSACTION')
        @break
    @case(4)
        @lang('PAYOUT')
        @break
    @case(5)
        @lang('EXTENSION')
        @break
@endswitch
