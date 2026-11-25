
//review

function submitReview(){
    try {
        submitReviewXMLHttpRequestFunction()
    } catch (err) {
        Sentry.captureException(new TryCatchSubmitReviewXMLHttpRequestFunction(err));
    }
}

function submitReviewXMLHttpRequestFunction() {

    function submitReviewXMLHttpRequestFunctionHelper(mesage) {

        closePopup('reviewPopUp')

        setTimeout(function() {

            openPopup('completedPopUp')

            setTimeout(function() {
                toastify(mesage)
            }, 100)

            setTimeout(function() {
                showLoading()
            }, 4000)

            setTimeout(function() {
                location.assign(location.origin)
            }, 5000)
        }, 210)

    }

    let xhr = new XMLHttpRequest()
    let pointer = window.reviewCarouselItemsCount == 1 ? 0 : window.reviewCarouselItemIndex
    let token = document.querySelector('meta[name="csrf-token"]').content

    let data = {
        'user_id': call.call_type === CallTypes.GROUP ?
            call.user_type == UserTypes.PROVIDER ?
                document.getElementsByClassName('reviewSubmitButton')[pointer].dataset.userId :
                document.getElementsByClassName('reviewSubmitButton')[0].dataset.userId
            :
            document.getElementsByClassName('reviewSubmitButton')[0].dataset.userId,
        'booking_id': dataObj.active_users[0].booking_id /* 314 */ ,
        'stars_content': call.call_type === CallTypes.GROUP ?
            call.user_type == UserTypes.PROVIDER ?
                document.getElementsByClassName('rateAnswerUser')[pointer].dataset.rate
                :
                document.getElementsByClassName('rateAnswerUser')[0].dataset.rate
            :
            document.getElementsByClassName('rateAnswerUser')[0].dataset.rate,
        'stars_voice_quality': call.call_type === CallTypes.GROUP ?
            call.user_type == UserTypes.PROVIDER ?
                document.getElementsByClassName('rateAnswerVoiceVideo')[pointer].dataset.rate :
                document.getElementsByClassName('rateAnswerVoiceVideo')[0].dataset.rate
            :
            document.getElementsByClassName('rateAnswerVoiceVideo')[0].dataset.rate,
        'description': call.call_type === CallTypes.GROUP ?
            call.user_type == UserTypes.PROVIDER ?
                document.getElementsByClassName('innerCarouselElement')[pointer].getElementsByClassName('reviewDescription')[0].value :
                document.getElementsByClassName('innerCarouselElement')[0].getElementsByClassName('reviewDescription')[0].value
            :
            document.getElementsByClassName('innerCarouselElement')[0].getElementsByClassName('reviewDescription')[0].value,
        '_token' : token
        // 'state'                 : state || sta je ovo state?
    }

    xhr.onloadstart = function() {
        /* showLoading() */
    }

    xhr.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            let response = JSON.parse(this.response)

            if (response.success === true) {

                if (call.call_type === CallTypes.ONE_TO_ONE) {
                    if (call.user_type == UserTypes.CLIENT) {

                        submitReviewXMLHttpRequestFunctionHelper(getPoTranslate('SUPPLIER_SUCCESSFULLY_REVIEWED'))
                    } else if (call.user_type == UserTypes.PROVIDER) {
                        submitReviewXMLHttpRequestFunctionHelper(getPoTranslate('CLIENT_SUCCESSFULLY_REVIEWED'))
                    }
                } else if (call.call_type === CallTypes.GROUP) {
                    if (call.user_type == UserTypes.CLIENT) {
                        submitReviewXMLHttpRequestFunctionHelper(getPoTranslate('SUPPLIER_SUCCESSFULLY_REVIEWED'))
                    } else if (call.user_type == UserTypes.PROVIDER) {

                        if (window.reviewCarouselItemsCount > 1) {
                            jQuery(".owl-carousel").trigger('remove.owl.carousel', [window.reviewCarouselItemIndex]).trigger('refresh.owl.carousel');
                        } else {
                            submitReviewXMLHttpRequestFunctionHelper(getPoTranslate('SUPPLIER_SUCCESSFULLY_REVIEWED'))
                        }
                    }
                }
                toastify(response.message)
            } else if (response.success === false) {

                if (Object.keys(response.errors).length > 0) {
                    let errorString = ''

                    for (let i = 0; i < Object.keys(response.errors).length; i++) {
                        if (response.errors[Object.keys(response.errors)[i]].length > 0) {
                            response.errors[Object.keys(response.errors)[i]].forEach(error => errorString += error)
                        } else {
                            errorString += response.errors[Object.keys(response.errors)[i]]
                        }

                    }

                    toastify(errorString)

                } else if (response.message) {

                    toastify(response.message)

                } else {
                    toastify(getPoTranslate('SOMETHING_WENT_WRONG'))
                }

            }
            hideLoading()
        }
    }

    xhr.onloadend = function() {

        console.log('The request has completed.')
    }

    xhr.onerror = function(error) {
        Sentry.captureException(new FeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open("POST", "/frontend/api/feedback", true)

    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));

    xhr.send(JSON.stringify(data))

}



function rateLogics() {
    if (document.getElementsByClassName('rate')[0]) {
        let rates = document.getElementsByClassName('rate')

        for (let i = 0; i < rates.length; i++) {

            let inputs = rates[i].getElementsByTagName('input')

            for (let j = 0; j < inputs.length; j++) {

                inputs[j].addEventListener('click', function() {

                    let parrentrateAnswer = this.parentElement.parentElement.parentElement.getElementsByClassName('rateAnswer')[0]

                    parrentrateAnswer.textContent = rateSwitchHelper(parseInt(this.value))
                    parrentrateAnswer.dataset.rate = this.value
                })

            }

        }
    }
}

