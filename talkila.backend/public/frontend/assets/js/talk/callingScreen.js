var roomTimeOut = null
var audio

roomTimeOut = setInterval(() => {
    checkRooms()
}, 60000)

var booking_id
var response
var call
function checkRooms() {


    if (!document.getElementById('rejectRejonVideoTalk')) {

        let popupBase = document.createElement('div')
        popupBase.id = "rejectRejonVideoTalk"
        popupBase.dataset.open = '0'
        popupBase.className = 'popupBase zi9999'
        let popup = '<div class="popuper ppB" data-height=""> <div class="grid-x"> <div class="popupText"> <h5 class="mb16">' + getPoTranslate('HANGUP_CALL_HEADLINE') + '</h5><p class="mb16">' + getPoTranslate('HANGUP_CALL_DESCRIPTION') + '</p><div id="hangupReasonsContainer"></div><div class="df aic jcc"><button id="finalDecline" class="btn mr16">' + getPoTranslate('HANGUP_CALL') + '</button> <span class="btn" id="rejecttalk">' + getPoTranslate('CANCEL') + '</span> </div></div></div></div>'
        popupBase.innerHTML = popup
        document.body.prepend(popupBase)
    }


    let xhr = new XMLHttpRequest()

    let params = {
        _token: token
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            try {
                response = JSON.parse(this.response)
            } catch (parseError) {
                console.error('checkRooms: Failed to parse response', parseError)
                return
            }

            if (response.success === true) {

                audio = new Audio('/css/call_ring.mp3')

                booking_id = response.data.room.booking_id

                call = {

                    access_token: response.data.room.twilio_access_token,
                    socket_room_id: response.data.room.socket_room_id,
                    user_type: response.data.room.user_type,
                    call_type: response.data.room.call_type,
                    talk_type: response.data.room.talk_type,
                    start_time: response.data.room.talk_start_time,
                    end_time: response.data.room.talk_end_time,
                    user_id: response.data.room.user_id,
                    room_name: response.data.room.room_name,
                    provider_id: response.data.room.provider_id,
                    socket_participant_id: response.data.room.id,
                    others: response.data.other_people,
                    is_active: response.data.room.is_active,
                    user_image: response.data.room.user_image,
                    muted: false,
                    videoMuted: false,
                    mutedByTeacher: false,
                    videoMutedByTeacher: false,
                    is_anonym: response.data.room.is_anonym,
                    interactive_mode:response.data.room.interactive_mode,
                    total: response.data.room.duration

                }

                if (response.data.room.talk_type == consts.VOICE_CALL) {
                    document.getElementsByClassName('audioCallIconText')[0].classList.remove('dn')
                    document.getElementsByClassName('videoCallIconText')[0].classList.add('dn')
                }

                if (response.data.room.talk_type == consts.VIDEO_CALL) {
                    document.getElementsByClassName('audioCallIconText')[0].classList.add('dn')
                    document.getElementsByClassName('videoCallIconText')[0].classList.remove('dn')
                }



                window.localStorage.setItem('call', JSON.stringify(call))


                if (response.data.room.is_active == 1 || response.data.room.is_active == 2) {

                    try {

                        if (window.callingScreenIsOnTop === 1) {
                            try {
                                audio.pause()
                                closePopup('call-popup')
                                window.callingScreenIsOnTop = 0

                            } catch (error) {
                                Sentry.captureException(new AudioPauseError(error))
                            }
                        }
                    } catch (error) {
                        Sentry.captureException(new AudioPauseError(error))
                    }


                    let profile_image_calling_screen = document.getElementsByClassName('profile_image_calling_screen')[0]

                    if (call.call_type === consts.ONE_TO_ONE) {
                        if (call.provider_id == document.querySelector("meta[name='user_id']").getAttribute("content")) {
                            profile_image_calling_screen.src = response.data.room.user_image
                        } else {
                            profile_image_calling_screen.src = response.data.room.user_image
                        }
                    } else {
                        if (call.provider_id == document.querySelector("meta[name='user_id']").getAttribute("content")) {
                            profile_image_calling_screen.src = '/assets/images/talkilaLogo.png'
                        } else {
                            profile_image_calling_screen.src = (response.data.other_people[0].user_image != null || typeof response.data.other_people[0].user_image !== 'undefined') ? response.data.other_people[0].user_image : '/assets/images/talkilaLogo.png'
                        }
                    }

                    if (window.rejoinNotificationIsOnTheTop !== 1) {
                        window.rejoinNotificationIsOnTheTop = 1


                        let htmlForNotification = getHTMLforNotification(false, 0)

                        Toastify({

                            text: htmlForNotification,
                            className: "notification ttToast",
                            gravity: "top",
                            position: "right",
                            duration: -1,
                            close: true,
                            /*stopOnFocus: true, */
                            avatar: call.user_image,
                            escapeMarkup: false,
                            offset: {
                                x: 0,
                                y: 40
                            }

                        }).showToast()

                        setTimeout(function () {

                            function acceptTalkExtension(e) {
                                showLoading()
                                //this line is trigering click on the close icon, so close functionalities of the toast notifications are trigered also
                                eventFire(e.target.parentNode.parentNode.parentNode.getElementsByClassName('toast-close')[0], 'click')

                            }

                            function rejectTalkExtension(e) {
                                showLoading()
                                getCancelationReasons()



                                //this line is trigering click on the close icon, so close functionalities of the toast notifications are trigered also
                                //eventFire(e.target.parentNode.parentNode.parentNode.getElementsByClassName('toast-close')[0], 'click')

                                if (document.getElementById('rejecttalk')) {
                                    document.getElementById('rejecttalk').addEventListener('click', function () {
                                        closePopup('rejectRejonVideoTalk')
                                    })
                                }
                                if (document.getElementById('finalDecline')) {
                                    document.getElementById('finalDecline').addEventListener('click', function () {
                                        closePopup('rejectRejonVideoTalk')
                                        sendEvents(consts.HANGUP, {
                                            reason: 'User has just declined call'
                                        }, call)
                                        window.localStorage.removeItem('call');
                                        if (document.getElementsByClassName('ttToast')[0]) {
                                            document.getElementsByClassName('ttToast')[0].remove()
                                        }
                                    })
                                }
                            }

                            //adding event functions to the accept button
                            document.getElementsByClassName('accept-call-rejoin')[0].addEventListener('click', acceptTalkExtension)
                            document.getElementsByClassName('accept-call-rejoin')[0].addEventListener('click', acceptRejoinCall)

                            function acceptRejoinCall() {
                                window.location = '/talk/incall'
                            }
                            //adding event functions to the reject button
                            document.getElementsByClassName('reject-call-rejoin')[0].addEventListener('click', rejectTalkExtension)
                        })
                    }
                } else if (response.data.room.is_active == 0) {

                    openPopup('call-popup')

                    try {
                        if (window.rejoinNotificationIsOnTheTop === 1) {
                            if (document.getElementsByClassName('toastify')[0]) {
                                document.getElementsByClassName('toastify')[0].remove()
                            }
                            window.rejoinNotificationIsOnTheTop = 0
                        }
                    } catch (error) {
                        Sentry.captureException(new RejoinNoticiationError(error));
                    }

                    if (window.callingScreenIsOnTop !== 1) {
                        window.callingScreenIsOnTop = 1

                        audio.loop = true
                        audio.id = 'call-ring'
                        audio.play()

                        const others = response.data.other_people

                        let roomNames = document.getElementsByClassName('room-name')
                        let providerNames = document.getElementsByClassName('provider-name')
                        let roomDatetimes = document.getElementsByClassName('room-datetime')
                        let roomTypes = document.getElementsByClassName('room-type')
                        let talkTypes = document.getElementsByClassName('talk-type')
                        /* let roomCounts = document.getElementsByClassName('room-count') */

                        let profile_image_calling_screen = document.getElementsByClassName('profile_image_calling_screen')[0]

                        if (call.call_type === consts.ONE_TO_ONE) {
                            if (call.provider_id == document.querySelector("meta[name='user_id']").getAttribute("content")) {
                                profile_image_calling_screen.src = response.data.room.user_image
                            } else {
                                profile_image_calling_screen.src = response.data.room.user_image
                            }
                        } else {
                            if (call.provider_id == document.querySelector("meta[name='user_id']").getAttribute("content")) {
                                profile_image_calling_screen.src = '/assets/images/talkilaLogo.svg'
                            } else {
                                profile_image_calling_screen.src = (call.user_image != null || typeof call.user_image !== 'undefined') ? call.user_image : '/assets/images/talkilaLogo.svg'
                            }
                        }

                        for (let index = 0; index < roomNames.length; index++) {
                            const element = roomNames[index];
                            element.textContent = call.room_name
                        }

                        for (let index = 0; index < providerNames.length; index++) {
                            const element = providerNames[index];
                            element.textContent = response.data.room.provider_name /* + ' is calling you.' */
                        }



                        let callStartTime = isSafari ? call.start_time.replaceAll('-', '/') : call.start_time

                        var startTime = new Date(callStartTime);

                        startTime = new Date(startTime); // Date object

                        let callEndTime = isSafari ? call.end_time.replaceAll('-', '/') : call.end_time

                        var endTime = new Date(callEndTime);

                        endTime = new Date(endTime);

                        for (let index = 0; index < roomDatetimes.length; index++) {
                            const element = roomDatetimes[index];



                            element.textContent = addZero(startTime.getHours()) + ':' + addZero(startTime.getMinutes()) + ' - ' +
                                addZero(endTime.getHours()) + ':' + addZero(endTime.getMinutes()) + ' (' + call.total + ') minutes'
                        }

                        for (let index = 0; index < roomTypes.length; index++) {
                            const element = roomTypes[index];
                            element.textContent = call.call_type == consts.GROUP ? getPoTranslate('GALLERY') : getPoTranslate('PRIVATE')
                        }

                        for (let index = 0; index < talkTypes.length; index++) {
                            const element = talkTypes[index];
                            element.textContent = call.talk_type == consts.VIDEO_CALL ? getPoTranslate('VIDEO_TALK') : getPoTranslate('AUDIO') + ' ' + getPoTranslate('TALK')
                        }


                        if (call.call_type == consts.GROUP) {
                            if (response.data.other_people.length > 1) {
                                /* for (let index = 0; index < roomCounts.length; index++) {
                                    const element = roomCounts[index];
                                    element.textContent = ' ' + others.length + ' people'
                                }
                                document.getElementById('people-holder').innerHTML = "" */

                                for (let index = 0; index < others.length; index++) {
                                    const profileWrap = document.createElement('div')
                                    profileWrap.className = 'profile-wrap'

                                    const spanEl = document.createElement('span')
                                    const imgEl = document.createElement('img')
                                    const aEl = document.createElement('a')
                                    imgEl.title = others[index].name_of_user
                                    imgEl.src = others[index].user_image
                                    aEl.href = '#'
                                    aEl.appendChild(imgEl)

                                    profileWrap.appendChild(aEl)
                                    profileWrap.appendChild(spanEl)

                                    document.getElementById('people-holder').appendChild(profileWrap)
                                }
                            }

                        }

                        document.getElementById('declineCall').addEventListener('click', function () {
                            audio.pause()
                            sendEvents(consts.DECLINE, {}, call);
                            declineCall()
                        })

                        document.getElementById('closeCallPopup').addEventListener('click', function () {
                            audio.pause()
                            sendEvents(consts.DECLINE, {}, call);
                            declineCall()
                        })


                    }
                } else if (response.data.room.is_active == 9) {

                    declineCall()

                    try {

                        if (window.callingScreenIsOnTop === 1) {
                            try {
                                audio.pause()
                                closePopup('call-popup')
                                window.callingScreenIsOnTop = 0

                                audio = null
                            } catch (error) {
                                Sentry.captureException(new AudioPauseError(error))
                            }
                        }
                    } catch (error) {
                        Sentry.captureException(new AudioPauseError(error))
                    }




                } else {

                    try {

                        if (window.callingScreenIsOnTop === 1) {
                            try {
                                audio.pause()
                                closePopup('call-popup')
                                window.callingScreenIsOnTop = 0

                                audio = null
                            } catch (error) {
                                Sentry.captureException(new AudioPauseError(error))
                            }
                        }
                    } catch (error) {
                        Sentry.captureException(new AudioPauseError(error))
                    }

                    closePopup('call-popup')

                    try {
                        if (window.rejoinNotificationIsOnTheTop === 1) {
                            if (document.getElementsByClassName('ttToast')[0]) {
                                document.getElementsByClassName('ttToast')[0].remove()
                            }
                            window.rejoinNotificationIsOnTheTop = 0
                        }
                    } catch (error) {
                        Sentry.captureException(new RejoinNoticiationError(error))
                    }
                    if (document.getElementsByClassName('ttToast2')[0]) {
                        document.getElementsByClassName('ttToast2')[0].remove()
                    }
                }

            } else if (response.success === false) {

                closePopup('call-popup')

                try {
                    if (window.rejoinNotificationIsOnTheTop === 1) {
                        if (document.getElementsByClassName('toastify')[0]) {
                            document.getElementsByClassName('toastify')[0].remove()
                        }
                        window.rejoinNotificationIsOnTheTop = 0
                    }
                } catch (error) {
                    Sentry.captureException(new RejoinNoticiationError(error))
                }

                if (document.getElementsByClassName('ttToast2')[0]) {
                    document.getElementsByClassName('ttToast2')[0].remove()
                }

                try {

                    if (window.callingScreenIsOnTop === 1) {
                        try {
                            audio.pause()
                            closePopup('call-popup')
                            window.callingScreenIsOnTop = 0
                            audio = null
                        } catch (error) {
                            Sentry.captureException(new AudioPauseError(error))
                        }
                    }
                } catch (error) {
                    Sentry.captureException(new AudioPauseError(error))
                }


            }

        }
    }

    xhr.onerror = function (error) {

        Sentry.captureException(new SoketUserRoomsError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))

    }

    xhr.open("POST", socketServerUrl + "/api/user-rooms", true)

    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8')
    xhr.setRequestHeader('Accept', 'application/json')

    xhr.send(JSON.stringify(params))

}

