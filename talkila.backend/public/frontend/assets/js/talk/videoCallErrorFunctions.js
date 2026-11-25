function connectToSocketCatchError(error) {
    let em



    if (error.message === "Unexpected end of JSON input") {
        em = getPoTranslate('NOT_HAVE_BOOKED_ROOM')

        submitValidationForm()

        function submitValidationForm() {

            jQuery.ajax({
                type: 'POST',
                headers: {
                    "Accept": 'application/json',
                },
                data: {
                    '_token' : token
                },
                url: '/frontend/api/user-first-upcoming-booking',

                beforeSend: function () {
                    // Handle the beforeSend event

                    showLoading()
                },
                complete: function () {
                    hideLoading()

                },
                success: function (response) {

                    if (response.success) {

                        if (response.data) {

                            response.data.start_call

                            let callStartTime = isSafari ? response.data.start_call.replaceAll('-', '/') : response.data.start_call

                            let startTime = new Date(callStartTime)

                            startTime = new Date(startTime) // Date object

                            em = `You do not have active booked room. You have upcoming booking, it will start at ${startTime.getFullYear()}-${addZero(startTime.getMonth() + 1)}-${addZero(startTime.getDate())} at ${addZero(startTime.getHours())} : ${addZero(startTime.getMinutes())}`

                            closePopup('loadingPopup')

                            document.getElementById('errorMsgtitle').textContent = userObj1.name
                            document.getElementById('errorMsgText').textContent = em.length > 0 ? em : error.message
                            document.getElementById('errorMsgAdvice').textContent = ''
                            openPopup('errorPopup')
                            toastify(response.message)
                            return response.message;
                        } else {

                            closePopup('loadingPopup')
                            document.getElementById('errorMsgtitle').textContent = userObj1.name
                            document.getElementById('errorMsgText').textContent = em.length > 0 ? em : response.message
                            document.getElementById('errorMsgAdvice').textContent = ''
                            openPopup('errorPopup')

                            toastify(response.message)

                        }

                    } else {
                        toastify(response.message)
                        return response.message;
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new GettingFirstUpcomingBookingError(errorMessage));
                }
            });
        }

    } else {
        closePopup('loadingPopup')
        console.log(error, '_______776__________')
        document.getElementById('errorMsgtitle').textContent = userObj1.name
        document.getElementById('errorMsgText').textContent = em ? em.length > 0 ? em : error.message : error.message
        document.getElementById('errorMsgAdvice').textContent = getPoTranslate('CONTACT_CUSTOMER')
        openPopup('errorPopup')
    }
}
