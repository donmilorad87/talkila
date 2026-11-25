function checkForMutedUsers(data) {



    let activeUsers = data ? data.active_users : dataObj.active_users
    let studentsvideoBox = document.getElementsByClassName('videoBox')

    if (call.user_type == UserTypes.CLIENT) {

        for (let i = 0; i < activeUsers.length; i++) {

            for (let j = 0; j < studentsvideoBox.length; j++) {

                if (studentsvideoBox[j].dataset.id == activeUsers[i].user_id) {

                    if (activeUsers[i].voice_status === 20) {


                        let muteAudioDiv = document.createElement('div')
                        muteAudioDiv.className = 'mutedMicrophoneStudent'
                        muteAudioDiv.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#ffffff"></path></svg>'

                        if (studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0]) {
                            studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0].remove()
                        }

                        studentsvideoBox[j].append(muteAudioDiv)

                        if (userObj1.id == activeUsers[i].user_id) {

                            call.muted = true
                            if(document.getElementById('audio-mute-unmute')){
                                document.getElementById('audio-mute-unmute').innerHTML = Icons.microphoneMuted
                            }

                        }
                    } else if (activeUsers[i].voice_status === 21) {

                        if (studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0]) {
                            studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0].remove()
                        }

                        if (userObj1.id == activeUsers[i].user_id) {

                            call.muted = false
                            if(document.getElementById('audio-mute-unmute')){
                                document.getElementById('audio-mute-unmute').innerHTML = Icons.microphone
                            }
                        }
                    }

                    if (activeUsers[i].video_status === 32) {
                        let participantVideoFrame = getParticipantVideoFrame(activeUsers[i].user_id)



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

                        if (userObj1.id == activeUsers[i].user_id) {

                            call.videoMuted = true
                            if (document.getElementById('video-mute-unmute')) {
                                document.getElementById('video-mute-unmute').innerHTML = Icons.cameraMuted
                            }


                        }
                    } else if (activeUsers[i].video_status === 31) {
                        //video will allready be unmuted
                        if (userObj1.id == activeUsers[i].user_id) {
                            call.videoMuted = false
                            if (document.getElementById('video-mute-unmute')) {
                                document.getElementById('video-mute-unmute').innerHTML = Icons.camera
                            }
                        }
                    }

                }
            }

            if (document.getElementsByClassName('videoBoxProfesor')[0].dataset.userId == activeUsers[i].user_id) {

                if (activeUsers[i].voice_status === 20) {
                    if (document.getElementsByClassName('videoBoxProfesor')[0]) {
                        let muteAudioDiv = document.createElement('div')
                        muteAudioDiv.className = 'mutedMicrophoneProfessor'
                        muteAudioDiv.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#ffffff"></path></svg>'
                        if (document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0]) {
                            document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0].remove()
                        }
                        document.getElementsByClassName('videoBoxProfesor')[0].append(muteAudioDiv)
                    }
                } else if (activeUsers[i].voice_status === 21) {
                    if (document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0]) {
                        document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0].remove()
                    }

                }

                if (activeUsers[i].video_status === 32) {

                    document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'
                    setTimeout(function () {
                        document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(1)'
                    }, 610)


                } else if (activeUsers[i].video_status === 31) {

                }

            }
        }
    } else if (call.user_type == UserTypes.PROVIDER) {

        for (let i = 0; i < activeUsers.length; i++) {
            for (let j = 0; j < studentsvideoBox.length; j++) {

                if (studentsvideoBox[j].dataset.id == activeUsers[i].user_id) {

                    if (activeUsers[i].voice_status === 20) {

                        let muteAudioDiv = document.createElement('div')
                        muteAudioDiv.className = 'mutedMicrophoneStudent'
                        muteAudioDiv.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#ffffff"></path></svg>'

                        if (studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0]) {
                            studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0].remove()
                        }

                        studentsvideoBox[j].append(muteAudioDiv)
                    } else if (activeUsers[i].voice_status === 21) {
                        if (studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0]) {
                            studentsvideoBox[j].getElementsByClassName('mutedMicrophoneStudent')[0].remove()
                        }
                    }

                    if (activeUsers[i].video_status === 32) {

                        let participantVideoFrame = getParticipantVideoFrame(activeUsers[i].user_id)

                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.opacity = '0'

                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'
                        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.display = 'none'

                        participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.display = 'flex'

                        setTimeout(function () {
                            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.display = 'flex'
                        })
                        setTimeout(function () {

                            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.opacity = '1'

                            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(1)'
                        }, 320)


                    } else if (activeUsers[i].video_status === 31) {

                    }

                }
            }

            if (document.getElementsByClassName('videoBoxProfesor')[0].dataset.userId == activeUsers[i].user_id) {

                if (activeUsers[i].voice_status === 20) {
                    let muteAudioDiv = document.createElement('div')
                    muteAudioDiv.className = 'mutedMicrophoneProfessor'
                    muteAudioDiv.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#ffffff"></path></svg>'
                    if (document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0]) {
                        document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0].remove()
                    }
                    document.getElementsByClassName('videoBoxProfesor')[0].append(muteAudioDiv)

                    if (userObj1.id == activeUsers[i].user_id) {
                        call.muted = true
                        if(document.getElementById('audio-mute-unmute')){
                            document.getElementById('audio-mute-unmute').innerHTML = Icons.microphoneMuted
                        }

                    }


                } else if (activeUsers[i].voice_status === 21) {
                    if (document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0]) {
                        document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('mutedMicrophoneProfessor')[0].remove()
                    }

                    if (userObj1.id == activeUsers[i].user_id) {

                        call.muted = false
                        if(document.getElementById('audio-mute-unmute')){
                            document.getElementById('audio-mute-unmute').innerHTML = Icons.microphone
                        }
                    }
                }


                if (activeUsers[i].video_status === 32) {
                    document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'
                    setTimeout(function () {
                        document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(1)'
                    }, 310)

                    if (userObj1.id == activeUsers[i].user_id) {
                        call.videoMuted = true
                        if (document.getElementById('video-mute-unmute')) {
                            document.getElementById('video-mute-unmute').innerHTML = Icons.cameraMuted
                        }
                    }


                } else if (activeUsers[i].video_status === 31) {
                    if (userObj1.id == activeUsers[i].user_id) {
                        call.videoMuted = false
                        if (document.getElementById('video-mute-unmute')) {
                            document.getElementById('video-mute-unmute').innerHTML = Icons.camera
                        }
                    }

                }

            }
        }
    }

}


