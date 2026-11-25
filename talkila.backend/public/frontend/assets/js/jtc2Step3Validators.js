

function initStep3Validation() {

    if(document.getElementsByClassName('cpzz')[0]){
        document.getElementsByClassName('cpzz')[0].addEventListener('click',function(){
            window.addAvailabilityPointer = 1
        })

    }

    if (document.getElementsByClassName('addTimeSlotings')[0]) {
        document.getElementsByClassName('addTimeSlotings')[0].addEventListener('click', function () {
            if (document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0]) {

                document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0].textContent = getPoTranslate('ADD_TIME_SLOT')

                document.getElementById('submit-btn').textContent = getPoTranslate('ADD_TIME_SLOT')
            }
        })

    }

    if (document.getElementById("step3-form")) {

        let submitBtn = document.getElementById("submit-btn")
        submitBtn.addEventListener("click", handleSubmit)

        function handleSubmit(e) {
            e.preventDefault()
            showLoading()
            let days = document.getElementsByClassName("date-scheduler-wrap")[0].children
            let available = document.getElementById("availableCheckbox")
            let startTime = document.getElementsByClassName("startTime")[0].textContent.trim()
            let endTime = document.getElementsByClassName("endTime")[0].textContent.trim()

            function getCurrentDay() {
                let day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
                for (let i = 0; i < days.length; i++) {
                    if (days[i].classList.contains("active")) {
                        return { day: day[days[i].dataset.index], dayIndex: days[i].dataset.index }
                    }
                }
            }


            let postData = {
                dayIndex: getCurrentDay().dayIndex,
                available: true,
                startTime: startTime,
                endTime: endTime,
                timeSlotId: e.target.dataset.timeSlotId ? e.target.dataset.timeSlotId.length > 0 ? e.target.dataset.timeSlotId : false : false

            }

            let postStatus = {}

            endTimeHandler()

            function endTimeHandler() {
                let element = document.getElementsByClassName("endTime")[0]
                let params = { element: element, startTime: startTime.replace(/\D/g, ''), endTime: endTime.replace(/\D/g, '') }
                postStatus["timeStatus"] = timeCheck(params)
            }

            function timeCheck(params) {

                if (params.startTime >= params.endTime) {
                    params.element.style.border = "1px solid red"
                    return { isOk: false, reason: translate.timeError3 }
                } else {
                    params.element.style.border = "none"
                    return { isOk: true, reason: false }
                }
            }

            if (postStatus.timeStatus.isOk) {

                submitValidationForm(postData)
            } else {
                hideLoading()
                console.log("post failed", postData)
                console.log("post errors", postStatus)
                toastify(postStatus.timeStatus.reason)
            }

            function submitValidationForm(formData) {


                let state

                if (window.addAvailabilityPointer === 1) {
                    state = 1
                } else if (window.addAvailabilityPointer === 2) {
                    let states = document.getElementById('availabilitesInnerCont').getElementsByClassName('date-time')



                    for (let i = 0; i < states.length; i++) {

                        if (states[i].dataset.timeSlotId == formData.timeSlotId) {



                            state = states[i].parentElement.getElementsByClassName('user-availability')[0].checked ? 1 : 0
                        }

                    }

                }

                jQuery.ajax({
                    type: 'POST',
                    url: '/frontend/api/join-the-club-availability',
                    headers: {

                        "Time-Zone-Offset-UTC": getCookie('timezone')
                    },
                    data: {
                        'weekday': formData.dayIndex,
                        'start_time': formData.startTime + ':00',
                        'end_time': formData.endTime + ':00',
                        'state': state,
                        'id': formData.timeSlotId.length > 0 ? formData.timeSlotId : null,
                        '_token': token
                    },
                    beforeSend: function () {
                        // Handle the beforeSend event

                    },

                    success: function (response) {

                        if (response.success) {
                            if (document.body.className === 'logged_in') {
                                if (window.edditingAvailability === 1) {
                                    window.edditingAvailability = 0

                                    closePopup('time-slot-popup')

                                    document.getElementById('availabilitesInnerCont').innerHTML = response.data.html

                                    toastify(response.message)
                                    hideLoading()
                                } else {
                                    closePopup('time-slot-popup')

                                    document.getElementById('availabilitesInnerCont').innerHTML = response.data.html

                                    toastify(response.message)
                                    hideLoading()
                                }


                            } else {
                                closePopup('time-slot-popup')

                                location.reload()
                                toastify(response.message)
                            }

                        } else {

                            calculatePopUpHeight(document.getElementById('time-slot-popup'), 52)
                            document.getElementById('timeSlotValidation').textContent = response.message
                            document.getElementById('timeSlotValidation').style.height = '24px'
                            hideLoading()
                            toastify(response.message)

                        }
                    },
                    error: function (errorMessage) {
                        hideLoading()
                        Sentry.captureException(new TimeAvailabilitySubmitError(errorMessage + ' || url :' + location.href));
                    }
                });
            }
        }
    }
}
class GetTokenErrorTimeAvailability extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenErrorTimeAvailability"
    }
}
class TimeAvailabilitySubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "TimeAvailabilitySubmitError"
    }
}

(function () {
    initStep3Validation()
})();
