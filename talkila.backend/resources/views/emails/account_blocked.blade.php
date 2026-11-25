@component('mail::message')
    {!! __('YOU_HAVE_BLOCKED_DESCRIPTION', [
       'username'     => $username,
       'block_reason' => $block_reason
    ])!!}
    {{ config('app.name') }}
@endcomponent
