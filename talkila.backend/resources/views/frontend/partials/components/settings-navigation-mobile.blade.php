<nav class="mobileNav cs16 mobileNavSettings">
    <ul>
        <li><a href="{{ route('settings_profile') }}">{{ __('PROFILE') }}</a></li>
        @if (auth()->user()->visibility === 2)
            <li><a href="{{ route('settings_following') }}">{{ __('FOLLOWINGS') }}</a></li>
        @endif

        @if ($user->blockedUsers->count() > 0 || Route::current()->getName() === 'settings_blocked_profiles')
            <li><a href="{{ route('settings_blocked_profiles') }}">{{ __('BLOCKED_USERS') }}</a></li>
        @endif


        {{-- @if ($user->type === UserRoles::TEACHER && $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved'])
            <li><a href="{{route('settings_widgets')}}">{{ __('WIDGETS') }}</a></li>
        @endif --}}


        <li><a href="{{ route('billing_ingormations') }}">{{ __('BILLING_INFORMATION') }}</a></li>

        {{-- @if ($user->state)
            <li><a href="{{ route('countryOfResidence') }}">{{ __('COUNTRY_OF_RESIDENCE') }}</a></li>
        @endif --}}
        @if ($user->pendingProfileVerificationRequest)
            @if (
                $user->type === UserRoles::TEACHER &&
                    $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved']
            )
                <li><a href="{{ route('settings_reviews') }}">{{ __('REVIEWS') }}</a></li>

                {{-- <li><a href="/settings/income">{{ __('FOOTER_LINK_INCOME') }}</a></li> --}}


                <li><a href="{{ route('settings_payouts_page') }}">{{ __('PAYOUT') }}</a></li>
            @endif
        @endif


        <li><a href="{{ route('settings_wallets') }}">{{ __('WALLET') }}</a></li>
        <li><a href="{{ route('settings_notifications') }}">{{ __('NOTIFICATIONS') }}</a></li>
        <li><a href="{{ route('settings_transaction_history') }}">{{ __('TRANSACTIONS') }}</a></li>
    </ul>
</nav>
