@component('mail::message')
    {!! __('NEW_VERIFICATION', [
       'name' => $name,
       'requested_email' => $requested_email,
       'created_at' => $created_request_at,
    ])!!}

<a href="{{ $my_url }}">Verify</a>

    {{ config('app.name') }}
@endcomponent
