function ReconnectToRoom_Socket_Listen_Function(call) {
    window.Echo.channel("user." + call.socket_room_id).listen("ReconnectToRoom", function (data) {

        if (twilioRoom) {
            if (twilioRoom.hasOwnProperty('state')) {
                if (twilioRoom.state !== 'connected') {


                    fetch(socketServerUrl + '/api/room-status', {
                        method: "POST",
                        body: JSON.stringify({
                            socket_room_id: call.socket_room_id
                        }),
                        headers: {
                            "Content-type": "application/json; charset=UTF-8",
                            "Authorization": document.querySelector("meta[name='access_token']").content,
                            "Accept": "application/json"
                        }
                    }).then(response => response.json())
                        .then(response => {
                            connectToTwillioRoom(response.data, true)
                            document.getElementsByClassName("social-wrap")[0].classList.remove('dn')
                            document.getElementsByClassName("video-conference-page")[0].classList.remove('dn')
                        }).catch(function (error) {
                            console.log(error)
                        })



                }
            }
        }

    })
}

function ClientCallActions_Socket_Listen_Function(call) {
    window.Echo.channel("user." + call.user_id).listen("ClientCallActions", function (data) {
        console.log(data, 'krrrr');
        if (data.action_on == "video") {
            if (data.action == "off") {
                muteVideo(false)
            } else if (data.action == "on") {
                unmuteVideo(false)
            }
        } else if (data.action_on == "voice") {
            if (data.action == "off") {
                mute(false)
            } else if (data.action == "on") {
                unmute(false)
            }
        }
    })
}

function GlobalCallActions_Socket_Listen_Function(call) {
    window.Echo.channel("room." + call.socket_room_id).listen("GlobalCallActions", function (data) {
        if (data.action_on == "video") {
            if (data.action == "off") {
                muteVideo(false)
            } else if (data.action == "on") {
                unmuteVideo(false)
            }
        } else if (data.action_on == "voice") {
            if (data.action == "off") {
                mute(false)
            } else if (data.action == "on") {
                unmute(false)
            }
        }
    })
}

function ExtensionRejected_Socket_Listen_Function(call) {
    window.Echo.channel("user." + call.user_id).listen("ExtensionRejected", function (data) {
        if (call.call_type === CallTypes.ONE_TO_ONE) {

            document.getElementById('teacherExAnswerPicture').src = data.supplier_profile_picture
            document.getElementById('teacherExAnswerFullName').textContent = data.supplier_name
            document.getElementById('nameOfTeacherForPaymentExtension').textContent = data.supplier_name
            showAnswerPopup(getPoTranslate('HAS_NOT_APPROVED_TALK_EXTENDION'), 'rejectedExt')




            document.getElementById('rejectedExt').classList.remove('dn')


        } else if (call.call_type === CallTypes.GROUP) {
            //this is happening on student page
            setTimeout(function () {
                showAnswerPopup(getPoTranslate('HAS_NOT_APPROVED_TALK_EXTENDION'), 'rejectedExt')
            }, 320)
        }
    })
}

function ExtensionRequest_Socket_Listen_Function(call) {

    window.Echo.channel("user." + call.provider_id).listen("ExtensionRequest", function (data) {

        if (call.call_type === CallTypes.ONE_TO_ONE) {

            //adding values to text fields for teacher "talk extend" popup
            document.getElementById('extendedTimeAmout').textContent = data.message + ' '
            document.getElementById('extendAmountMoney').textContent = data.extension_price + ' '
            document.getElementById('pictureEx').src = data.client_profile_picture
            document.getElementById('studentNameEx').textContent = data.client_name
            document.getElementById('studentNameEx2').textContent = data.client_name


            //this popup is shown only to teacher
            openPopup('extendTeacherAnswer')
            addTeacherAcceptAndRejectEvents()
            //popup will be shown to the teacher, and teacher will click accepot or reject button

        } else if (call.call_type === CallTypes.GROUP) {
            //this toastify notification is shown only to teacher
            groupTalkExtendRequest(data)
            //notification will be shown to the teacher, and teacher will click accepot or reject button
        }

    })
}

