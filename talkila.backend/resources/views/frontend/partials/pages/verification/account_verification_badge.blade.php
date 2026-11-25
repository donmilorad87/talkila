<div class="posabsolute tl0 {{ $background_color_class }}">
    <h5 class="talignc p4 m0 wcolor">
        <a href="{{route('account_verification')}}" class="fs14 df aic tal">

            @include('frontend.partials.svg.icons.verification-pending-2')

            {{ $verification_text }}

        </a>
    </h5>
</div>