function getHTMLforNotification(isSupplier, pointer) {
    if(pointer === 9){

        return `
            <div class="fr toastContMain">
                <div class="lefter">
                    <p class="fl cw p0m0 w-100 cc1">
                        ${isSupplier ? getPoTranslate('MESSAGE_FOR_SUPPLIER') : getPoTranslate('MESSAGE_FOR_CLIENT')}
                    </p>
                </div>
                <div class="righter df acc jcc">
                    <button class="green accept-call-rejoin">
                        ${getPoTranslate('JOIN')}
                    </button>
                    <button class="red reject-call-rejoin">
                        ${getPoTranslate('HANGUP_CALL')}
                    </button>
                </div>
            </div>
        `

    }else{
        return `
            <div class="fr toastContMain">
                <div class="lefter">
                    <p class="fl cw p0m0 w-100 cc1">
                        ${getPoTranslate('YOU_HAVE_CALL_GOING_ON')}
                    </p>
                </div>
                <div class="righter df acc jcc">
                    <button class="green accept-call-rejoin">
                        ${getPoTranslate('JOIN')}
                    </button>
                    <button class="red reject-call-rejoin">
                        ${getPoTranslate('HANGUP_CALL')}
                    </button>
                </div>
            </div>
        `
    }


}

function declineCall() {
    if (!document.getElementsByClassName('ttToast2')[0]) {
        let call = JSON.parse(window.localStorage.getItem('call'))

        closePopup('call-popup')

        try {

            if (window.callingScreenIsOnTop === 1) {
                try {
                    audio.pause()
                    closePopup('call-popup')
                    window.callingScreenIsOnTop = 0

                } catch (error) {
                    Sentry.captureException(new AudioPauseError(error))
                }
            }
        } catch (error) {
            Sentry.captureException(new AudioPauseError(error))
        }


        let isSupplier = call.provider_id == document.querySelector("meta[name='user_id']").getAttribute("content") ? true : false

        let htmlForNotification = getHTMLforNotification(isSupplier, 9)

        Toastify({

            text: htmlForNotification,
            className: "notification ttToast2 zi9998",
            gravity: "top",
            position: "right",
            duration: -1,
            close: true,
            /*stopOnFocus: true, */
            avatar: call.user_image,
            escapeMarkup: false,
            offset: {
                x: 0,
                y: 40
            }

        }).showToast()

        setTimeout(function () {

            function closeToastifyNotification(e) {
                showLoading()
                //this line is trigering click on the close icon, so close functionalities of the toast notifications are trigered also
                eventFire(e.target.parentNode.parentNode.parentNode.getElementsByClassName('toast-close')[0], 'click')

            }

            function rejectTalkExtension(e) {


                document.getElementById('hangupReasonsContainer').innerHTML = ''
                showLoading()

                getCancelationReasons()


                //this line is trigering click on the close icon, so close functionalities of the toast notifications are trigered also
                //eventFire(e.target.parentNode.parentNode.parentNode.getElementsByClassName('toast-close')[0], 'click')

                if (document.getElementById('rejecttalk')) {
                    document.getElementById('rejecttalk').addEventListener('click', function () {
                        closePopup('rejectRejonVideoTalk')
                    })
                }
                if (document.getElementById('finalDecline')) {
                    document.getElementById('finalDecline').addEventListener('click', function () {
                        closePopup('rejectRejonVideoTalk')
                        sendEvents(consts.HANGUP, {
                            reason: getPoTranslate('USER_HAS_JUST_DECLINE_CALL')
                        }, call)

                        if (document.getElementsByClassName('ttToast2')[0]) {
                            document.getElementsByClassName('ttToast2')[0].remove()
                        }


                    })
                }
            }

            //adding event functions to the accept button
            document.getElementsByClassName('accept-call-rejoin')[0].addEventListener('click', closeToastifyNotification)
            document.getElementsByClassName('accept-call-rejoin')[0].addEventListener('click', acceptRejoinCall)

            function acceptRejoinCall() {
                window.location = '/talk/incall'
            }
            //adding event functions to the reject button
            document.getElementsByClassName('reject-call-rejoin')[0].addEventListener('click', rejectTalkExtension)
        })
    }



}