function ExtensionAccepted_Socket_Listen_Function(call) {
    window.Echo.channel("user." + call.user_id).listen("ExtensionAccepted", function (data) {

        closePopup('extendAnswerAwait')
        console.log(data)
        document.getElementById('teacherExAnswerPicture').src = data.supplier_profile_picture
        document.getElementById('teacherExAnswerFullName').textContent = data.supplier_name
        document.getElementById('nameOfTeacherForPaymentExtension').textContent = data.supplier_name
        document.getElementById('extendTimeAccepted').textContent = data.message
        document.getElementById('extendAmoutAccepted').textContent = new Intl.NumberFormat(getCookie('activeLang'), {
            style: 'currency',
            currency: 'EUR'
        }).format(data.payment_amount).replace(/[^0-9.,]/g, '') + ' €'

        showAnswerPopup(getPoTranslate('HAS_APPROVED_TALK_EXTENDION'), 'acceptedExt')

        document.getElementById('rejectedExt').classList.add('dn')

    })
}

function EndCall_Socket_Listen_Function(call) {
    window.Echo.channel("room." + call.socket_room_id).listen("EndCall", function (data) {

        if (data.message.length > 0) {
            // show reason from the message here
            document.getElementById('reasonForCallEndTitle').classList.remove('dn')
            document.getElementById('reasonForCallEnd').classList.remove('dn')
            document.getElementById("reasonForCallEnd").innerHTML = data.message
        } else {
            document.getElementById('reasonForCallEnd').classList.remove('dn')
            document.getElementById("reasonForCallEnd").innerHTML = getPoTranslate('TALK_ENDED')
        }

        hideStuffOnEndCall()

        setReviewPopupups().then(() => {
            hideLoading()
        }).then(() => {
            calculatePopUpHeight(document.getElementById('reviewPopUp'))
        }).then(() => {
            let popupers = document.getElementsByClassName('popuper')
            for (let i = 0; i < popupers.length; i++) {
                if (popupers[i].parentElement.id !== 'reviewPopUp') {
                    closePopup(popupers[i].parentElement.id)
                }

            }
            openPopup('reviewPopUp')
        })

    })
}

function SingleUserNotify_Socket_Listen_Function(call) {
    window.Echo.channel("user." + call.user_id).listen("SingleUserNotify", function (data) {

        this.total = data.total_duration;
        this.end_time = data.end_time;
        this.start_time = data.start_time;

        document.getElementById('timeLeft').textContent = data.message

        call.duration = data.message
        call.total = data.total_duration
        call.end_time = data.end_time
        call.start_time = data.start_time

        document.getElementById('talkDuration').textContent = parseInt(data.total_duration)
        document.getElementById('timeGone').textContent = parseInt(data.total_duration) - parseInt(data.message)

        let call_type = call.call_type == CallTypes.ONE_TO_ONE ? 'ONE TO ONE' : 'GROUP'
        let talk_type = call.talk_type == 1 ? 'VOICE' : 'VIDEO'

        /* let start = new Date(data.start_time)
        let end = new Date( data.end_time)

        document.getElementById('startCalltime').textContent    = addZero(start.getHours()) + ':' + addZero(start.getMinutes())
        document.getElementById('endCallTime').textContent      = addZero(end.getHours()) + ':' + addZero(end.getMinutes()) */

        /* let timeShift = 0

        if(getCookie('timezone') !== ''){
            timeShift = parseInt(getCookie('timezone'))
        }

        let callStartTime = isSafari ?  data.start_time.replaceAll('-', '/') : data.start_time


        var startTime = new Date(callStartTime)
            startTime.setMinutes(startTime.getMinutes() + (timeShift > 0 ? timeShift : 0)) // timestamp
            startTime = new Date(startTime) // Date object


        let callEndTime = isSafari ? data.end_time.replaceAll('-', '/') : data.end_time


        var endTime = new Date(callEndTime)
            endTime.setMinutes(endTime.getMinutes() + (timeShift > 0 ? timeShift : 0)) // timestamp
            endTime = new Date(endTime)


        document.getElementById('startCalltime').textContent    = addZero(startTime.getHours()) + ':' + addZero(startTime.getMinutes())
        document.getElementById('endCallTime').textContent      = addZero(endTime.getHours()) + ':' + addZero(endTime.getMinutes()) */

        /* document.getElementsByClassName('languages-title')[0].textContent = start + ' - ' + end + ' - ' + call_type + ' - ' + talk_type */
        /* document.getElementById('startCalltime').textContent = start
        document.getElementById('endCallTime').textContent = end */
        // save back to storage so on refresh we have latest times
        localStorage.setItem('call', JSON.stringify(call))

        drawProgress(parseInt(data.total_duration) - parseInt(data.message), parseInt(data.total_duration))

        // Display or hide extension button
        /* if (call.user_type == UserTypes.CLIENT) {

             let timeLeft1 = parseInt(document.getElementById('timeLeft').textContent),
                 extendThisCallLi1 = document.getElementById("extendThisCallLi"),
                 videCta1 = document.getElementsByClassName('video-cta')[0]
              extendCallHelper(timeLeft1, extendThisCallLi1, videCta1)
         }*/
    })
}

