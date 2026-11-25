<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\Booking
 *
 * @property int $id
 * @property int|null $state
 * @property int|null $extension
 * @property int|null $anonym
 * @property \Illuminate\Support\Carbon|null $start_call
 * @property \Illuminate\Support\Carbon|null $end_call
 * @property int|null $duration
 * @property int|null $pin Random number between 1000 and 9999
 * @property string|null $price
 * @property string|null $message Message from fan to the organizer
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $participant_user_id
 * @property int|null $cancellation_reason_id
 * @property int|null $course_id
 * @property int|null $teacher_user_id
 * @property-read \App\Models\Booking $booking_parent
 * @property-read \App\Models\BookingsPaymentDetails|null $booking_payment_authorization_details
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingsPaymentDetails[] $booking_payment_details
 * @property-read int|null $booking_payment_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingsProtocol[] $booking_protocol
 * @property-read int|null $booking_protocol_count
 * @property-read \App\Models\CallsCancellationReason|null $cancellation_reason
 * @property-read \App\Models\FinanceCurrency $finance_currencies
 * @property-read \App\Models\User|null $participant_user
 * @property-read \App\Models\Talk $talk
 * @property-read \App\Models\BookingsPayout|null $talksBookingsPayouts
 * @property-read \App\Models\Feedback|null $talksFeedback
 * @property-read \App\Models\User|null $teacher_user
 * @property-read \App\Models\Availability $user_availabilities
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereAnonym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCancellationReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEndCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereParticipantUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTeacherUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Booking extends Models\Booking
{
    protected static function boot()
    {
        parent::boot();
    }
}
