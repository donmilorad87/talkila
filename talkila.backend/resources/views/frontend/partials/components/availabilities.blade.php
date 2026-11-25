@foreach ($userAvailability as $availability)
    @include('frontend.partials.components.availability-slot', [
        'availability' => $availability,
    ])
@endforeach

<script>
    function availabilityPauseUnpause(that) {

        var availability = that.value
        var weekday = that.dataset.weekday
        var start_time = that.dataset.starttime
        var end_time = that.dataset.endtime
        var timezone = that.datasetlocaltimezone
        var state = that.checked;

        showLoading()



        jQuery.ajax({
            type: 'POST',
            url: '/frontend/api/joinTheClubAvailability',
            data: {
                'id': availability,
                'state': state ? 1 : 0,
                'weekday': weekday,
                'start_time': start_time,
                'end_time': end_time,
                '_token': token
            },
            beforeSend: function() {
                // Handle the beforeSend event

                if (that.classList.contains('x2')) {
                    if (document.getElementById('availability-' + availability + 'x1').checked) {
                        document.getElementById('availability-' + availability + 'x1').checked = false
                    } else {
                        document.getElementById('availability-' + availability + 'x1').checked = true
                    }
                } else if (that.classList.contains('x1')) {
                    if (document.getElementById('availability-' + availability + 'x2').checked) {
                        document.getElementById('availability-' + availability + 'x2').checked = false
                    } else {
                        document.getElementById('availability-' + availability + 'x2').checked = true
                    }
                } else {

                }





            },
            complete: function() {

            },
            success: function(response) {

                if (response.success) {

                        toastify(response.message)
                        hideLoading()

                        if (document.body.className === "jtc2_set_availabilities") {

                            let input = document.getElementById('availability-' + availability)
                            if (input.checked === true) {
                                input.checked = true
                            } else if (input.checked === false) {
                                input.checked = false
                            }
                        }


                } else {
                    toastify(response.message)
                }
            },
            error: function(errorMessage) {
                Sentry.captureException(new JoinTheClubAvailabilityError(errorMessage + ' || URL: ' +
                    location.href));
            }
        });

    }

    function deleteAva(that) {


        let availability = that.dataset.id

        jQuery.ajax({
            type: 'GET',
            url: '/frontend/api/delete-availability/' + availability,
            beforeSend: function() {
                // Handle the beforeSend event
                showLoading()
            },
            complete: function() {
                hideLoading()
            },
            success: function(response) {

                if (response.success === true) {
                    if (

                        document.body.className === "logged_in" ||
                        document.body.className === "about_me"
                    ) {
                        that.parentElement.remove()
                    } else {
                        location.reload()
                    }
                    calculatePopUpHeight(document.getElementById('changeAvailability'))
                    toastify(getPoTranslate('TIME_SLOT_REMOVED_SUCCESSFULLY'))

                } else if (response.success === false) {
                    toastify(response.message)
                }
            },
            error: function(errorMessage) {
                Sentry.captureException(new JtcDeleteAvailabilityError(errorMessage + ' || URL: ' + location
                    .href));
            }
        })


    }
</script>
