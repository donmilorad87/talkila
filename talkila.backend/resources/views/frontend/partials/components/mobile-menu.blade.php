<div class="footer-tabs">

    <ul class="tabs tabs-menu-footer w-100">

        <li class="w-25 tabs-title @if (Route::current()->getName() == 'logged_in' ||
                Route::current()->getName() == 'home') is-active @endif">

            @if ($user->pendingProfileVerificationRequest)
                @if (
                    $user->type === UserRoles::TEACHER &&
                        in_array($user->pendingProfileVerificationRequest->status, [
                            \App\Models\UserVerificationRequests::STATE['pending'],
                            \App\Models\UserVerificationRequests::STATE['approved'],
                        ]))
                    <a href="{{ route('home') }}">
                        <p class="p0">
                            @include('frontend.partials.svg.icons.favicon')
                        </p>

                        @lang('HOME')
                    @else
                        <a href="{{ route('jtc_welcome') }}">
                            <p class="seventhSmallerDivProfile">
                                @include('frontend.partials.svg.icons.favicon_std_color')
                            </p>
                            @lang('JOIN')
                @endif
            @else
                <a href="{{ route('jtc_welcome') }}">
                    <p class="seventhSmallerDivProfile">
                        @include('frontend.partials.svg.icons.favicon_std_color')
                    </p>
                    @lang('JOIN')
            @endif








            </a>
        </li>

        <li class="w-25 tabs-title @if (Route::current()->getName() == 'booking') is-active @endif"><a href="{{ route('booking') }}">
                <p>@include('frontend.partials.svg.icons.mobile-icon-booking')</p> {{ __('BOOKINGS') }}
            </a>
        </li>
        <li class="w-25 tabs-title @if (Route::current()->getName() == 'courses' ||
                Route::current()->getName() == 'courses_all' ||
                Route::current()->getName() == 'talkCategorySubcategory' ||
                Route::current()->getName() == 'talkCategory') is-active @endif"><a href="{{ route('courses') }}">
                <p>@include('frontend.partials.svg.icons.mobile-icon-search')</p> {{ __('SEARCH') }}
            </a></li>
        <li class="w-25 tabs-title @if (Route::current()->getName() == 'favorites_users' || Route::current()->getName() == 'favorites_talks') is-active @endif"><a
                href="{{ route('favorites_talks') }}">
                <p>@include('frontend.partials.svg.icons.mobile-icon-favorites')</p> {{ __('BOOKMARKS') }}
            </a>
        </li>
        <li
            class="w-25 tabs-title @if (Route::current()->getName() === 'settings_profile') is-active pen
            @elseif (Route::current()->getName() === 'settings_widgets' ||
                    Route::current()->getName() === 'billing_ingormations' ||
                    Route::current()->getName() === 'countryOfResidence' ||
                    Route::current()->getName() === 'settings_reviews' ||
                    Route::current()->getName() === 'settings_payouts_page' ||
                    Route::current()->getName() === 'settings_wallets' ||
                    Route::current()->getName() === 'settings_notifications' ||
                    Route::current()->getName() === 'settings_transaction_history') settingsTabMobileMenu is-active openSettingsNav @endif">
            <a href="{{ route('settings_profile') }}">
                <p>@include('frontend.partials.svg.icons.mobile-icon-settings')</p> {{ __('SETTINGS') }}
            </a>
            <script>
                if (document.getElementsByClassName('openSettingsNav')[0]) {
                    document.getElementsByClassName('openSettingsNav')[0].addEventListener('click', function(e) {
                        e.preventDefault()
                        document.getElementsByClassName('menuIcon')[0].click()
                    })
                }
            </script>
        </li>
    </ul>
</div>