function SingleUserExtension_Socket_Listen_Function(call) {
    window.Echo.channel("user." + call.user_id).listen("SingleUserExtension", function (data) {

        if (call.user_type == UserTypes.PROVIDER) {

            //ovde dodajemo podatke za provajdera
            document.getElementsByClassName('studentImageSuccesifulExtended')[0].src = data.client_profile_picture
            document.getElementsByClassName('studentNameSuccesifulExtended')[0].textContent = data.client_name
            document.getElementsByClassName('studentNameSuccesifulExtended')[1].textContent = data.client_name
            document.getElementById('extendedTimeAmout2').textContent = data.extension_minutes
            document.getElementById('extendAmountMoney2').textContent = data.extension_price

            openPopup('successfulExtendionPayment')
        }

        document.getElementById('extendedTimeZ').textContent = data.extension_minutes

        document.getElementById('timeLeft').textContent = data.message

        /*  const start = call.start_time.split(' ')[1].substr(0, 5) */
        // ovde ce trebati debugging
        // bilo je ovako
        //  const end = data.end_time.split('T')[1].substr(0, 5)

        /*  const end = data.end_time.split('T')[1].substr(0, 5) */

        /* let start = new Date(data.start_time) */

        let timeShift = 0

        if (getCookie('timezone') !== '') {
            timeShift = parseInt(getCookie('timezone'))
        }

        let callEndTime = isSafari ? data.end_time.replaceAll('-', '/') : data.end_time

        let endTime = new Date(callEndTime)
        endTime.setMinutes(endTime.getMinutes() + (timeShift > 0 ? timeShift : 0)) // timestamp
        endTime = new Date(endTime)

        document.getElementById('endCallTime').textContent = addZero(endTime.getHours()) + ':' + addZero(endTime.getMinutes())

        let end = new Date(data.end_time)

        /*  document.getElementById('startCalltime').textContent    = addZero(start.getHours()) + ':' + addZero(start.getMinutes()) */
        document.getElementById('endCallTime').textContent = addZero(end.getHours()) + ':' + addZero(end.getMinutes())

        document.getElementById('finishedPopupTimes').textContent = document.getElementById('startCalltime').textContent + ' - ' + addZero(end.getHours()) + ':' + addZero(end.getMinutes())
        /* document.getElementsByClassName('languages-title')[0].textContent = start + ' - ' + end + ' - ' + call_type + ' - ' + talk_type */
        /*
        call.total = data.total_duration
        call.duration = data.message
        call.end_time = data.end_time

        localStorage.setItem('call', JSON.stringify(call))

        drawProgress(parseInt(data.total_duration) - parseInt(data.message), parseInt(data.total_duration)) */

    })
}