function getCancelationReasons() {

    jQuery.ajax({
        type: 'GET',
        headers: {
            "Accept": 'application/json',
            "Application-Language": getCookie('activeLang')
        },
        url: '/frontend/api/calls-cancellation-reasons',
        data: {
            'booking_id': booking_id,
            '_token': token
        },

        success: function (response) {
            hideLoading()

            if (response.success) {

                let cancelationReasons = document.getElementById('hangupReasonsContainer')
                let items = response.data

                for (let i = 0; i < items.length; i++) {

                    let mainDivCancel = document.createElement('div')
                    mainDivCancel.className = 'radio-option-inner'

                    let mainInputCancel = document.createElement('input')
                    mainInputCancel.type = "radio"
                    mainInputCancel.className = "reason"
                    mainInputCancel.name = "pockets"
                    mainInputCancel.value = items[i].id
                    mainInputCancel.id = "pocketsRed-" + items[i].id

                    let mainLabelCancel = document.createElement('label')
                    mainLabelCancel.htmlFor = "pocketsRed-" + items[i].id
                    mainLabelCancel.textContent = items[i].value

                    mainDivCancel.append(mainInputCancel)
                    mainDivCancel.append(mainLabelCancel)

                    cancelationReasons.append(mainDivCancel)

                }

                calculatePopUpHeight(document.getElementById('rejectRejonVideoTalk'))
                openPopup('rejectRejonVideoTalk')

                return response.message;

            } else {
                toastify(response.message)
                return response.message;
            }
        },
        error: function (errorMessage) {
            Sentry.captureException(new GetExtendCallItemListError(errorMessage));
        }
    })

}

(function () {
    checkRooms()
})()

if (typeof AudioPauseError === 'undefined') {
    class _AudioPauseError extends Error {
        constructor(message) {
            super(message);
            this.name = 'AudioPauseError';
        }
    }
    window.AudioPauseError = _AudioPauseError;
}
if (typeof RejoinNoticiationError === 'undefined') {
    class _RejoinNoticiationError extends Error {
        constructor(message) {
            super(message);
            this.name = 'RejoinNoticiationError';
        }
    }
    window.RejoinNoticiationError = _RejoinNoticiationError;
}
