<div class="jcc aic desktopNavigationContainer show-for-medium-flex">
    <div class="logoCont secc df aic pt8 pb8 logoz">
        @if ($user)

            @if (! $user->partner)
                <a class="mr1rem df" href="/">
                    @include('frontend.partials.svg.icons.favicon')
                </a>
            @endif
        @else

            @if (isset($pratnerData))

            @else
                <a class="mr1rem df" href="/">
                    @include('frontend.partials.svg.icons.favicon')
                </a>
            @endif
        @endif



    </div>

    <ul class="df ov lsn jtc_navigation_tabs zi999" id="jtc_navigation_tabs">

        @if ($user)

            {{-- step1 --}}
            <a class="cblack cblackhover" href="{{ route('jtc2_create_profile') }}">
                <li
                    class="wmc @if (Route::current()->getName() === 'jtc2_create_profile') pon is-active posrelative @endif @if ($user->jtc?->step_1) completed @endif">
                    <span class="fs16">@lang('STEP_1')</span>

                </li>
            </a>

            {{-- step2 --}}
            @if ($user->jtc?->step_1)
                <a class="cblack" href="{{ route('jtc2_add_your_first_talk') }}">
            @endif

            <li
                class="wmc @if (Route::current()->getName() === 'jtc2_add_your_first_talk') pon is-active posrelative @endif @if ($user->jtc?->step_1) completed @endif">
                <span class="fs16">@lang('STEP_2')</span>

            </li>
            @if ($user->jtc?->step_1)
                </a>
            @endif

            {{-- step3 --}}
            @if ($user->jtc?->step_2)
                <a class="cblack" href="{{ route('jtc2_set_availabilities') }}">
            @endif

            <li
                class="wmc @if (Route::current()->getName() === 'jtc2_set_availabilities') pon is-active posrelative @endif @if ($user->jtc?->step_2) completed @endif">
                <span class="fs16">@lang('STEP_3')</span>

            </li>

            @if ($user->jtc?->step_2)
                </a>
            @endif

            {{-- step4 --}}
            @if ($user->jtc?->step_3)
                <a class="cblack" href="{{ route('jtc2_verify_account') }}">
            @endif

            <li
                class="wmc @if (Route::current()->getName() === 'jtc2_verify_account') pon is-active posrelative @endif  @if ($user->jtc?->step_3) completed @endif">
                <span class="fs16">@lang('STEP_4')</span>

            </li>

            @if ($user->jtc?->step_3)
                </a>
            @endif
        @else
            <a href="{{ route('jtc2_create_profile') }}">
                <li class="wmc @if (Route::current()->getName() === 'jtc2_create_profile') pon is-active posrelative @endif">
                    <span class="fs16">@lang('STEP_1')</span>

                </li>
            </a>
            <li class="wmc">
                <span class="fs16">@lang('STEP_2')</span>

            </li>
            <li class="wmc">
                <span class="fs16">@lang('STEP_3')</span>

            </li>
            <li class="wmc">
                <span class="fs16">@lang('STEP_4')</span>

            </li>
        @endif



    </ul>
</div>