function CallActionRequest_Socket_Listen_Function(call, userObj) {
    window.Echo.channel("room." + call.socket_room_id).listen("CallActionRequest", function (data) {

        if (data.user_id === userObj.id) {

            if (call.user_type == UserTypes.CLIENT) {

                addAudioMuteStudentIcon(data)
                addMuteProfesorVideo(data)
                addMuteStudentVideo(data)
            } else if (call.user_type == UserTypes.PROVIDER) {
                addAudioMuteProfesorIcon(data)
                addMuteProfesorVideo(data)
                addMuteStudentVideo(data)
            }

        } else {


            if (call.user_type == UserTypes.CLIENT) {

                if (data.user_id === professor) {

                    addAudioMuteProfesorIcon(data)
                    addMuteProfesorVideo(data)
                    addMuteStudentVideo(data)
                } else {

                    addAudioMuteStudentIcon(data)
                    addMuteProfesorVideo(data)
                    addMuteStudentVideo(data)
                }
            } else if (call.user_type == UserTypes.PROVIDER) {

                if (data.user_id !== professor) {
                    addAudioMuteStudentIcon(data)
                    addMuteStudentVideo(data)

                } else {

                    addAudioMuteProfesorIcon(data)
                    addMuteStudentVideo(data)
                }

            }
        }
    })
}

function addMuteStudentVideo(data) {

    let videoBox = document.getElementsByClassName('videoBox')
    let participantVideoFrame = getParticipantVideoFrame(data.user_id)
    for (let i = 0; i < videoBox.length; i++) {
        if (videoBox[i].dataset.id == data.user_id) {
            if (data.action === 'video') {

                if (data.action_state === 'off') {

                    participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.opacity = '0'

                    participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'

                    setTimeout(function () {

                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.display = 'none'
                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'
                        participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.display = 'flex'
                        setTimeout(function () {

                            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.opacity = '1'

                            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(1)'
                        }, 320)

                    }, 310)
                    let dropDownMenu = document.getElementsByClassName('dropdown-menu-field')[0]
                    if (call.user_type == UserTypes.PROVIDER) {

                        dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].dataset.video = '0'
                        let videoBoxOptionButtonSpans = dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].getElementsByTagName('span')
                        if (window.isProffessor !== 1) {

                            //videoBoxOptionButtonSpans[1].textContent = 'Video muted by student'
                        } else {

                            window.isProffessor = 0
                        }

                        dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].style.pointerEvents = 'none'

                    } else {
                        //let videoBoxOptionButtonSpans = dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].getElementsByTagName('span')
                    }

                } else if (data.action_state === 'on') {


                    participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.opacity = '0'
                    participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(0)'
                    setTimeout(function () {

                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.display = 'flex'
                        participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.display = 'none'
                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'
                        setTimeout(function () {

                            participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.opacity = '1'
                            participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(1)'
                        }, 320)
                    }, 310)
                    if (call.user_type == UserTypes.PROVIDER) {
                        let dropDownMenu = document.getElementsByClassName('dropdown-menu-field')[0]
                        dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].dataset.video = '1'
                        let videoBoxOptionButtonSpans = dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].getElementsByTagName('span')

                        videoBoxOptionButtonSpans[1].textContent = getPoTranslate('TURN_OFF_VIDEO')
                        dropDownMenu.getElementsByClassName('optionButtonVideoMuted')[0].style.pointerEvents = 'all'
                    }


                }
            }
        }
    }
}

function addMuteProfesorVideo(data) {

    if (document.getElementsByClassName('videoBoxProfesor')[0].dataset.userId == data.user_id) {
        if (data.action === 'video') {

            if (data.action_state === 'off') {

                document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("turnOnVideo")[0].style.transform = 'scale(0)'
                setTimeout(function () {
                    document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(1)'

                }, 310)
            } else if (data.action_state === 'on') {


                setTimeout(function () {
                    document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(0)'
                }, 310)
                setTimeout(function () {
                    document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("turnOnVideo")[0].style.transform = 'scale(1)'
                }, 610)


            }
        }
    }
}

function addAudioMuteProfesorIcon(data) {

    if (data.action === 'voice') {
        if (data.action_state === 'off') {
            if (document.getElementsByClassName('videoBoxProfesor')[0]) {
                let muteAudioDiv = document.createElement('div')
                muteAudioDiv.className = 'mutedMicrophoneProfessor'
                muteAudioDiv.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#ffffff"></path></svg>'

                if (document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0]) {
                    document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0].remove()
                }

                document.getElementsByClassName('videoBoxProfesor')[0].append(muteAudioDiv)



            }

        } else if (data.action_state === 'on') {

            if (document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0]) {
                document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0].remove()
            }
        }
    }
}