function rateSwitchHelper(rate) {

    switch (rate) {
        case 1:
            return getPoTranslate('NOT_ENOUGH')
        case 2:
            return getPoTranslate('ENOUGH')
        case 3:
            return getPoTranslate('GOOD')
        case 4:
            return getPoTranslate('VERY_GOOD')
        case 5:
            return getPoTranslate('EXCELLENT')
    }
}

async function setReviewPopupups(){

    showLoading()

    let reviewPopup = document.getElementById('reviewPopUp')

    if (call.call_type === CallTypes.ONE_TO_ONE) {
        if (call.user_type == UserTypes.CLIENT) {
            let active_users = dataObj.active_users
            for (let i = 0; i < active_users.length; i++) {
                if (active_users[i].user_type === 2) {
                    setReviewPopupupsHelper(reviewPopup, active_users[i], 1, userObj1.id)
                }
            }
        } else if (call.user_type == UserTypes.PROVIDER) {
            let active_users = dataObj.active_users
            for (let i = 0; i < active_users.length; i++) {
                if (active_users[i].user_type === 1) {
                    setReviewPopupupsHelper(reviewPopup, active_users[i], 1, userObj1.id)
                }
            }
        }
    } else if (call.call_type === CallTypes.GROUP) {

        if (call.user_type == UserTypes.CLIENT) {
            let active_users = dataObj.active_users
            for (let i = 0; i < active_users.length; i++) {
                if (active_users[i].user_type == UserTypes.PROVIDER) {
                    console.log('aktivni user: ' + active_users[i], 'logged user object : ' + userObj1);
                    setReviewPopupupsHelper(reviewPopup, active_users[i], 1, userObj1.id)
                }
            }
        } else if (call.user_type == UserTypes.PROVIDER) {

            let active_users = dataObj.active_users
            let groupStudents = []

            for (let i = 0; i < active_users.length; i++) {
                if (active_users[i].user_type === UserTypes.CLIENT) {
                    groupStudents.push({
                        'user_id': active_users[i].user_id,
                        'name_of_user': active_users[i].name_of_user,
                        'user_image': active_users[i].user_image
                    })
                }
            }

            let clonedElement = document.getElementsByClassName('innerCarouselElement')[0]

            document.getElementById('reviewCarousel').innerHTML = ''
            document.getElementById('reviewCarousel').className = 'owl-carousel'

            for (let i = 0; i < groupStudents.length; i++) {
                let cln = clonedElement.cloneNode(true)

                setReviewPopupupsHelper(cln, groupStudents[i], i, userObj1.id)

                document.getElementById('reviewCarousel').appendChild(cln)

            }

            var owl1 = jQuery("#reviewCarousel");

            owl1.owlCarousel({
                onChanged: callback,
                items: 1,
                dots: true,
                nav: true
            })

            function callback(event) {
                window.reviewCarouselItemsCount = event.item.count;
                window.reviewCarouselItemIndex = event.item.index;
            }

            document.getElementById('reviewCarousel').style.opacity = '1'


        }
    }

    rateLogics()

}
function setReviewPopupupsHelper(reviewPopup, active_user, ratePointer, user_id) {
    console.log(active_user);
    reviewPopup.getElementsByClassName('reviewName')[0].textContent = active_user.name_of_user
    reviewPopup.getElementsByClassName('review-inner')[0].getElementsByTagName('img')[0].src = active_user.user_image

    //rateUser

    let rateUser = reviewPopup.getElementsByClassName('rateUser')[0]
    let rateUserInputs = rateUser.getElementsByTagName('input')
    let rateUserLabels = rateUser.getElementsByTagName('label')
    console.log('ratePointer: ', ratePointer)
    for (let i = 0; i < rateUserInputs.length; i++) {
        rateUserInputs[i].id = rateUserInputs[i].id + ratePointer
        rateUserInputs[i].name = rateUserInputs[i].name + ratePointer
        rateUserLabels[i].htmlFor = rateUserLabels[i].htmlFor + ratePointer
    }

    //rateVoiceVideo

    let rateVoiceVideo = reviewPopup.getElementsByClassName('rateVoiceVideo')[0]
    let rateVoiceVideoInputs = rateVoiceVideo.getElementsByTagName('input')
    let rateVoiceVideoLabels = rateVoiceVideo.getElementsByTagName('label')

    for (let i = 0; i < rateVoiceVideoInputs.length; i++) {
        rateVoiceVideoInputs[i].id = rateVoiceVideoInputs[i].id + ratePointer
        rateVoiceVideoInputs[i].name = rateVoiceVideoInputs[i].name + ratePointer
        rateVoiceVideoLabels[i].htmlFor = rateVoiceVideoLabels[i].htmlFor + ratePointer
    }


    /* document.getElementsByClassName('reviewSubmitButton')[0].dataset.pointer = '1'
    document.getElementsByClassName('reviewSubmitButton')[0].dataset.pointerTalkType = '1' */

    reviewPopup.getElementsByClassName('reviewSubmitButton')[0].dataset.userId = user_id

    reviewPopup.getElementsByClassName('reviewSubmitButton')[0].addEventListener('click', submitReview)

}