/**
 * Mute or unmute audio of all on button click
 */
function muteUnmuteAll(e) {
    if (call.mutedAll) {
        unmuteAll(e)
    } else {
        muteAll(e)
    }
}

/**
 * Mute or unmute all video on button click
 */

function muteUnmuteVideoAll(e) {
    if (call.mutedVideoAll) {
        unmuteVideoAll(e)
    } else {
        muteVideoAll(e)
    }
}

/**
 * send event to server to mute audio of all participants
 */

function muteAll(e) {
    GROUP_SUPPLIER_SET_ALL_AUDIO_OFF_Send_Event_Function(call)
    call.mutedAll = true;
    if (e.target.dataset.pointer === "participants") {
        e.target.innerHTML = getPoTranslate('UNMUTE_ALL_PARTICIPANTS')
    } else {
        e.target.innerHTML = '<svg class="alignVH" width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.66667 5.49181L0.754181 1.57933L1.57914 0.75437L13.2458 12.421L12.4208 13.246L9.86161 10.6868C9.21614 11.1885 8.43541 11.5245 7.58333 11.6307V12.2502H9.33333V13.4168H4.66667V12.2502H6.41667V11.6307C4.11465 11.3437 2.33333 9.37994 2.33333 7.00016V5.8335H3.5V7.00016C3.5 8.93316 5.067 10.5002 7 10.5002C7.75589 10.5002 8.45582 10.2605 9.02796 9.85311L8.1853 9.01044C7.83792 9.21571 7.43272 9.3335 7 9.3335C5.71134 9.3335 4.66667 8.28883 4.66667 7.00016V5.49181ZM7.30217 8.12732C7.20579 8.15309 7.1045 8.16683 7 8.16683C6.35567 8.16683 5.83333 7.64449 5.83333 7.00016V6.65848L7.30217 8.12732ZM8.16667 2.91683V5.70853L9.33333 6.8752V2.91683C9.33333 1.62817 8.28866 0.583496 7 0.583496C5.92743 0.583496 5.0239 1.30717 4.75102 2.29289L5.83333 3.3752V2.91683C5.83333 2.2725 6.35567 1.75016 7 1.75016C7.64433 1.75016 8.16667 2.2725 8.16667 2.91683ZM11.2924 8.83429L10.3779 7.9198C10.4575 7.62675 10.5 7.31841 10.5 7.00016V5.8335H11.6667V7.00016C11.6667 7.65129 11.5333 8.27128 11.2924 8.83429Z" fill="#172B4D"/></svg>';
    }
}
/**
 * send event to server to unmute audio of all participants
 */