function addAudioMuteStudentIcon(data) {

    let videoBox = document.getElementsByClassName('videoBox')
    for (let i = 0; i < videoBox.length; i++) {

        if (videoBox[i].dataset.id == data.user_id) {

            if (data.action === 'voice') {
                if (data.action_state === 'off') {

                    let muteAudioDiv = document.createElement('div')
                    muteAudioDiv.className = 'mutedMicrophoneStudent'
                    muteAudioDiv.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#ffffff"></path></svg>'
                    if (videoBox[i].getElementsByClassName('mutedMicrophoneStudent')[0]) {
                        videoBox[i].getElementsByClassName('mutedMicrophoneStudent')[0].remove()
                    }
                    videoBox[i].append(muteAudioDiv)

                    if (call.user_type == UserTypes.PROVIDER) {
                        let dropDownMenu = document.getElementsByClassName('dropdown-menu-field')[0]
                        dropDownMenu.getElementsByClassName('optionButtonMuted')[0].dataset.muted = '1'
                        let videoBoxOptionButtonSpans = dropDownMenu.getElementsByClassName('optionButtonMuted')[0].getElementsByTagName('span')

                        videoBoxOptionButtonSpans[1].textContent = 'Muted by student'
                        /*  dropDownMenu.getElementsByClassName('optionButtonMuted')[0].style.pointerEvents ='none' */
                    } else {
                        if (document.getElementById('audio-mute-unmute')) {
                            document.getElementById('audio-mute-unmute').innerHTML = '<span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#172B4D"></path></svg></span>'

                        }
                        call.muted = true
                    }


                } else if (data.action_state === 'on') {
                    if (videoBox[i].getElementsByClassName('mutedMicrophoneStudent')[0]) {
                        videoBox[i].getElementsByClassName('mutedMicrophoneStudent')[0].remove()
                    }
                    if (call.user_type == UserTypes.PROVIDER) {
                        let dropDownMenu = document.getElementsByClassName('dropdown-menu-field')[0]
                        dropDownMenu.getElementsByClassName('optionButtonMuted')[0].dataset.muted = '0'
                        let videoBoxOptionButtonSpans = dropDownMenu.getElementsByClassName('optionButtonMuted')[0].getElementsByTagName('span')

                        videoBoxOptionButtonSpans[1].textContent = getPoTranslate('MUTE_USER')
                        /*  dropDownMenu.getElementsByClassName('optionButtonMuted')[0].style.pointerEvents ='auto' */
                    } else {
                        call.muted = false
                        if (document.getElementById('audio-mute-unmute')) {
                            document.getElementById('audio-mute-unmute').innerHTML = '<span><svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 1C7.20435 1 6.44129 1.31607 5.87868 1.87868C5.31607 2.44129 5 3.20435 5 4V12C5 12.7956 5.31607 13.5587 5.87868 14.1213C6.44129 14.6839 7.20435 15 8 15C8.79565 15 9.55871 14.6839 10.1213 14.1213C10.6839 13.5587 11 12.7956 11 12V4C11 3.20435 10.6839 2.44129 10.1213 1.87868C9.55871 1.31607 8.79565 1 8 1V1Z" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15 10V12C15 13.8565 14.2625 15.637 12.9497 16.9497C11.637 18.2625 9.85652 19 8 19C6.14348 19 4.36301 18.2625 3.05025 16.9497C1.7375 15.637 1 13.8565 1 12V10" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 19V23" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M4 23H12" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>'

                        }
                    }

                }
            }
        }
    }
}

