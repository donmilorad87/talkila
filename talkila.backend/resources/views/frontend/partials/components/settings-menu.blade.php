<ul class="mb24 mainHeaderSettings mainHeaderSettings2 mt8 w-100">
    <li class="tabs-title @if ($pointer === __('PROFILE')) is-active @endif">
        <a href="/settings/profile">
            {{ __('PROFILE') }}
        </a>
    </li>


    @if ($user->blockedUsers->count() > 0 || Route::current()->getName() === 'settings_blocked_profiles')
        <li class="tabs-title @if ($pointer === __('BLOCKED_USERS') || Route::current()->getName() === 'settings_blocked_profiles') is-active @endif">
            <a href="{{ route('settings_blocked_profiles') }}">
                {{ __('BLOCKED_USERS') }}
            </a>
        </li>
    @endif

    @if (auth()->user()->visibility === 2)
        <li class="tabs-title @if ($pointer === __('FOLLOWING')) is-active @endif">
            <a href="{{ route('settings_following') }}">
                {{ __('FOLLOWING') }}
            </a>
        </li>
    @endif

    {{--    @if (auth()->user()->jtc?->state) --}}
    {{--        <li class="tabs-title @if ($pointer === __('WIDGETS')) is-active @endif"> --}}
    {{--            <a href="/settings/widgets"> --}}
    {{--                {{ __('WIDGETS') }} --}}
    {{--            </a> --}}
    {{--        </li> --}}
    {{--    @endif --}}

    <li class="tabs-title @if ($pointer === __('BILLING_INFORMATION')) is-active @endif">
        <a href="/settings/billing-informations">
            {{ __('BILLING_INFORMATION') }}
        </a>
    </li>


    {{--    @if (auth()->user()->jtc?->state) --}}
    {{--  <li class="tabs-title @if ($pointer === __('COUNTRY_OF_RESIDENCE')) is-active @endif">
            <a href="{{ route('countryOfResidence') }}">
                {{ __('COUNTRY_OF_RESIDENCE') }}
            </a>
        </li> --}}
    {{--    @endif --}}

    @if (auth()->user()->jtc?->state)
        <li class="tabs-title @if ($pointer === __('FOOTER_LINK_REVIEWS')) is-active @endif">
            <a href="/settings/reviews">
                {{ __('FOOTER_LINK_REVIEWS') }}
            </a>
        </li>
    @endif

    @if (auth()->user()->jtc?->state)
        <li class="tabs-title @if ($pointer === __('PAYOUT')) is-active @endif">
            <a href="/settings/payout">
                {{ __('PAYOUT') }}
            </a>
        </li>
    @endif
    <li class="tabs-title @if ($pointer === __('WALLET')) is-active @endif"><a
            href="/settings/wallets">{{ __('WALLET') }}</a></li>
    <li class="tabs-title @if ($pointer === __('NOTIFICATIONS')) is-active @endif"><a
            href="/settings/notifications">{{ __('NOTIFICATIONS') }}</a></li>
    <li class="tabs-title @if ($pointer === __('TRANSACTIONS')) is-active @endif"><a
            href="{{route('settings_transaction_history')}}">{{ __('TRANSACTIONS') }}</a></li>
</ul>
