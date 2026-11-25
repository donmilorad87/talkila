@extends('layout.mainlayout')
@section('content')
@can('profil_payout_method_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.profile-payout-methods.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.profilPayoutMethod.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'ProfilPayoutMethod', 'route' => 'admin.profile-payout-methods.parseCsvImport'])
{{--            <button id="checkout-button">Checkout</button>--}}

            <a href="{{ route('admin.adyen-payment-methods') }}" id="adyen-button"> Klikni za adyen payment </a>


            <a href="#" id="checkout-button"> <img class="img-fluid" style="max-height: 100px;" src="/images/stripe.png"> </a>

            <script id="total_amount"
                    src="https://checkout.stripe.com/checkout.js"
                    data-key="pk_test_51H4khlFGeV60BAng5mffhp8A3cvFFgAtcudeKMK5TVKD7uXidfZISpOaNXPMnotOB6Fundewes2kS3edsOIPYll600gpt42FPC"
                    data-amount=""
                    data-name="EasyValeting"
                    data-currency
                    data-description="Example charge"
                    data-locale="auto">
            </script>
            <div id="dropin-container"></div>
<!--            --><?php
//            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
//
//            $session = \Stripe\Checkout\Session::create([
//                'payment_method_types' => ['card'],
//                'line_items' => [[
//                    'price_data' => [
//                        'currency' => 'usd',
//                        'product_data' => [
//                            'name' => 'T-shirt',
//                        ],
//                        'unit_amount' => 2000,
//                    ],
//                    'quantity' => 1,
//                ]],
//                'mode' => 'payment',
//                'success_url' => 'https://example.com/success?session_id=1',
//                'cancel_url' => 'https://example.com/cancel',
//            ]);
//            ?>
        </div>
    </div>
@endcan
<!-- Data Table -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('cruds.profilPayoutMethod.title_singular') }} {{ trans('global.list') }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table m-0 table-hover ajaxTable datatable datatable-ProfilPayoutMethod">
                        <thead>
                          <tr>
                              <th width="10">

                              </th>
                              <th>
                                  {{ trans('cruds.profilPayoutMethod.fields.id') }}
                              </th>
                              <th>
                                  {{ trans('cruds.profilPayoutMethod.fields.user') }}
                              </th>
                              <th>
                                  {{ trans('cruds.profilPayoutMethod.fields.method') }}
                              </th>
                              <th>
                                  {{ trans('cruds.profilPayoutMethod.fields.value') }}
                              </th>
                              <th>
                                  {{ trans('cruds.profilPayoutMethod.fields.state') }}
                              </th>
                              <th>
                                  &nbsp;
                              </th>
                          </tr>
                          <tr>
                              <td>
                              </td>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                              </td>
                              <td>
                                  <select class="form-control search">
                                      <option value>{{ trans('global.all') }}</option>
{{--                                      @foreach($users as $key => $item)--}}
{{--                                          <option value="{{ $item }}">{{ $item }}</option>--}}
{{--                                      @endforeach--}}
                                  </select>
                              </td>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                              </td>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                              </td>
                              <td>
                                  <input class="form-control search" type="text" placeholder="{{ trans('global.search') }}">
                              </td>
                              <td>
                              </td>
                          </tr>
                      </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Data Table -->
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

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('profil_payout_method_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.profile-payout-methods.massDestroy') }}",
    className: 'btn btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.profile-payout-methods.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'method', name: 'method' },
{ data: 'value', name: 'value' },
{ data: 'state', name: 'state' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-ProfilPayoutMethod').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
});
    {{--var stripe = Stripe('pk_test_51H4khlFGeV60BAng5mffhp8A3cvFFgAtcudeKMK5TVKD7uXidfZISpOaNXPMnotOB6Fundewes2kS3edsOIPYll600gpt42FPC');--}}

    {{--var checkoutButton = document.getElementById('checkout-button');--}}
    {{--var session_id = '';--}}
    {{--checkoutButton.addEventListener('click', function(e) {--}}
    {{--    $.ajax({--}}
    {{--        url: "{{ route('api.payment') }}",--}}
    {{--        data: {unit_amount: 2100, quantity: 1},--}}
    {{--        type: 'post'--}}
    {{--    }).done(function(response) {--}}
    {{--        console.log(response, 'success');--}}
    {{--        stripe.redirectToCheckout({--}}
    {{--            // Make the id field from the Checkout Session creation API response--}}
    {{--            // available to this file, so you can provide it as argument here--}}
    {{--            // instead of the placeholder.--}}
    {{--            sessionId: response.id--}}
    {{--        }).then(function (result) {--}}
    {{--            // If `redirectToCheckout` fails due to a browser or network--}}
    {{--            // error, display the localized error message to your customer--}}
    {{--            // using `result.error.message`.--}}
    {{--        });--}}
    {{--    }).fail(function(response) {--}}
    {{--        var errors = response.responseJSON.errors;--}}
    {{--        console.log(errors);--}}
    {{--    });--}}
    {{--});--}}

    {{--$('#submitStripe').click(function(e) {--}}
    {{--    e.preventDefault();--}}

    {{--    var handler = StripeCheckout.configure({--}}
    {{--        key: '{{ config('services.stripe.key') }}',--}}
    {{--        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',--}}
    {{--        locale: 'auto',--}}
    {{--        currency: 'GBP',--}}
    {{--        token: function(token) {--}}
    {{--            $('#stripeToken').val(token.id);--}}
    {{--            $('#stripeEmail').val(token.email);--}}

    {{--            $('.admin_booking_form').submit();--}}
    {{--        }--}}
    {{--    });--}}

    {{--    // Open Checkout with further options:--}}
    {{--    handler.open({--}}
    {{--        name: 'Demo Site 32',--}}
    {{--        description: '2 widgets',--}}
    {{--        amount: 13--}}
    {{--    });--}}

    {{--});--}}

</script>
@endsection
