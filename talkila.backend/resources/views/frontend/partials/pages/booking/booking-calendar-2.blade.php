<div class="wrapper">

    <div class="date-dd posrelative">
        <button id="previous">&#8249;</button>
        <div class="dateDDIner" data-opened="{{Route::current()->getName() == 'booking' ? "1":"0"}}">
            <span></span>
            @include('frontend.partials.svg.icons.arrow-bottom-dark')
        </div>


        <button id="next">&#8250;</button>
    </div>
    <div class="container-calendarCont">
        <div class="container-calendar grid-x">

            <div class="button-container-calendar small-12">


                <div class="calendarMArrows">
                    <div style="margin: auto;">
                        <h3 id="monthHeader"></h3>

                        <p id="yearHeader"></p>
                    </div>
                </div>
            </div>



            <table class="table-calendar" id="calendar">

                <thead id="thead-month"></thead>

                <tbody id="calendar-body"></tbody>

            </table>



            <div class="footer-container-calendar">

                <label for="month">{{ __('JUMP_TO') }}: </label>

                <select id="month">

                    <option value=0>{{ __('MONTH_JANUARY_SHORT') }}</option>

                    <option value=1>{{ __('MONTH_FEBRUARY_SHORT') }}</option>

                    <option value=2>{{ __('MONTH_MARCH_SHORT') }}</option>

                    <option value=3>{{ __('MONTH_APRIL_SHORT') }}</option>

                    <option value=4>{{ __('MONTH_MAY_SHORT') }}</option>

                    <option value=5>{{ __('MONTH_JUNE_SHORT') }}</option>

                    <option value=6>{{ __('MONTH_JULY_SHORT') }}</option>

                    <option value=7>{{ __('MONTH_AUGUST_SHORT') }}</option>

                    <option value=8>{{ __('MONTH_SEPTEMBER_SHORT') }}</option>

                    <option value=9>{{ __('MONTH_OCTOBER_SHORT') }}</option>

                    <option value=10>{{ __('MONTH_NOVEMBER_SHORT') }}</option>

                    <option value=11>{{ __('MONTH_DECEMBER_SHORT') }}</option>

                </select>

                <select id="year"></select>

            </div>

            <p id="date-picked" class="dn"></p>
            <p id="todays" class="dn">{!! __('RESET_CALENDAR') !!}</p>
        </div>
    </div>


    <input type="hidden" value="45" id="talkDuration">
    @if (Route::current()->getName() !== 'booking')

        <input type="hidden" value="{{ json_encode($newTeacherAvailability) }}" id="newTeacherAvailabilityDatesTime">
        <div id="userAvailability" class="dn"></div>
    @endif

    @if (Route::current()->getName() !== 'book_slot')
        <input type="hidden" value="{{ json_encode($userBookingsList) }}" id="userBookingsList">
    @endif



</div>