function unmuteAll(e) {
    GROUP_SUPPLIER_SET_ALL_AUDIO_ON_Send_Event_Function(call)
    call.mutedAll = false;
    if (e.target.dataset.pointer === "participants") {
        e.target.innerHTML = getPoTranslate('MUTE_ALL_PARTICIPANTS')
    } else {
        e.target.innerHTML = '<svg class="alignVH" width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 1C7.20435 1 6.44129 1.31607 5.87868 1.87868C5.31607 2.44129 5 3.20435 5 4V12C5 12.7956 5.31607 13.5587 5.87868 14.1213C6.44129 14.6839 7.20435 15 8 15C8.79565 15 9.55871 14.6839 10.1213 14.1213C10.6839 13.5587 11 12.7956 11 12V4C11 3.20435 10.6839 2.44129 10.1213 1.87868C9.55871 1.31607 8.79565 1 8 1V1Z" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15 10V12C15 13.8565 14.2625 15.637 12.9497 16.9497C11.637 18.2625 9.85652 19 8 19C6.14348 19 4.36301 18.2625 3.05025 16.9497C1.7375 15.637 1 13.8565 1 12V10" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 19V23" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M4 23H12" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
    }

}

/**
 * sends the event to server to mute video of all participants
 */
function muteVideoAll(e) {
    GROUP_SUPPLIER_SET_ALL_VIDEO_OFF_Send_Event_Function(call)
    call.mutedVideoAll = true;
    if (e.target.dataset.pointer === "participants") {
        e.target.innerHTML = getPoTranslate('TURN_ON_ALL_PARTICIPANTS')
    } else {
        e.target.innerHTML = '<svg class="alignVH" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.995811 0.170898L0.170853 0.995856L2.09169 2.91669H1.75C1.10567 2.91669 0.583338 3.43903 0.583338 4.08336V9.91669C0.583338 10.561 1.10567 11.0834 1.75 11.0834H8.75C9.15958 11.0834 9.51986 10.8723 9.72802 10.553L13.0042 13.8292L13.8291 13.0042L0.995811 0.170898ZM8.75 9.57501L3.25835 4.08336H1.75V9.91669H8.75V9.57501ZM9.91667 4.8895L13.4167 3.1395V10.7159L12.25 9.54925V5.02721L9.91667 6.19388V7.58382L8.75001 6.41715V4.08336H6.41622L5.24955 2.91669H8.75001C9.39434 2.91669 9.91667 3.43903 9.91667 4.08336V4.8895Z" fill="#172B4D"/></svg>';
    }
}

/**
 * sends the event to server to unmute video of all participants
 */
function unmuteVideoAll(e) {
    GROUP_SUPPLIER_SET_ALL_VIDEO_ON_Send_Event_Function(call)
    call.mutedVideoAll = false;

    if (e.target.dataset.pointer === "participants") {
        e.target.innerHTML = getPoTranslate('TURN_OFF_ALL_PARTICIPANTS')
    } else {
        e.target.innerHTML = '<svg class="alignVH" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 5.00049H15C16.1046 5.00049 17 5.89592 17 7.00049V8.38245L23 5.38245V18.6185L17 15.6185V17.0005C17 18.1051 16.1046 19.0005 15 19.0005H3C1.89543 19.0005 1 18.1051 1 17.0005V7.00049C1 5.89592 1.89543 5.00049 3 5.00049ZM17 13.3825L21 15.3825V8.61852L17 10.6185V13.3825ZM3 7.00049V17.0005H15V7.00049H3Z" fill="#172B4D"></path></svg>';
    }
}

/**
 * Mute or Unmute audio on the button click
 */
function muteUnmute() {
    if (call.muted) {
        if (!call.mutedByTeacher) {
            unmute()
        }
    } else {
        mute()
    }
}

/**
 * Mute or Unmute Video on the button click
 */

function muteUnmuteVideo() {

    if (call.videoMuted) {
        if (!call.videoMutedByTeacher) {
            unmuteVideo()
        }
    } else {

        muteVideo()
    }


}

/**
 * Mute the user's own audio - disable the audio tracks
 * @param sendEvent - true by default so it sends the event all the times - false when done via code
 */

function mute(sendEvent = true) {

    twilioRoom.localParticipant.audioTracks.forEach((publication) => {
        publication.track.disable()
        /* twilioRoom.localParticipant.unpublishTrack(publication.track)
        publication.track.detach().forEach((element) => {
            element.remove()
        }) */
    })

    if (sendEvent) {

        AUDIO_OFF_Send_Event_Function(call)

        call.muted = true
    } else {
        call.mutedByTeacher = true
    }
    if(document.getElementById("audio-mute-unmute")){
        document.getElementById("audio-mute-unmute").innerHTML = Icons.microphoneMuted
    }

}

/**
 * Unmute the user's own audio
 * @param sendEvent - true by default so it sends the event all the times - false when done via code
 */

