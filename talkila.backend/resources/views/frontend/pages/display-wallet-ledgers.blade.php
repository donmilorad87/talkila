<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('frontend.partials.components.head')
</head>
<body class="{{Route::current()->getName()}}">
<div class="container" style="width: 98%; margin: 0 auto;" >
    <h3 class="text-center"> {{ __('WALLET_LEDGERS_HISTORY') }} </h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">{{ __('USER') }} ID</th>
            <th scope="col">{{ __('WALLET') }} ID</th>
            <th scope="col">{{ __('BOOKING') }} ID</th>
            <th scope="col">{{ __('TRANSACTION_TYPE') }}</th>
            <th scope="col">{{ __('TRANSACTION_ID') }}</th>
            <th scope="col">{{ __('AMOUNT') }}</th>
            <th scope="col">{{ __('STATUS') }}</th>
            <th scope="col">{{ __('CREATED_AT') }}</th>

        </tr>
        </thead>
        <tbody>
        @foreach($wallets as $wallet)
            <tr>
                <td> {{ $wallet['id'] }}</td>
                <td> {{ $wallet['user_id'] }}</td>
                <td> {{ $wallet['wallet_id'] }}</td>
                <td> {{ $wallet['booking_id'] }}</td>
                <td> {{ $wallet['transaction_type'] }}</td>
                <td> {{ $wallet['transaction_id'] }}</td>
                <td> {{ $wallet['amount'] }}</td>
                <td> {{ $wallet['status'] }}</td>
                <td> {{ $wallet['created_at'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

@yield('footer_scripts')
@stack('after-scripts')
</body>
</html>
