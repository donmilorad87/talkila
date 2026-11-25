@component('mail::message')
    <h1>{{ __('CALENDAR_DISCONNECTED_HEADER') }}</h1>
    <p>{{ __('CALENDAR_DISCONNECTED_DESCRIPTION', ['calendar' => $calendarAccount->email]) }} <p>
    <div class="mt-10 mb-10">
        @component('mail::button', ['url' => $profileUrl , 'color' => 'talkila'])
            {{ __('CONNECT_CALENDAR') }}
        @endcomponent
    </div>
@endcomponent
