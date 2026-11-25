@component('mail::message')
    {!! __('APP_LEFT_REVIEW', [
       'username' => $username,
       'created'  => $created,
       'rating'   => $rating,
       'comment'  => $comment,
    ])!!}
    {{ config('app.name') }}
@endcomponent