function SingleUserEndCall_Socket_Listen_Function(call, twilioRoom) {
    window.Echo.channel("user." + call.user_id).listen("SingleUserEndCall", function (data) {

        if (data.is_kicked) {
            // show kicked popup here and get the reason from e.reason
            document.getElementById('reasonForCallEndTitle').classList.remove('dn')
            document.getElementById('reasonForCallEnd').classList.remove('dn')
            document.getElementById("reasonForCallEnd").innerHTML = data.reason
        } else {
            // show normal popup here
            document.getElementById('reasonForCallEnd').classList.remove('dn')
            document.getElementById("reasonForCallEnd").innerHTML = getPoTranslate('TALK_ENDED')
        }
        let popupers = document.getElementsByClassName('popuper')
        for (let i = 0; i < popupers.length; i++) {
            if (popupers[i].parentElement.id !== 'reviewPopUp') {
                closePopup(popupers[i].parentElement.id)
            }

        }

        try {
            twilioRoom.disconnect()
        } catch (error) {
            console.log(error)
        }

        hideStuffOnEndCall()

    })
}

function ClientRaiseHand_Socket_Listen_Function(call, others) {
    console.log('123', "room." + call.socket_room_id)
    window.Echo.channel("room." + call.socket_room_id).listen("ClientRaiseHand", function (data) {
        console.log('data received for ClientRaiseHand: ' + data, data)

        let client = others.filter(other => other.user_id === data.client_id)[0]

        if (call.user_type == UserTypes.CLIENT) {
            if (document.getElementById('raise_hand_list')) {
                let orderedList = document.getElementById('raise_hand_list').getElementsByTagName('ol')[0]

                let checkIfItIsAllreadyRaised = Array.from(orderedList.getElementsByTagName('li')).filter(li => li.dataset.userId == data.client_id)

                if (checkIfItIsAllreadyRaised.length === 0) {
                    let listItem = document.createElement('li')
                    listItem.dataset.userId = client.user_id
                    listItem.className = 'raised_hand_student_list_item'

                    let listItemInner = document.createElement('div')
                    listItemInner.className = 'df aic listItemInner'

                    let listItemInnerImage = document.createElement('img')
                    listItemInnerImage.src = client.user_image

                    listItemInner.append(listItemInnerImage)

                    let listItemInnerParagraf = document.createElement('p')
                    listItemInnerParagraf.innerHTML = client.name_of_user

                    listItemInner.append(listItemInnerParagraf)

                    listItem.append(listItemInner)

                    orderedList.appendChild(listItem)
                }


            }

        } else if (call.user_type == UserTypes.PROVIDER) {

            if (document.getElementById('raise_hand_list')) {
                let orderedList = document.getElementById('raise_hand_list').getElementsByTagName('ol')[0]

                let checkIfItIsAllreadyRaised = Array.from(orderedList.getElementsByTagName('li')).filter(li => li.dataset.userId == data.client_id)

                if (checkIfItIsAllreadyRaised.length === 0) {
                    let listItem = document.createElement('li')
                    listItem.dataset.userId = client.user_id
                    listItem.className = 'raised_hand_student_list_item'

                    let listItemInner = document.createElement('div')
                    listItemInner.className = 'df aic listItemInner'

                    let listItemInnerImage = document.createElement('img')
                    listItemInnerImage.src = client.user_image

                    listItemInner.append(listItemInnerImage)

                    let listItemInnerParagraf = document.createElement('p')
                    listItemInnerParagraf.innerHTML = client.name_of_user

                    listItemInner.append(listItemInnerParagraf)

                    let teacherRejectRaisedHand = document.createElement('div')
                    teacherRejectRaisedHand.textContent = '✖'
                    teacherRejectRaisedHand.className = 'acceptOrReject'

                    teacherRejectRaisedHand.addEventListener('click', function () {
                        listItem.remove()
                        SUPPLIER_REJECT_RAISED_HAND_Send_Event_Function(call, client.user_id)
                    })

                    listItemInner.append(teacherRejectRaisedHand)

                    let teacherAcceptRaisedHand = document.createElement('div')
                    teacherAcceptRaisedHand.className = 'acceptOrReject reject'
                    teacherAcceptRaisedHand.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.64998 14.1999L18.8499 5L20.2499 6.40006L9.64998 17L4 11.35L5.40006 9.94996L9.64998 14.1999Z" fill="#358b04"></path></svg>'

                    teacherAcceptRaisedHand.addEventListener('click', function () {
                        listItem.remove()
                        SUPPLIER_ACCEPT_RAISED_HAND_Send_Event_Function(call, client.user_id)

                        let stop_raise_handa = document.getElementById('stop_raise_hand')

                        stop_raise_handa.classList.remove('dn')
                        if(stop_raise_handa.dataset.event === '0'){
                            stop_raise_handa.addEventListener('click', function () {

                                stop_raise_handa.dataset.event = '1'

                                SUPPLIER_SET_CLIENT_AUDIO_OFF_Send_Event_Function(call, client.user_id)
                                SUPPLIER_SET_CLIENT_VIDEO_OFF_Send_Event_Function(call, client.user_id)

                                stop_raise_handa.classList.add('dn')
                            })
                        }

                    })

                    listItemInner.append(teacherAcceptRaisedHand)

                    listItem.append(listItemInner)

                    orderedList.appendChild(listItem)


                }


                Toastify({
                    text: '<div class="fr"><h5 class="fl cw p0m0 w-100">' + client.name_of_user + '</h5><p class="fl cw p0m0">' + getPoTranslate('HAS_RAISED_HAND') + '</p></div>',
                    className: "notification",
                    gravity: "bottom",
                    position: "left",
                    close: true,
                    duration: 3000,
                    stopOnFocus: true,
                    avatar: '/assets/images/raise_hand.svg',
                    escapeMarkup: false
                }).showToast()

            }

        }
    })
}

