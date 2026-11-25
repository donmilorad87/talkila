<div class="popupBase" id="cancelAppointment-{{$item['id'] ?? '' }}">
    <div class="popuper ppB" id="cancelPopuper" data-id="{{$item['id'] ?? '' }}">
        <div class="credit-modal">
            <div class="grid-x">
                <h5 class="p24">{!! __('TALK_CANCEL') !!}</h5>
                @if ($showPostpone)
                    <p class="p024">{!! __('CANCEL_APPOINTMENT_TEXT_1') !!}</p>
                @else
                    <p class="p024">{!! __('CANCEL_APPOINTMENT_NO_REFUND_TEXT') !!}</p>
                @endif


                <form class="small-12 form-option bookingCancelOptions">
                    <div class="grid-x grid-margin-x">
                        <fieldset class="cell large-12 cancelationReasons">

                        </fieldset>
                    </div>
                    <div class="grid-x ">

                        <div class="small-12 pt24">
                            <div class="text-center">
                                <a class="df aic jcc btn expanded cancelBooking h40 lh40" data-open="exampleModal3"
                                   data-booking-id="{{$item['booking_id']  ?? '' }}">
                                    {!! __('TALK_CANCEL') !!}
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
