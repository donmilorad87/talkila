<div class="profile-wrapper">
    <h4>Your Profile Progress</h4>
    <h4 class="verified"><span>@include('frontend.partials.svg.icons.talkila-white')</span> Account Verified</h4>
    <ul>
        <li><span>
            @include('frontend.partials.svg.icons.user-grey') Identity Verified </span>
            <p>@include('frontend.partials.svg.icons.uncheck')</p>
        </li>
        <li class="verified"><span>@include('frontend.partials.svg.icons.email-yellow') Email Verified</span>
            <p>@include('frontend.partials.svg.icons.check')</p>
        </li>
        <li class="verified"><span>@include('frontend.partials.svg.icons.call-yellow') Phone Verified</span>
            <p>@include('frontend.partials.svg.icons.check')</p>
        </li>
        <li><span>@include('frontend.partials.svg.icons.paypal-grey') Paypal
                Verified </span>
            <p>@include('frontend.partials.svg.icons.uncheck')</p>
        </li>
    </ul>
    <a class="btn expanded cp" href="#uploadPopUp" data-popup="uploadPopUp">Verify
        Profile</a>
</div>
