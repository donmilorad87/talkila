@extends('affiliate.layout.main-layout')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="headindCardTitle"> {{ trans('global.payout') }}</h5>
                    </div>

                    @include('affiliate.layout.partials.copy_text')

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam accumsan est at dolor iaculis porttitor.
                        Praesent sed tempor metus. In ac urna tempor, ornare lectus eu, porta risus. Morbi vel felis nisl.
                        Sed cursus tortor nec erat auctor mollis. Donec nec tincidunt urna. Quisque vestibulum vulputate tortor at lacinia.
                        Suspendisse placerat scelerisque ligula vitae iaculis. Nam euismod dignissim vestibulum.
                    </p>

                    <span id="paypal-button-container-affiliate"></span>

                </div>

            </div>
        </div>
    </div>
    <!-- End Data Table -->

<script src='https://www.paypalobjects.com/js/external/api.js'></script>
<script>
    var appID       = '{{ env('PAYPAL_CONNECT_JTC') }}';
    var returnUrl   = '{{ env('APP_URL') }}';

    paypal.use( ['login'], function (login) {
        login.render ({
            "appid": appID,
            "authend":"sandbox",
            "scopes":"email",
            "containerid":"paypal-button-container-affiliate",
            "responseType":"code",
            "locale":"en-us",
            "buttonType":"LWP",
            "buttonShape":"pill",
            "buttonSize":"lg",
            "fullPage":"true",
            "returnurl":returnUrl +"/affiliate/payout"
        });
    });
</script>
@endsection