function unmute(sendEvent = true) {
    twilioRoom.localParticipant.audioTracks.forEach((publication) => {
        publication.track.enable()
        /* twilioRoom.localParticipant.unpublishTrack(publication.track)
        publication.track.detach().forEach((element) => {
            element.remove()
        }) */
    })
    /* createLocalAudioTrack()
        .then((track) => {
            localAudioTrack = track
            return twilioRoom.localParticipant.publishTrack(localAudioTrack)
        }).then((publication) => {

            if (call.user_type == UserTypes.PROVIDER) {


                trackSubscribed(
                    document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("turnOnVideo")[0],
                    publication.track
                )


            } else {

                let participantVideoFrame = getParticipantVideoFrame(userObj1.id)

                trackSubscribed(
                    participantVideoFrame.getElementsByClassName('turnOnVideo')[0],
                    publication.track
                )

            }
        }) */

    if (sendEvent) {

        AUDIO_ON_Send_Event_Function(call)

        call.muted = false
    } else {
        call.mutedByTeacher = false
    }
    if(document.getElementById("audio-mute-unmute")){
        document.getElementById("audio-mute-unmute").innerHTML = Icons.microphone
    }



}


/**
 * mute the user's own video - disables the track - stops it and unpublishes it
 * @param sendEvent - true by default so it sends the event all the times - false when done via code
 */
function muteVideo(sendEvent = true) {

    if (call.user_type == UserTypes.PROVIDER) {
        document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("turnOnVideo")[0].style.transform = 'scale(0)'
    } else {

        let participantVideoFrame = getParticipantVideoFrame(userObj1.id)
        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.opacity = '0'

        participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(0)'

        setTimeout(function () {
            participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.display = 'none'
            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.display = 'flex'
            setTimeout(function () {
                participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.opacity = '1'

                participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(1)'
            }, 10)

        }, 310)

    }

    setTimeout(function () {

        twilioRoom.localParticipant.videoTracks.forEach((publication) => {

            if (publication.track.name !== 'screnShare') {
                publication.track.disable()
            }
        })

        if (sendEvent) {

            call.videoMuted = true

            VIDEO_OFF_Send_Event_Function(call)

        } else {
            call.videoMutedByTeacher = true
        }
        if(document.getElementById("video-mute-unmute")){
            document.getElementById("video-mute-unmute").innerHTML = '<span> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.70706 0.292969L0.292847 1.70718L3.58574 5.00008H2.99995C1.89538 5.00008 0.999953 5.89551 0.999953 7.00008V17.0001C0.999953 18.1046 1.89538 19.0001 2.99995 19.0001H15C15.7021 19.0001 16.3197 18.6383 16.6766 18.0909L22.2928 23.7072L23.7071 22.293L1.70706 0.292969ZM15 16.4143L5.58574 7.00008H2.99995V17.0001H15V16.4143ZM17 8.38204L23 5.38204V18.3702L21 16.3702V8.61811L17 10.6181V13.0009L15 11.0009V7.00008H10.9992L8.99917 5.00008H15C16.1045 5.00008 17 5.89551 17 7.00008V8.38204Z" fill="#172B4D"/></svg></span>';
        }
    }, 310)

    call.videoMuted = true
}

/**
 * Unmute the user's own video - creates a localvideotrack and publishes it
 * @param sendEvent - true by default so it sends the event all the times - false when done via code
 */
function unmuteVideo(sendEvent = true) {

    if (call.user_type == UserTypes.PROVIDER) {
        document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("turnOnVideo")[0].style.transform = 'scale(1)'
    } else {


        let participantVideoFrame = getParticipantVideoFrame(userObj1.id)
        participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.opacity = '0'

        participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.transform = 'scale(0)'



        setTimeout(function () {
            participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.display = 'flex'
            participantVideoFrame.getElementsByClassName('turnOfVideo')[0].style.display = 'none'
            setTimeout(function () {

                participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.opacity = '1'

                participantVideoFrame.getElementsByClassName('turnOnVideo')[0].style.transform = 'scale(1)'

            }, 10)

        }, 310)

    }

    twilioRoom.localParticipant.videoTracks.forEach((publication) => {

        if (publication.track.name !== 'screnShare') {
            publication.track.enable()
        }

    })


    if (sendEvent) {
        VIDEO_ON_Send_Event_Function(call)
        call.videoMuted = false
    } else {
        call.videoMutedByTeacher = false
    }
    if(document.getElementById("video-mute-unmute")){
        document.getElementById("video-mute-unmute").innerHTML = '<span> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 5.00049H15C16.1046 5.00049 17 5.89592 17 7.00049V8.38245L23 5.38245V18.6185L17 15.6185V17.0005C17 18.1051 16.1046 19.0005 15 19.0005H3C1.89543 19.0005 1 18.1051 1 17.0005V7.00049C1 5.89592 1.89543 5.00049 3 5.00049ZM17 13.3825L21 15.3825V8.61852L17 10.6185V13.3825ZM3 7.00049V17.0005H15V7.00049H3Z" fill="#172B4D"></path></svg></span>';

    }
    call.videoMuted = false
}
