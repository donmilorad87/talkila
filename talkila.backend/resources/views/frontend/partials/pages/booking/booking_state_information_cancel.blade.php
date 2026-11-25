<div class="w-100 df fdc {{$badgeClass}}">
    <div class="df jcsb">
        <p class="m0">
            @lang('CANCELATION REASON'):
        </p>
        <p class="m0">
            {{$cancellation_reason}}
        </p>
    </div>
    <div class="df">
        <p class="mla m0s">
            {{changeDateFormatLocale('Y-m-d H:i:s', $cancel_date, true) . ' ' . changeDateStringFormat('Y-m-d H:i:s', 'H:i', $cancel_date)}}
        </p>
    </div>
</div>
