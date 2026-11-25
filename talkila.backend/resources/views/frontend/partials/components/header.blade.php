@if (Route::current()->getName() === 'profile')
    <h3 class="{{ $userData['blocked'] ? '' : 'dn' }} thisUserIsBlocked">@lang('THIS_USER_IS_BLOCKED')</h3>
@endif

@guest
    @if (Route::current()->getName() !== 'jtc2_create_profile')
        @if (isset($_COOKIE['partner_affiliate_started']) && !empty(isset($_COOKIE['partner_affiliate_started'])))
            <div class="bannersHeader topTopShadow">



                <div class="betaTopBanner topGreenShadow">
                    <a class="cwhite" href="{{ route('signup') }}"> @lang('PLEASE_FINISH_REGISTRATION_PROCESS') </a>





                </div>




            </div>
        @endif
    @endif


@endguest


@if (Route::current()->getName() === 'book_slot' || Route::current()->getName() === 'profile')

    @auth
        @include('frontend.partials.components.header-third')
    @endauth

    @guest
        @include('frontend.partials.components.header_one')
    @endguest
@elseif (Route::current()->getName() === 'video_conference')
    @include('frontend.partials.components.header-call')
@elseif (Route::current()->getName() === 'jtc_welcome' ||
        Route::current()->getName() === 'login' ||
        Route::current()->getName() === 'signup' ||
        Route::current()->getName() === 'forgot_password' ||
        Route::current()->getName() === 'jtc2_create_profile' ||
        Route::current()->getName() === 'jtc2_email_verification' ||
        Route::current()->getName() === 'jtc2_add_your_first_talk' ||
        Route::current()->getName() === 'jtc2_set_availabilities' ||
        Route::current()->getName() === 'jtc2_verify_account' ||
        Route::current()->getName() === 'jtc2_account_created')
    @if (Route::current()->getName() === 'jtc2_account_created')
        @include('frontend.partials.components.header-third')
    @endif
    {{-- nothing --}}
@elseif (Route::current()->getName() === 'book_slot')
    @guest
        @include('frontend.partials.components.header_one')
    @endguest

    @auth
        @include('frontend.partials.components.header-search')
    @endauth
@elseif (Route::current()->getName() === 'home')
    @guest

        @include('frontend.partials.components.header_one')
    @endguest
    @auth
        @include('frontend.partials.components.header-third')
    @endauth
@else
    @auth
        @include('frontend.partials.components.header-third')
    @endauth

    @guest
        @include('frontend.partials.components.header_one')
    @endguest
@endif
