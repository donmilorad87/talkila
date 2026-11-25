<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('frontend.partials.components.head')
</head>
<body class="{{Route::current()->getName()}}">
<div class="container" style="width: 98%; margin: 0 auto;" >
    <h3 class="text-center"> {{ __('WALLET_HISTORY') }} </h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">{{ __('USER') }} ID</th>
                <th scope="col">{{ __('RAW_BALANCE') }}</th>
                <th scope="col">{{ __('CREATED_AT') }}</th>

            </tr>
        </thead>
        <tbody>
        @foreach($wallet as $data)
            <tr>
                <td> {{ $data['id'] }}</td>
                <td> {{ $data['user_id'] }}</td>
                <td> {{ $data['raw_balance'] }}</td>
                <td> {{ $data['created_at'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>


@yield('footer_scripts')
@stack('after-scripts')
</body>
</html>
