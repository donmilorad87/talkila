<div class="inner-box-book w-100 fl">

    <div class="bMySlotsButtons">
        <div class="bMySlotsButtonsCont noselect" data-pointer="pc">
            <p class="pf">{{ __('WEEK') }}</p>
        </div>
        <div class="bMySlotsButtonsCont noselect" data-pointer="gc">
            <p>{{ __('MONTH') }}</p>
        </div>
        <div class="buttonLine"></div>
    </div>
    <div class="coursesBlock privateC pt25">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="small-12">
                    <div class="weekly-heading">
                        @include('frontend.partials.svg.icons.arrow-left')
                        <p>{{ __('MONTH_SEPTEMBER_LONG') }} 5 - {{ __('MONTH_SEPTEMBER_LONG') }} 14</p>
                        @include('frontend.partials.svg.icons.arrow-right')
                    </div>
                </div>
                <div class="small-12">
                    <div class="mb16">
                        @include('frontend.partials.components.seven-days-calendar')
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="coursesBlock groupC pt25">
        <div>
            @include('frontend.partials.pages.booking.booking-calendar-2')

        </div>
    </div>

</div>
