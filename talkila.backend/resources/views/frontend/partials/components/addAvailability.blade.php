<div class="cell small-12">

    <div class="step-heading-wrap w-100 fl mb16 cblack">

        <ul class="ability-heading-ul fl m0 p0">
            <li>{{ __('CONFIGURE_AVAILABILITIES') }} </li>
        </ul>
    </div>
</div>

<div class="cell small-12">
    <span class="add-slot cpp" onclick="openAvailability(this)" data-popup="time-slot-popup">
        @include('frontend.partials.svg.icons.add-time-slot') {{ __('ADD_TIME_SLOT') }}
    </span>

</div>

<br>

<script>

    function openAvailability(that){
        setDrums(document.getElementById('time-slot-popup'), '10', '00', '11', '00')
        openPopup(that.dataset.popup)
        document.getElementById('time-slot-popup').getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
        document.getElementById('time-slot-popup').getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')[0].classList.add('active')
    }

</script>
