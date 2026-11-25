<a href="@if (Route::current()->getName() === 'home')
            {{ route('add_jtc_calendar', ['from' => 'addCalendarFromHome']) }}

        @else
            https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar.readonly https://www.googleapis.com/auth/calendar.app.created&access_type=offline&include_granted_scopes=true&response_type=code&state=state_parameter_passthrough_value&redirect_uri={{ config('services.google.calendar_redirect') }}&client_id={{ config('services.google.client_id') }}
        @endif"
    class="cell small-12 fl creditCardReset mb16 cp">
    <span class="add-slot cblack">
        <svg width="48" height="47" viewBox="0 0 48 47" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect opacity="0.1" x="6.10352e-05" width="48" height="47" rx="12" fill="#172B4D"></rect>
            <rect x="22.7144" y="14" width="2.57143" height="18" rx="1.28" fill="#172B4D"></rect>
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M31.7201 21.7144C32.427 21.7144 33.0001 22.2931 33.0001 23.0001C33.0001 23.707 32.427 24.2858 31.7201 24.2858H16.2801C15.5731 24.2858 15.0001 23.707 15.0001 23.0001C15.0001 22.2931 15.5731 21.7144 16.2801 21.7144H31.7201Z"
                fill="#172B4D"></path>
        </svg>
        @lang('ADD_NEW_CALENDAR')
    </span>
</a>
