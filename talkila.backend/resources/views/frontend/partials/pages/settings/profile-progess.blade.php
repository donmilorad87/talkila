@php
    if(isset($loggedUserData) && !empty($loggedUserData)){
        $loggedinUserDatas = $loggedUserData;
    }
@endphp
<div class="profile-wrapper">
    <h4>{{ __('YOUR_PROFILE_PROGRES') }}</h4>
    @if($loggedinUserDatas['approved'])
        <h4 class="verified"><span>@include('frontend.partials.svg.icons.talkila-white')</span> {{ __('ACCOUNT_VERIFIED') }}</h4>
    @endif
    <ul>
{{--        @if(!empty($loggedUserData['approved']))--}}
{{--            <li><span>--}}
{{--                    @include('frontend.partials.svg.icons.user-grey') Identity Verified </span>--}}
{{--                <p>@include('frontend.partials.svg.icons.uncheck')</p>--}}
{{--            </li>--}}
{{--        @else--}}
{{--            <li><span>--}}
{{--                    @include('frontend.partials.svg.icons.user-grey') Identity Verified </span>--}}
{{--                <p>@include('frontend.partials.svg.icons.uncheck')</p>--}}
{{--            </li>--}}
{{--        @endif--}}
{{--        <li>--}}
{{--            <a href="/account-verification" class='p0m0 posrelative fl w-100'>--}}
{{--                <span class="pending">--}}
{{--                    @include('frontend.partials.svg.icons.user-pending') Identity Verify Pending </span>--}}
{{--                <p class="posabsolute t0r0">@include('frontend.partials.svg.icons.pending-answer')</p>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li class="verified"><span>@include('frontend.partials.svg.icons.email-yellow') {{ __('VERIFIED') }}</span>
            <p>@include('frontend.partials.svg.icons.check')</p>
        </li>
{{--        <li class="verified"><span>@include('frontend.partials.svg.icons.call-yellow') {{ __('PHOTE_VERIFIED') }}</span>--}}
{{--            <p>@include('frontend.partials.svg.icons.check')</p>--}}
{{--        </li>--}}
        @if(!empty($userPayoutMethods['paypal_email']))
            <li class="verified">
                <span>@include('frontend.partials.svg.icons.paypal-grey') {{ __('PAYPAL_VERIFIED') }} </span>
                <p>@include('frontend.partials.svg.icons.check')</p>
            </li>
        @else
            <li>
                <span>@include('frontend.partials.svg.icons.paypal-grey') {{ __('PHOTE_VERIFIED') }} </span>
                <p>@include('frontend.partials.svg.icons.uncheck')</p>
            </li>
        @endif
    </ul>
    @if (Route::current()->getName() !== 'account_verification')
        @if(!$loggedinUserDatas['approved'])
            <a class="btn cp" href="{{ config('talkila.account_verification','/account-verification') }}" data-popup="uploadPopUp">
                {{ __('PROFILE_VERIFICATION') }}</a>
        @endif
    @endif
</div>
