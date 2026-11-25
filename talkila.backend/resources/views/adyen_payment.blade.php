@extends('layout.mainlayout')
@section('content')
    <a href="{{ route('admin.adyen-payment-methods') }}" id="adyen-button"> Klikni za adyen payment </a>


    <div id="dropin-container"></div>
@endsection

@section('scripts')
    <script src="https://checkoutshopper-test.adyen.com/checkoutshopper/sdk/3.18.1/adyen.js"
            integrity="sha384-CJ8FSR4EmldZPoNUHfpHrZ7CSOsP2lxp8xzSNIE92icrx46CmCoSxucO4IRE8h7V"
            crossorigin="anonymous"></script>
    @parent
    <script>
        const makePayment = (stateData) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data: stateData,
                    url: '{{ route('admin.adyen-make-payment') }}',
                    type: 'post',
                    success: function (data, status, xhr) {
                        resolve(data);
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        reject(new Error(errorMessages));
                    }
                })
            });
        };

        const makeDetailsCall = (stateData) => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data: stateData,
                    url: '{{ route('admin.adyen-additional-details') }}',
                    type: 'post',
                    success: function (data, status, xhr) {
                        resolve(data);
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        reject(new Error(errorMessages));
                    }
                })
            });
        };

        function showFinalResult(response) {
            if(response.resultCode == 'Authorised') {
                dropin.setStatus('success');
                dropin.setStatus('success', { message: 'Payment successful!' });
            } else {
                dropin.setStatus('error');
                dropin.setStatus('error', { message: 'Something went wrong.'});
            }

            console.log(response);
        }

        const configuration = {
            paymentMethodsResponse: {!! $paymentMethods !!}, // The `/paymentMethods` response from the server.
            clientKey: "test_SSLFO5VIO5HAPFK2OVTJWSFTPMHRDBM7", // Web Drop-in versions before 3.10.1 use originKey instead of clientKey.
            locale: "en-US",
            environment: "test",
            onSubmit: (state, dropin) => {
                // alert(1);
                // Your function calling your server to make the `/payments` request
                makePayment(state.data)
                    .then(response => {
                        if (response.action) {
                            // Drop-in handles the action object from the /payments response
                            dropin.handleAction(response.action);
                        } else {
                            // Your function to show the final result to the shopper
                            showFinalResult(response);
                        }
                    })
                    .catch(error => {
                        throw Error(error);
                    });
            },
            onAdditionalDetails: (state, dropin) => {
                // Your function calling your server to make a `/payments/details` request
                makeDetailsCall(state.data)
                    .then(response => {
                        if (response.action) {
                            // Drop-in handles the action object from the /payments response
                            dropin.handleAction(response.action);
                        } else {
                            // Your function to show the final result to the shopper
                            showFinalResult(response);
                        }
                    })
                    .catch(error => {
                        throw Error(error);
                    });
            },
            paymentMethodsConfiguration: {
                card: { // Example optional configuration for Cards
                    hasHolderName: true,
                    holderNameRequired: true,
                    enableStoreDetails: true,
                    hideCVC: false, // Change this to true to hide the CVC field for stored cards
                    name: 'Credit or debit card'
                }
            }
        };

        const checkout = new AdyenCheckout(configuration);
        const dropin = checkout.create('dropin').mount('#dropin-container');
    </script>
@endsection
