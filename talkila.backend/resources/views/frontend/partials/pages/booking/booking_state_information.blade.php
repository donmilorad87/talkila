<div class="w-100 df fdc {{$badgeClass}}">
    <div class="df jcsb">
        <p class="m0">
            @lang('POSTPONED')
        </p>
        <p class="m0">
            {{changeDateFormatLocale('Y-m-d H:i:s', $start_call, true) . ' ' . changeDateStringFormat('Y-m-d H:i:s', 'H:i', $start_call) . ' - ' . changeDateStringFormat('Y-m-d H:i:s', 'H:i', $end_call)}}
        </p>
    </div>
    <div class="df">
        <p class="mla m0s">
            {{changeDateFormatLocale('Y-m-d H:i:s', $postponed_start_call, true) . ' ' . changeDateStringFormat('Y-m-d H:i:s', 'H:i', $postponed_start_call) . ' - ' . changeDateStringFormat('Y-m-d H:i:s', 'H:i', $postponed_end_call)}}
        </p>
    </div>
</div>
