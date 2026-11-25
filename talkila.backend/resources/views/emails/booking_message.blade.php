@component('mail::message')
    {!! __('BOOKING_MESSAGE', [
       'teacher_name'    => $teacher_name,
       'talk_headline'   => $talk_headline,
       'student_name'    => $student_name,
       'from'            => date('m.d.Y H:i', strtotime($booking_start_call)),
       'to'              => date('m.d.Y H:i', strtotime($booking_end_call)),
       'booking_message' => $booking_message
    ])!!}
    {{ config('app.name') }}
@endcomponent
