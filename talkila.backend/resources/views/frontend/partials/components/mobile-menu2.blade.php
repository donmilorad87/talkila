<div class="footer-tabs">

    <ul class="tabs tabs-menu-footer w-100">

        @if ($user)
            <li class="w-25 tabs-title {{Route::current()->getName() === 'jtc2_create_profile' ? 'is-active pon' : ''}}">
                <a href="{{ route('jtc2_create_profile') }}">
                    <p>@include('frontend.partials.svg.icons.mobile-icon-settings')</p> {{ __('CREATE_PROFILE') }}
                </a>

            </li>

            <li class="w-25 tabs-title {{Route::current()->getName() === 'jtc2_add_your_first_talk' ? 'is-active pon' : ($user->jtc?->step_1 ? '' : 'pon disabled' )}}">
                <a href="{{ route('jtc2_add_your_first_talk') }}">
                    <p>@include('frontend.partials.svg.icons.message_lines')</p> {{ __('ADD_TALKS') }}
                </a></li>

            <li class="w-25 tabs-title {{Route::current()->getName() === 'jtc2_set_availabilities' ? 'is-active pon' : ($user->jtc?->step_2 ? '' : 'pon disabled' )}}">
                <a href="{{ route('jtc2_set_availabilities') }}">
                    <p>@include('frontend.partials.svg.icons.alarm_check')</p> @lang('AVAILABILITY')
                </a>
            </li>
            <li class="w-25 tabs-title {{Route::current()->getName() === 'jtc2_verify_account' ? 'is-active pon' : ($user->jtc?->step_3 ? '' : 'pon disabled' )}}">
                <a href="{{ route('jtc2_verify_account') }}">
                    <p>@include('frontend.partials.svg.icons.security_checked')</p> @lang('VERIFY_ACCOUNT')
                </a>

            </li>

        @else

            <li class="w-25 tabs-title is-active">
                <a href="{{ route('jtc2_create_profile') }}" class="pon">
                    <p>@include('frontend.partials.svg.icons.mobile-icon-settings')</p> {{ __('CREATE_PROFILE') }}
                </a>
            </li>

            <li class="w-25 tabs-title disabled pon"><a href="{{ route('jtc2_add_your_first_talk') }}">
                    <p>@include('frontend.partials.svg.icons.message_lines')</p>{{ __('ADD_TALKS') }}
                </a></li>
            <li class="w-25 tabs-title disabled pon">
                <a href="{{ route('jtc2_set_availabilities') }}">
                    <p>@include('frontend.partials.svg.icons.alarm_check')</p> @lang('AVAILABILITY')
                </a>
            </li>
            <li class="w-25 tabs-title disabled pon">
                <a href="{{ route('jtc2_verify_account') }}">
                    <p>@include('frontend.partials.svg.icons.security_checked')</p> @lang('VERIFY_ACCOUNT')
                </a>

            </li>

        @endif

    </ul>
</div>