function SupplierAcceptRaisedHand_Socket_Listen_Function(call, others) {
    window.Echo.channel("room." + call.socket_room_id).listen("SupplierAcceptRaisedHand", function (data) {
        console.log('data received for SupplierAcceptRaisedHand: ', data)

        let provider = others.filter(other => other.user_id === call.provider_id)[0]
        let client = others.filter(other => other.user_id === data.client_id)[0]
        let orderedList = document.getElementById('raise_hand_list').getElementsByTagName('ol')[0]
        Array.from(orderedList.getElementsByTagName('li')).filter(li => li.dataset.userId == data.client_id)[0].remove()

        Toastify({
            text: '<div class="fr"><h5 class="fl cw p0m0 w-100">' + provider.name_of_user + '</h5><p class="fl cw p0m0">' + getPoTranslate('HAS_ACCEPT_CLIENT_RASING_HAND', { username: client.name_of_user }) + '</p></div>',
            className: "notification",
            gravity: "bottom",
            position: "left",
            close: true,
            duration: 5000,
            stopOnFocus: true,
            avatar: provider.user_image,
            escapeMarkup: false
        }).showToast()

        if (data.client_id === userObj1.id) {
            applyTracksSelectionInteractiveOne()

            muteUnmuteVideo()
            muteUnmute()

            let stop_raise_handa = document.getElementById('stop_raise_hand')

            stop_raise_handa.classList.remove('dn')

            if(stop_raise_handa.dataset.event === '0'){
                stop_raise_handa.addEventListener('click', function () {
                    stop_raise_handa.dataset.event = '1'
                    muteUnmuteVideo()
                    muteUnmute()
                    stop_raise_handa.classList.add('dn')
                })
            }


        }


    })
}

function SupplierRejectRaisedHand_Socket_Listen_Function(call, others) {
    window.Echo.channel("room." + call.socket_room_id).listen("SupplierRejectRaisedHand", function (data) {
        console.log('data received for SupplierRejectRaisedHand: ', data)

        let provider = others.filter(other => other.user_id === call.provider_id)[0]
        let client = others.filter(other => other.user_id === data.client_id)[0]
        let orderedList = document.getElementById('raise_hand_list').getElementsByTagName('ol')[0]
        Array.from(orderedList.getElementsByTagName('li')).filter(li => li.dataset.userId == data.client_id)[0].remove()

        Toastify({
            text: '<div class="fr"><h5 class="fl cw p0m0 w-100">' + provider.name_of_user + '</h5><p class="fl cw p0m0">' + getPoTranslate('HAS_REJECT_CLIENT_RASING_HAND', { username: client.name_of_user }) + '</p></div>',
            className: "notification",
            gravity: "bottom",
            position: "left",
            close: true,
            duration: 5000,
            stopOnFocus: true,
            avatar: provider.user_image,
            escapeMarkup: false
        }).showToast()

    })
}
