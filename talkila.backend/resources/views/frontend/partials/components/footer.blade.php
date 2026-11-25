@if (Route::current()->getName() === 'settings_transaction_history' ||
        Route::current()->getName() === 'settings_notifications' ||
        Route::current()->getName() === 'settings_wallets' ||
        Route::current()->getName() === 'settings_payouts_page' ||
        Route::current()->getName() === 'settings_reviews' ||
        Route::current()->getName() === 'countryOfResidence' ||
        Route::current()->getName() === 'billing_ingormations' ||
        Route::current()->getName() === 'settings_widgets' ||
        Route::current()->getName() === 'settings_profile' ||
        Route::current()->getName() === 'favorites_users' ||
        Route::current()->getName() === 'favorites_talks' ||
        Route::current()->getName() === 'booking' ||
        Route::current()->getName() === 'logged_in' ||
        Route::current()->getName() === 'home' ||
        Route::current()->getName() === 'courses' ||
        Route::current()->getName() === 'talkCategory' ||
        Route::current()->getName() === 'talkCategorySubcategory' ||

        Route::current()->getName() === 'account_verification' ||
        Route::current()->getName() === 'courses_all' ||
        Route::current()->getName() === 'profile' ||
        Route::current()->getName() === 'about_me')
    @auth
        @include('frontend.partials.components.footer-seccond')
        @include('frontend.partials.components.mobile-menu')
    @endauth

    @guest
        @include('frontend.partials.components.logged_out_footer')
    @endguest
@elseif (Route::current()->getName() === 'jtc2_create_profile' ||
        Route::current()->getName() === 'jtc2_email_verification' ||
        Route::current()->getName() === 'jtc2_add_your_first_talk' ||
        Route::current()->getName() === 'jtc2_set_availabilities' ||
        Route::current()->getName() === 'jtc2_verify_account' ||
        Route::current()->getName() === 'jtc2_account_created')

   @if (Route::current()->getName() === 'jtc2_account_created')
        @include('frontend.partials.components.footer-seccond')
    @else
        @include('frontend.partials.components.mobile-menu2')
    @endif

@elseif (Route::current()->getName() === 'video_conference')

@else
    @auth

        @if (
                Route::current()->getName() === 'jtc2_create_profile' ||
                Route::current()->getName() === 'jtc2_email_verification' ||
                Route::current()->getName() === 'jtc2_add_your_first_talk' ||
                Route::current()->getName() === 'jtc2_set_availabilities' ||
                Route::current()->getName() === 'jtc2_verify_account' ||
                Route::current()->getName() === 'jtc2_account_created'||
                Route::current()->getName() === 'video_conference'
            )
        @else
            @include('frontend.partials.components.footer-seccond')
        @endif


    @endauth

    @guest
        @if (Route::current()->getName() === 'forgot_password' ||
                Route::current()->getName() === 'signup' ||
                Route::current()->getName() === 'login')
            @include('frontend.partials.components.footer-seccond')
        @else
            @include('frontend.partials.components.logged_out_footer')
        @endif

    @endguest
@endif
