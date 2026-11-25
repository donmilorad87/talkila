// room reference
let twilioRoom

// call reference
window.call = null

let checkForExtendionInterval = null
let others = null

let dataObj = null

let userObj1 = JSON.parse(document.getElementById('userObject').textContent.trim())

let professor = null

// function from package reference
let createLocalVideoTrack = null
let createLocalAudioTrack = null
let createLocalTracks = null
let connect = null
let isAudio = false


// tracks reference
let localAudioTrack = null
let localVideoTrack = null

// device selection object
let deviceSelections = {
    audioinput: document.querySelector('select#audioinput'),
    videoinput: document.querySelector('select#videoinput')
}

const ParticipantStates = {
    INACTIVE: 0,
    JOINED: 1,
    REJOINED: 2,
    HANGUP: 3,
    KICKED: 4,
    DIDNT_SHOW: 5
}

const CallInteractionTypes = {
    WATCH: 1,
    INTERACTIVE: 2,
    INTERACTIVE_ONE: 3
}

const RoomStates = {
    UNDEFINED: 0,
    ROOM_PENDING: 1,
    ROOM_DONE: 2,
    TEACHER_CANCELLED: 3,
    TEACHER_DONT_SHOW: 4,
    ROOM_IN_PROGRESS: 5,
    STUDENT_DONT_SHOW: 6
}

// call type constants
const CallTypes = {
    ONE_TO_ONE: 1,
    GROUP: 2
};


// talk type constants
const TalkTypes = {
    VOICE_CALL: 1,
    VIDEO_CALL: 2
};


// events constants
const Events = {
    UNDEFINED: 0,
    PICKUP: 10,
    HANGUP: 11,
    REDIAL: 12,
    CLIENT_WAITING: 13,
    SUPPLIER_WAITING: 14,
    TALK_END: 15,
    SUPPLIER_LEFT_ROOM: 16,
    CLIENT_LEFT_ROOM: 17,
    AUDIO_OFF: 20,
    AUDIO_ON: 21,
    VIDEO_ON: 31,
    VIDEO_OFF: 32,
    SPEAKER_ON: 40,
    SPEAKER_OFF: 41,
    EXTEND_CALL_TAB: 50,
    EXTEND_CALL_TIME_SELECTED: 51,
    EXTEND_CALL_SWIPED: 52,
    EXTEND_CALL_SUCCESSFUL: 53,
    EXTEND_CALL_FAILURE: 54,
    EXTEND_CALL_ACCEPT: 55,
    EXTEND_CALL_REJECT: 56,
    EXTEND_CALL_REQUEST: 57,
    EXTEND_CALL_CANCELLED: 58,
    CONNECTION_LOST: 90,
    APP_CRASH_CLIENT: 91,
    APP_CRASH_PROVIDER: 92,
    GROUP_SUPPLIER_SET_ALL_AUDIO_OFF: 100,
    GROUP_SUPPLIER_SET_ALL_AUDIO_ON: 101,
    GROUP_SUPPLIER_SET_ALL_VIDEO_OFF: 102,
    GROUP_SUPPLIER_SET_ALL_VIDEO_ON: 103,
    SUPPLIER_SET_CLIENT_AUDIO_OFF: 104,
    SUPPLIER_SET_CLIENT_AUDIO_ON: 105,
    SUPPLIER_SET_CLIENT_VIDEO_OFF: 106,
    SUPPLIER_SET_CLIENT_VIDEO_ON: 107,
    KICK_PARTICIPANT: 108,
    SUPPLIER_ON_HOLD: 120,
    SUPPLIER_ON_HOLD_BACK: 121,
    CLIENT_ON_HOLD: 125,
    CLIENT_ON_HOLD_BACK: 126,
    SCREEN_SHARE_ON: 150,
    SCREEN_SHARE_OFF: 151,
    RECONNECT_TO_ROOM: 160,
    DECLINE: 9,
    CLIENT_RAISE_HAND: 170,
    SUPPLIER_ACCEPT_RAISED_HAND: 171,
    SUPPLIER_REJECT_RAISED_HAND: 172
};

// user type constants
const UserTypes = {
    CLIENT: 1,
    PROVIDER: 2
};

const Icons = {
    microphone: '<svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 1C7.20435 1 6.44129 1.31607 5.87868 1.87868C5.31607 2.44129 5 3.20435 5 4V12C5 12.7956 5.31607 13.5587 5.87868 14.1213C6.44129 14.6839 7.20435 15 8 15C8.79565 15 9.55871 14.6839 10.1213 14.1213C10.6839 13.5587 11 12.7956 11 12V4C11 3.20435 10.6839 2.44129 10.1213 1.87868C9.55871 1.31607 8.79565 1 8 1V1Z" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15 10V12C15 13.8565 14.2625 15.637 12.9497 16.9497C11.637 18.2625 9.85652 19 8 19C6.14348 19 4.36301 18.2625 3.05025 16.9497C1.7375 15.637 1 13.8565 1 12V10" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 19V23" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M4 23H12" stroke="#172B4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>',
    microphoneMuted: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.99995 9.41421L1.29285 2.70711L2.70706 1.29289L22.7071 21.2929L21.2928 22.7071L16.9056 18.3199C15.7991 19.18 14.4607 19.756 13 19.9381V21H16V23H7.99995V21H11V19.9381C7.05364 19.446 3.99995 16.0796 3.99995 12V10H5.99995V12C5.99995 15.3137 8.68624 18 12 18C13.2958 18 14.4957 17.5892 15.4765 16.8907L14.0319 15.4462C13.4364 15.7981 12.7418 16 12 16C9.79081 16 7.99995 14.2091 7.99995 12V9.41421ZM12.518 13.9323C12.3528 13.9764 12.1791 14 12 14C10.8954 14 9.99995 13.1046 9.99995 12V11.4142L12.518 13.9323ZM14 5V9.78579L16 11.7858V5C16 2.79086 14.2091 1 12 1C10.1613 1 8.61234 2.24059 8.14456 3.93039L9.99995 5.78579V5C9.99995 3.89543 10.8954 3 12 3C13.1045 3 14 3.89543 14 5ZM19.3584 15.1442L17.7907 13.5765C17.9271 13.0741 18 12.5456 18 12V10H20V12C20 13.1162 19.7713 14.1791 19.3584 15.1442Z" fill="#172B4D"></path></svg>',
    camera: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 5.00049H15C16.1046 5.00049 17 5.89592 17 7.00049V8.38245L23 5.38245V18.6185L17 15.6185V17.0005C17 18.1051 16.1046 19.0005 15 19.0005H3C1.89543 19.0005 1 18.1051 1 17.0005V7.00049C1 5.89592 1.89543 5.00049 3 5.00049ZM17 13.3825L21 15.3825V8.61852L17 10.6185V13.3825ZM3 7.00049V17.0005H15V7.00049H3Z" fill="#172B4D"></path></svg>',
    cameraMuted: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.70706 0.292969L0.292847 1.70718L3.58574 5.00008H2.99995C1.89538 5.00008 0.999953 5.89551 0.999953 7.00008V17.0001C0.999953 18.1046 1.89538 19.0001 2.99995 19.0001H15C15.7021 19.0001 16.3197 18.6383 16.6766 18.0909L22.2928 23.7072L23.7071 22.293L1.70706 0.292969ZM15 16.4143L5.58574 7.00008H2.99995V17.0001H15V16.4143ZM17 8.38204L23 5.38204V18.3702L21 16.3702V8.61811L17 10.6181V13.0009L15 11.0009V7.00008H10.9992L8.99917 5.00008H15C16.1045 5.00008 17 5.89551 17 7.00008V8.38204Z" fill="#172B4D"></path></svg>'
}

let LocalVideoTrack
// network quality mapping
const NetworkQuality = ['Network broken (reconnecting)', 'Very bad network', 'Bad network', 'Average network', 'Good network', 'Very good network']

// on click connect hide call settings and connect to the room

if (document.getElementById("room-connect-button")) {
    document.getElementById("room-connect-button").addEventListener('click', function () {

        if (isAudio) {
            applyTracksSelection([localAudioTrack], false)
            showNoAccessLabel(true, call)
        } else {

            applyTracksSelection([localAudioTrack, localVideoTrack], false)
        }

        //closePopup('callSetting')
        this.classList.add('dn')
        window.appliedTrackclicked = 1
        closePopup('callSetting')
    })

}


function getRoomStatus(response) {

    if (response.success === true) {

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
            interactive_mode: response.data.room.interactive_mode,
            total: response.data.room.duration

        }

        window.localStorage.setItem('call', JSON.stringify(call))

        preCallConfiguration()
        getRoomStatusBeforeConnect()

    } else if (response.success === false) {
        toastify(getPoTranslate('SOMETHING_WENT_WRONG'))
        location.assign('/')

    }
}

/**
 * First function thats called on moving to talk page
 * @param connectFun - Connection function from twilio package
 * @param createLocalTracksFun - local tracks creation function from twilio package
 * @param createLocalVideoTrackFun - local video track creation function from twilio package
 * @param createLocalAudioTrackFun - local audio track creation function from twilio package
 */

function connectToSocket(connectFun, createLocalTracksFun, createLocalVideoTrackFun, createLocalAudioTrackFun, LocalVideoTrac) {

    showLoading()

    connect = connectFun
    LocalVideoTrack = LocalVideoTrac
    createLocalTracks = createLocalTracksFun
    createLocalVideoTrack = createLocalVideoTrackFun
    createLocalAudioTrack = createLocalAudioTrackFun

    let fromAppObj

    try {
        fromAppObj = document.getElementById('fromAppObj').value
        history.pushState({}, document.title, location.origin + location.pathname)

    } catch (error) {
        fromAppObj = false

    }

    if (!fromAppObj) {
        call = JSON.parse(window.localStorage.getItem('call'))
        if (!call) {
            console.error('No call data found in localStorage')
            toastify(getPoTranslate('SOMETHING_WENT_WRONG'))
            setTimeout(() => {
                location.assign('/')
            }, 3000)
            return
        }
        preCallConfiguration()
        getRoomStatusBeforeConnect()
        console.log('we are here 0');
    } else {
        console.log('we are here 1');
        fetch(socketServerUrl + '/api/user-rooms', {
            method: "POST",
            body: JSON.stringify({
                _token: token
            }),
            headers: {
                "Content-type": "application/json; charset=UTF-8",
                "Authorization": bearerToken,
                "Accept": "application/json"
            }
        }).then(response => response.json())
            .then(response => {

                getRoomStatus(response)

            }).catch(function (error) {
                console.log(error)
                toastify(getPoTranslate('SOMETHING_WENT_WRONG'))
                location.assign('/')
            })
    }
}




/**
 * Deals with connecting the room and binding all necessary events
 */
function connectToRoom(data) {
    console.log('usli smo u room connect');
    if (call.user_type == UserTypes.CLIENT) {
        if (call.interactive_mode === CallInteractionTypes.WATCH) {
            document.getElementById('callSettingsInner').innerHTML = ''
            document.getElementById('enterRoom').classList.remove('dn')
            document.getElementById('studentContainer').classList.add('dn')
            document.getElementById('viewUsTab').classList.add('dn')
            if (document.getElementById("video-mute-unmute")) {
                document.getElementById('video-mute-unmute').parentElement.remove()
            }
            if (document.getElementById("audio-mute-unmute")) {
                document.getElementById('audio-mute-unmute').parentElement.remove()
            }


            document.getElementById('mainVideoBigFrame').classList.remove('small-8')
            document.getElementById('mainVideoBigFrame').classList.add('small-12')

            document.getElementsByClassName('noCamAndMicAccess')[0].classList.add('dn')

            document.getElementsByClassName('privateMobileSettings')[0].remove()

            let muteAllVideo = document.getElementsByClassName('mute-all-video')
            for (let i = 0; i < muteAllVideo.length; i++) {
                muteAllVideo[i].parentElement.remove()

            }

            let muteAllAudio = document.getElementsByClassName('mute-all-audio')
            for (let i = 0; i < muteAllAudio.length; i++) {
                muteAllAudio[i].parentElement.remove()

            }
            document.getElementById('settingsForMobile').remove()
            document.getElementById('settingsForTalk').remove()

        } else if (call.interactive_mode === CallInteractionTypes.INTERACTIVE_ONE) {


            /* document.getElementById('studentContainer').classList.add('dn')
            document.getElementById('viewUsTab').classList.add('dn') */

            if (document.getElementById("video-mute-unmute")) {
                document.getElementById('video-mute-unmute').parentElement.remove()
            }
            if (document.getElementById("audio-mute-unmute")) {
                document.getElementById('audio-mute-unmute').parentElement.remove()
            }
            /*
                        document.getElementById('mainVideoBigFrame').classList.remove('small-8')
                        document.getElementById('mainVideoBigFrame').classList.add('small-12') */

            let muteAllVideo = document.getElementsByClassName('mute-all-video')
            for (let i = 0; i < muteAllVideo.length; i++) {
                muteAllVideo[i].parentElement.remove()

            }

            let muteAllAudio = document.getElementsByClassName('mute-all-audio')
            for (let i = 0; i < muteAllAudio.length; i++) {
                muteAllAudio[i].parentElement.remove()

            }

        }
    } else {
        if (call.interactive_mode === CallInteractionTypes.WATCH) {
            document.getElementById('studentContainer').classList.add('dn')
            document.getElementById('viewUsTab').classList.add('dn')

            document.getElementById('groupMuteUnmuteContainer').remove()

            let muteAllVideo = document.getElementsByClassName('mute-all-video')
            for (let i = 0; i < muteAllVideo.length; i++) {
                muteAllVideo[i].parentElement.remove()

            }

            let muteAllAudio = document.getElementsByClassName('mute-all-audio')
            for (let i = 0; i < muteAllAudio.length; i++) {
                muteAllAudio[i].parentElement.remove()

            }

            document.getElementById('mainVideoBigFrame').classList.remove('small-8')
            document.getElementById('mainVideoBigFrame').classList.add('small-12')
        }

    }
    openPopup('callSetting')

    // setting isAudio for first time
    isAudio = call.talk_type == TalkTypes.VOICE_CALL

    if (call.user_type == UserTypes.CLIENT) {
        if (call.is_anonym === 1) {
            isAudio = true
        }
    }


    if (call.call_type === CallTypes.GROUP) {

        document.getElementsByTagName('main')[0].classList.add('groupCallMainFrame')

        document.getElementById('mainVideoBigFrame').classList.add('small-8')


        document.getElementsByClassName('showPartClick')[0].classList.remove('dn')
        document.getElementsByClassName('lMobile')[0].classList.remove('dn')
        document.getElementsByClassName('showMobileSettingsPanel')[0].parentElement.classList.remove('dn')



        // global call actions from provider
        let muteAllAudio = document.getElementsByClassName('mute-all-audio'),
            muteAllVideo = document.getElementsByClassName('mute-all-video')

        if (call.user_type == UserTypes.PROVIDER) {

            if (call.interactive_mode === CallInteractionTypes.INTERACTIVE_ONE) {
                document.getElementById('raise_hand_list_button').classList.remove('dn')
                document.getElementById('raise_hand').classList.add('dn')
            } else {
                document.getElementById('raise_hand_list_button').remove()
                document.getElementById('raise_hand').remove()
            }

            for (let i = 0; i < muteAllAudio.length; i++) {
                muteAllAudio[i].classList.remove('dn')
                muteAllAudio[i].addEventListener('click', muteUnmuteAll)
            }

            if (isAudio) {
                for (let i = 0; i < muteAllVideo.length; i++) {
                    muteAllVideo[i].parentElement.removeChild(muteAllVideo[i])

                }

            } else {
                for (let i = 0; i < muteAllVideo.length; i++) {
                    muteAllVideo[i].classList.remove('dn')
                    muteAllVideo[i].addEventListener('click', muteUnmuteVideoAll)
                }
            }

        } else if (call.user_type == UserTypes.CLIENT) {
            if (call.interactive_mode === CallInteractionTypes.INTERACTIVE_ONE) {
                document.getElementById('raise_hand_list_button').classList.remove('dn')
                document.getElementById('raise_hand').classList.remove('dn')
            } else {
                document.getElementById('raise_hand_list_button').remove()
                document.getElementById('raise_hand').remove()
            }

            // hide if not group or i am not provider
            for (let i = 0; i < muteAllAudio.length; i++) {
                muteAllAudio[i].parentElement.removeChild(muteAllAudio[i])
                muteAllVideo[i].parentElement.removeChild(muteAllVideo[i])
            }

            // global action listeners
            //inside of this function we are listening for the ClientCallActions socket event
            ClientCallActions_Socket_Listen_Function(call)

            //inside of this function we are listening for the GlobalCallActions socket event
            GlobalCallActions_Socket_Listen_Function(call)

            if (document.getElementById('raise_hand')) {
                document.getElementById('raise_hand').addEventListener('click', function () {
                    CLIENT_RAISE_HAND_Send_Event_Function(call)
                })
            }


        }

        if (document.getElementById('raise_hand_list_button')) {
            document.getElementById('raise_hand_list_button').addEventListener('click', function () {
                if (document.getElementById('raise_hand_list')) {
                    if (document.getElementById('raise_hand_list_button').dataset.opened === "1") {
                        document.getElementById('raise_hand_list').style.right = '-1000px'
                        document.getElementById('raise_hand_list_button').dataset.opened = '0'
                    } else {
                        document.getElementById('raise_hand_list').style.right = '0px'
                        document.getElementById('raise_hand_list_button').dataset.opened = '1'
                    }

                }
            })
        }

    } else if (call.call_type === CallTypes.ONE_TO_ONE) {

    }



    //get supplier id
    let client_profile_picture
    for (let i = 0; i < others.length; i++) {
        if (others[i].user_id != call.provider_id) {
            client_profile_picture = others[i].user_image
        }

    }


    // Display or hide extension button
    if (call.user_type == UserTypes.CLIENT) {


        checkForExtendionInterval = setInterval(() => {
            checkIfThereExtendSlotsAvailable()
        }, 60000)

        checkIfThereExtendSlotsAvailable()

        function checkIfThereExtendSlotsAvailable() {


            jQuery.ajax({
                type: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Time-Zone-Offset-UTC': getCookie('timezone'),
                },
                data: {
                    '_token': token,
                },
                url: '/frontend/api/teacher-available-extensions',

                complete: function () {
                    hideLoading();
                },

                success: function (response) {

                    if (response.success) {

                        let count = 0;

                        if (response.data) {


                            let obj = response.data

                            for (let i = 0; i < Object.keys(obj).length; i++) {

                                if (obj[Object.keys(obj)[i]].success === true) {

                                    count++;
                                    //show button
                                    if (document.getElementById('extendThisCallLi')) {
                                        document.getElementById('extendThisCallLi').classList.remove('dn')
                                    }
                                    if (document.getElementById('extendMobile')) {
                                        document.getElementById('extendMobile').parentElement.classList.remove('dn')
                                    }

                                }

                            }


                        }

                        if (count === 0) {

                            //hidde button
                            if (document.getElementById('extendThisCallLi')) {
                                document.getElementById('extendThisCallLi').classList.add('dn')
                            }
                            if (document.getElementById('extendMobile')) {
                                document.getElementById('extendMobile').parentElement.classList.add('dn')
                            }
                        }
                    } else {

                        //hide button
                        if (document.getElementById('extendThisCallLi')) {
                            document.getElementById('extendThisCallLi').classList.add('dn')
                        }
                        if (document.getElementById('extendMobile')) {
                            document.getElementById('extendMobile').parentElement.classList.add('dn')
                        }
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new checkIfThereExtendSlotsAvailableError(errorMessage + ' || URL: ' + location.href));
                },

            })


            class checkIfThereExtendSlotsAvailableError extends Error {
                constructor(message) {
                    super(message);
                    this.name = 'checkIfThereExtendSlotsAvailableError';
                }
            }

        }

        extendCallLogicsStudent(call)

        //cancel extend call


        let cancelExtends = document.getElementsByClassName('cancelExtend')
        for (let i = 0; i < cancelExtends.length; i++) {
            cancelExtends[i].addEventListener('click', function () {

                sendEvents(Events.EXTEND_CALL_CANCELLED, {}, call)

            })

        }

        SupplierRejectRaisedHand_Socket_Listen_Function(call, others)
        SupplierAcceptRaisedHand_Socket_Listen_Function(call, others)

    } else if (call.user_type == UserTypes.PROVIDER) {
        extendCallLogicsProfesor(call)

        window.Echo.channel("user." + call.provider_id).listen("ExtensionCancelled", function (data) {

            if (document.getElementById('userCanceledExtendionImage')) {
                document.getElementById('userCanceledExtendionImage').src = data.client_profile_picture
            }
            if (document.getElementById('userCanceledExtendionName')) {
                document.getElementById('userCanceledExtendionName').textContent = data.client_full_name
            }
            if (document.getElementById('userCanceledExtendionMessage')) {
                document.getElementById('userCanceledExtendionMessage').textContent = data.message
            }

            openPopup('cancelExtendion')

        })
    }


    // global socket events for anytype of participant
    // Deals with ending the call - this socket event will end call no matter whate
    EndCall_Socket_Listen_Function(call)
    // Deals with ending the call for the single user - kick or just one user is hang up his group call. other users and teacher will stay in call
    SingleUserEndCall_Socket_Listen_Function(call, twilioRoom)

    // Deals with minute time update from server
    SingleUserNotify_Socket_Listen_Function(call)

    // on successfull extension - after extendion this event upadte progress drawings and input new values: end time and time left
    SingleUserExtension_Socket_Listen_Function(call)


    //joining event video mute on/off - audio mute on/off
    if (!isAudio) {
        if (document.getElementById("video-mute-unmute")) {
            document.getElementById("video-mute-unmute").addEventListener('click', muteUnmuteVideo)
        }

    } else {
        if (document.getElementById("video-mute-unmute")) {
            document.getElementById("video-mute-unmute").classList.add('dn')
        }
    }

    // mute / unmute button listeners
    if (document.getElementById("audio-mute-unmute")) {
        document.getElementById("audio-mute-unmute").addEventListener('click', muteUnmute)
    }

    document.getElementById("video-disconnect").addEventListener('click', disConnectFromRoom)

    //connecting to twilio api
    connectToTwillioRoom(data)

}

function connectToTwillioRoom(data, pointerForRecconection) {

    let audio = true

    if (call.user_type == UserTypes.CLIENT && call.interactive_mode === CallInteractionTypes.WATCH) {
        audio = false
    }

    connect(call.access_token, {
        audio: false,
        video: false,
        name: call.socket_room_id,
        networkQuality: {
            local: 1, // LocalParticipant's Network Quality verbosity [1 - 3]
            remote: 2 // RemoteParticipants' Network Quality verbosity [0 - 3]
        }
    }).then(
        function (room) {

            // keep room for later reference
            twilioRoom = room

            document.getElementById('time-left-wrapper').style.display = 'flex'
            if (!pointerForRecconection) {
                // send pickup event

                let user

                for (let i = 0; i < others.length; i++) {
                    if (others[i].user_id === userObj1.id) {
                        user = others[i]

                    }
                }

                if (user.is_active === ParticipantStates.INACTIVE) {
                    PICKUP_Send_Event_Function(call)
                } else if (user.is_active === ParticipantStates.JOINED) {
                    REDIAL_Send_Event_Function(call)
                } else if (user.is_active === ParticipantStates.REJOINED) {
                    REDIAL_Send_Event_Function(call)
                }
            }



            // deal with already present other participants
            twilioRoom.participants.forEach((participant) => {
                participantConnected(participant, call)
            })

            // deal with pariticpants comming later on
            twilioRoom.on("participantConnected", participantConnected)
            twilioRoom.on("participantDisconnected", participantDisconnected)

            /* twilioRoom.on('tokenAboutToExpire', function() {
                    // Implement fetchToken() to make a secure request to your backend to retrieve a refreshed access token.
                    // Use an authentication mechanism to prevent token exposure to 3rd parties.
                fetchToken(function(updatedToken) {
                    twilioRoom.updateToken(updatedToken);
                });
            }); */


            // when i disconnect
            twilioRoom.on("disconnected", function (room) {

                if (room.localParticipant.tracks.length) {
                    room.localParticipant.tracks.forEach((publication) => {

                        publication.track.stop()

                        const attachedElements = publication.track.detach()

                        attachedElements.forEach((element) => element.remove())
                        if (call.user_type == UserTypes.CLIENT) {
                            clearInterval(checkForExtendionInterval)
                        }


                    })
                }

            })

            //onunload occurs when the user navigates away from the page
            //disconect from socket server
            window.onunload = function (event) {
                window.Echo.disconnect()
                if (call.user_type == UserTypes.CLIENT) {
                    clearInterval(checkForExtendionInterval)
                }
            }

            window.addEventListener('beforeunload', () => {
                twilioRoom.disconnect()
                if (call.user_type == UserTypes.CLIENT) {
                    clearInterval(checkForExtendionInterval)
                }
            })

            // Set the name of the "hidden" property and the change event for visibility
            var hidden, visibilityChange
            if (typeof document.hidden !== "undefined") {
                hidden = "hidden"
                visibilityChange = "visibilitychange"
            } else if (typeof document.mozHidden !== "undefined") { // Firefox up to v17
                hidden = "mozHidden"
                visibilityChange = "mozvisibilitychange"
            } else if (typeof document.webkitHidden !== "undefined") { // Chrome up to v32, Android up to v4.4, Blackberry up to v10
                hidden = "webkitHidden"
                visibilityChange = "webkitvisibilitychange"
            }



            // If the page is hidden, pause the video
            // if the page is shown, play the video

            function handleVisibilityChange() {
                if (document[hidden]) {

                } else {
                    console.log(twilioRoom.state)
                    //location.reload()
                }
            }

            // Warn if the browser doesn't support addEventListener or the Page Visibility API
            if (typeof document.addEventListener === "undefined" || typeof document[hidden] === "undefined") {
                console.log("This demo requires a modern browser that supports the Page Visibility API.")
            } else {
                // Handle page visibility change
                document.addEventListener(visibilityChange, handleVisibilityChange, false)

                // When the video pauses and plays, change the title.

            }

            ClientRaiseHand_Socket_Listen_Function(call, others)

            if (call.user_type == UserTypes.CLIENT) {
                let activeParticipant = getActiveParticipant(userObj1.id)
                studentEnteringRoom(twilioRoom.localParticipant, call, others, activeParticipant, userObj1)

            } else if (call.user_type == UserTypes.PROVIDER) {
                document.getElementById('time-left-wrapper').style.display = 'flex'
                teacherEnteringRoom(twilioRoom.localParticipant)
            }

            if (!pointerForRecconection) {
                CallActionRequest_Socket_Listen_Function(call, userObj1)

            }

            checkPermissionsAndPublishTracks()

            checkForMutedUsers(data)


            document.getElementsByClassName('heading-title-wrap-german')[0].classList.remove('dn')
            document.getElementsByClassName('top-header-manage')[0].classList.remove('dn')

            //when user clicks on the red button for hang up we calling function for getting cancelation reason for type of user who clicked red button
            getCancelationReasonsFunction(call.booking_id)

            // first time progress timer
            drawProgress(parseInt(data.total_duration) - parseInt(data.duration), parseInt(data.total_duration))

            videoCta.classList.remove('dn')

            //changeOrderOfCams is static function witch is just swaping cam orders on users click
            changeOrderOfCams()

            setTimeout(function () {
                closePopup('loadingPopup')

            }, 2000)

            if (isAudio) {
                if (document.getElementById("video-mute-unmute")) {
                    document.getElementById('video-mute-unmute').parentElement.remove()
                }


            }

            hideLoading()
        },
        function (error) {
            // in case any error on joining
            console.log(error, '_________338888________')
            console.error(`Unable to connect to Room: ${error.message}`);
            document.getElementById('errorMsgtitle').textContent = userObj1.name
            document.getElementById('errorMsgText').textContent = error.message
            document.getElementById('errorMsgAdvice').textContent = getPoTranslate('REFRESH_PAGE_OR_CONTACT')
            openPopup('errorPopup')
            hideLoading()
        }
    )
}

function getProfileImageOfParticipant(active_users, id) {
    for (let i = 0; i < active_users.length; i++) {
        if (active_users[i].user_id === parseInt(id)) {
            return active_users[i].user_image
        }
    }
}

/**
 * Deals with calling the function if teacher or student has joined room
 * @param participant - participant that joined the room
 */
function participantConnected(participant) {

    let notificationStringEnter = getPoTranslate('NOTIFICATION_ENTER', {
        username: getUsernameOfParticipant(others, participant.identity)
    })

    fetch(socketServerUrl + '/api/room-status', {
        method: "POST",
        body: JSON.stringify({
            socket_room_id: call.socket_room_id
        }),
        headers: {
            "Content-type": "application/json; charset=UTF-8",
            "Authorization": document.querySelector("meta[name='access_token']").getAttribute("content"),
            "Accept": "application/json",
        }
    }).then(response => response.json())
        .then(response => {

            let name_of_users = getUsernameOfParticipant(others, participant.identity)

            let user_picture = getProfileImageOfParticipant(others, participant.identity)

            Toastify({
                text: '<div class="fr"><h5 class="fl cw p0m0 w-100">' + name_of_users + '</h5><p class="fl cw p0m0">' + notificationStringEnter + '</p></div>',
                className: "notification",
                gravity: "bottom",
                position: "left",
                close: true,
                duration: 3000,
                stopOnFocus: true,
                avatar: user_picture,
                escapeMarkup: false
            }).showToast()


            if (participant.identity == call.provider_id) {
                console.log('ovo se desavfa');
                teacherEnteringRoom(participant)
                optionButton2()

            } else {

                let activeParticipant = getActiveParticipant(participant.identity)
                //ovo je za druge studente ne za studenta koji je aktivan user
                studentEnteringRoom(participant, call, others, activeParticipant, userObj1)
                optionButton2()

            }

            //this function is checking audio/video mute state on room entering

            checkForMutedUsers(response.data)

            //this block is removing "Wateing for other strudens" label
            if (document.getElementsByClassName('turnOnVideo').length > 1) {
                if (document.getElementById('displayMiddleFullScreen')) {
                    document.getElementById('displayMiddleFullScreen').remove()
                }
            }

            //counting number of participants for participants list
            if (document.getElementById('actualNumberOfParticipants')) {
                document.getElementById('actualNumberOfParticipants').innerText = document.getElementsByClassName('turnOnVideo').length
            }

            if (document.getElementById('numberOfParticipants')) {
                document.getElementById('numberOfParticipants').textContent = others.length
            }




        }).catch(function (error) {
            closePopup('loadingPopup')
            console.log('442');
            document.getElementById('errorMsgtitle').textContent = userObj1.name
            document.getElementById('errorMsgText').textContent = error.message
            document.getElementById('errorMsgAdvice').textContent = 'Please refresh the page or contact our customer support'
            openPopup('errorPopup')
        })



}

/**
 * Function to remove participant related divs from the room on disconnection
 * @param participant - the participant who disconnected from call
 */
function participantDisconnected(participant) {

    studentExitingRoom(participant.identity, call, others)




    if (document.getElementById('participant-list-' + participant.identity)) {
        document.getElementById('participant-list-' + participant.identity).remove();
        setTimeout(function () {
            if (document.getElementById('actualNumberOfParticipants')) {

                document.getElementById('actualNumberOfParticipants').innerText = document.getElementsByClassName('turnOnVideo').length
            }
        }, 110)

    }



    if (document.getElementById('numberOfParticipants')) {
        document.getElementById('numberOfParticipants').textContent = others.length
    }


}

/**
 * This function return string value of username
 * @param active_users - array of object of active users
 * @param id - id of of user
 */

function getUsernameOfParticipant(active_users, id) {
    for (let i = 0; i < active_users.length; i++) {
        if (active_users[i].user_id === parseInt(id)) {
            return active_users[i].name_of_user
        }
    }
}

function getActiveParticipant(id) {
    for (let i = 0; i < dataObj.active_users.length; i++) {
        if (dataObj.active_users[i].user_id == id) {
            return dataObj.active_users[i]
        }

    }
}


function addParticipantToParticipantsList(participant, nameOfParticipant, active_users, pointerForTeacher) {



    // deals with showing participant in the bottom drop up
    const chattingBoxInner = document.createElement('div')
    const chattingInner = document.createElement('div')
    const innerBoxTiming = document.createElement('div')
    const participantImage = document.createElement('div')
    const participantName = document.createElement('p')

    chattingBoxInner.className = 'd-flex chating-box-inner'
    chattingBoxInner.id = 'participant-list-' + participant.identity
    chattingBoxInner.dataset.id = participant.identity
    chattingInner.className = 'd-flex chating-inner'
    innerBoxTiming.className = 'inner-box-timing'

    // image replacement required here
    participantImage.innerHTML = '<img src="' + getProfileImageOfParticipant(active_users, participant.identity) + '" style="border-radius: 50%;height: 32px;" />'

    // name replacement required here
    participantName.textContent = pointerForTeacher === 2 ? nameOfParticipant.textContent : nameOfParticipant

    participantImage.style.textAlign = 'center'

    innerBoxTiming.appendChild(participantImage)
    chattingInner.appendChild(innerBoxTiming)
    chattingInner.appendChild(participantName)
    chattingBoxInner.appendChild(chattingInner)



    const timingBoxRight = document.createElement('div')
    timingBoxRight.id = 'timingBoxRight' + participant.identity
    timingBoxRight.className = 'timing-box-right d-flex'

    const timezoneInner = document.createElement('div')
    timezoneInner.className = 'timezone-inner'
    const level = document.createElement('p')
    level.id = 'participant-network-' + participant.identity

    level.innerHTML = participant.networkQualityLevel
    timezoneInner.appendChild(level)

    timingBoxRight.appendChild(timezoneInner)


    chattingBoxInner.appendChild(timingBoxRight)

    if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.GROUP && pointerForTeacher !== 2) {
        let optionButton = document.createElement('div')
        optionButton.className = 'optionButton oButtonVideoCall'
        optionButton.dataset.id = participant.identity
        optionButton.setAttribute('data-opened', '0')
        optionButton.innerHTML = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.1" x="31.5" y="0.5" width="31" height="31" rx="3.5" transform="rotate(90 31.5 0.5)" stroke=""></rect><circle cx="16" cy="16" r="2" transform="rotate(90 16 16)" fill="#172B4D"></circle><circle cx="16" cy="10" r="2" transform="rotate(90 16 10)" fill="#172B4D"></circle><circle cx="16" cy="22" r="2" transform="rotate(90 16 22)" fill="#172B4D"></circle></svg>'

        optionButton.addEventListener('click', window.clickOnOptionButton)

        chattingBoxInner.appendChild(optionButton)
    }

    if (pointerForTeacher === 2) {
        chattingBoxInner.style.borderBottom = '1px solid rgba(6,4,3,.6)'
        chattingBoxInner.style.paddingBottom = '1rem'

        document.getElementById('participants-box').prepend(chattingBoxInner)
    } else {
        document.getElementById('participants-box').appendChild(chattingBoxInner)
    }

}

/**
 * deals with teacher entering room - shows it to left big div
 * @param participant - participant object
 */

function teacherEnteringRoom(participant) {

    // holder div for teacher
    let activeParticipant = getActiveParticipant(participant.identity)
    let teacherBox
    if (document.getElementsByClassName("videoBoxProfesor")[0]) {
        teacherBox = document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("turnOnVideo")[0]
        teacherBox.innerHTML = ""
    }

    const videoBox = document.createElement('div')
    videoBox.className = 'videoBoxTeacher'

    const audioBox = document.createElement('div')
    if (document.getElementsByClassName("videoBoxProfesor")[0]) {
        document.getElementsByClassName("videoBoxProfesor")[0].dataset.userId = parseInt(participant.identity)
    }


    let turnOfVideo = document.createElement('div')
    turnOfVideo.className = 'turnOfVideo'

    let pictureAndNamecontainer = document.createElement('div')
    pictureAndNamecontainer.style.position = "relative"


    pictureAndNamecontainer.innerHTML = '<svg viewBox="0 0 471 470" fill="none" xmlns="http://www.w3.org/2000/svg" class="proffesorNoCamSvg"> <g opacity="0.03" filter="url(#filter0_d_1547_11010)"> <path d="M235.203 418C345.108 418 434.203 328.905 434.203 219C434.203 109.095 345.108 20 235.203 20C125.299 20 36.2031 109.095 36.2031 219C36.2031 328.905 125.299 418 235.203 418Z" fill="white"></path> </g> <path opacity="0.05" d="M235.996 375.357C322.35 375.357 392.354 305.353 392.354 219C392.354 132.646 322.35 62.6426 235.996 62.6426C149.643 62.6426 79.6392 132.646 79.6392 219C79.6392 305.353 149.643 375.357 235.996 375.357Z" fill="white"></path> <path opacity="0.07" d="M235.997 332.715C298.799 332.715 349.711 281.803 349.711 219C349.711 156.198 298.799 105.286 235.997 105.286C173.194 105.286 122.282 156.198 122.282 219C122.282 281.803 173.194 332.715 235.997 332.715Z" fill="white"></path> <g filter="url(#filter1_d_1547_11010)"> <path d="M310.621 219C310.621 177.786 277.21 144.375 235.996 144.375C194.782 144.375 161.371 177.786 161.371 219C161.371 260.214 194.782 293.625 235.996 293.625C277.21 293.625 310.621 260.214 310.621 219Z" fill="white"></path> </g> <defs> <filter id="filter0_d_1547_11010" x="0.203125" y="0" width="470" height="470" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix> <feOffset dy="16"></feOffset> <feGaussianBlur stdDeviation="18"></feGaussianBlur> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.08 0"></feColorMatrix> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1547_11010"></feBlend> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1547_11010" result="shape"></feBlend> </filter> <filter id="filter1_d_1547_11010" x="131.371" y="114.375" width="209.25" height="209.25" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix> <feOffset></feOffset> <feGaussianBlur stdDeviation="15"></feGaussianBlur> <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.7 0"></feColorMatrix> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1547_11010"></feBlend> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1547_11010" result="shape"></feBlend> </filter> </defs></svg>'
    /* class="breathing-button" */
    let professorImage = document.createElement('img')
    professorImage.style.zIndex = '99'
    professorImage.style.position = 'relative'
    professorImage.style.top = '-9px'

    professorImage.src = activeParticipant.user_image

    pictureAndNamecontainer.append(professorImage)


    let professorName = document.createElement('span')
    professorName.className = 'professorNoCamText'

    professorName.textContent = activeParticipant.name_of_user

    pictureAndNamecontainer.prepend(professorName)

    turnOfVideo.append(pictureAndNamecontainer)




    if (!isAudio && call.is_anonym !== 1) {
        let svgCrossCameraIcon2 = document.createElement('div')
        svgCrossCameraIcon2.className = 'svgCrossCameraIcon svgCrossCameraIcon2'
        svgCrossCameraIcon2.innerHTML = '<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.77762 0.305115L0.304688 1.77825L3.73428 5.20833H3.12421C1.97378 5.20833 1.04117 6.14107 1.04117 7.29167V17.7083C1.04117 18.8589 1.97378 19.7917 3.12421 19.7917H15.6225C16.3537 19.7917 16.997 19.4148 17.3687 18.8446L23.2181 24.6949L24.6911 23.2218L1.77762 0.305115ZM15.6225 17.0982L5.81733 7.29167H3.12421V17.7083H15.6225V17.0982ZM17.7054 8.73121L23.9545 5.60621V19.1355L21.8715 17.0522V8.97712L17.7054 11.0605V13.5425L15.6224 11.4592V7.29167H11.4555L9.37244 5.20833H15.6224C16.7728 5.20833 17.7054 6.14107 17.7054 7.29167V8.73121Z" fill="white"></path></svg>'

        turnOfVideo.append(svgCrossCameraIcon2)
    }



    document.getElementsByClassName("videoBoxProfesor")[0].append(turnOfVideo)

    if (isAudio && call.is_anonym !== 1) {
        turnOfVideo.style.cssText = 'opacity: 1;transform: scale(1);position: absolute;top: calc((100% - 80px) / 2);left: calc((100% - 80px) / 2);width: 80px;height: 80px;margin: 0;'


    } else {
        turnOfVideo.style.cssText = 'opacity: 1;transform: scale(0);position: absolute;top: calc((100% - 80px) / 2);left: calc((100% - 80px) / 2);width: 80px;height: 80px;margin: 0;'

    }


    professor = parseInt(participant.identity)



    //fun starts


    //ovde participant vezuje svoje trake na stream da bi drugi mogli da ga vide
    participant.tracks.forEach(function (publication) {

        if (publication.isSubscribed) {
            if (publication.track.kind == "video") {

                trackSubscribed(videoBox, publication.track, true);
            } else if (publication.track.kind == "audio") {

                trackSubscribed(audioBox, publication.track);
            }

        }
    })


    //event za kad participant subscribe track - to vide drugi ne vidi on
    participant.on("trackSubscribed", function (track) {
        if (track.kind == "video") {

            if (track.name === 'screnShare') {

                trackSubscribed(videoBox, track, 'screnShare')
            } else {
                trackSubscribed(videoBox, track, true)
            }

        } else if (track.kind == "audio") {
            trackSubscribed(audioBox, track, true)
        }

    })

    participant.on("trackUnpublished", function (track) {

        if (track.kind === "video") {
            if (track.trackName === 'screnShare') {
                let videos = document.getElementsByClassName('videoBoxTeacher')[0].getElementsByTagName('video')
                for (let i = videos.length - 1; i >= 0; i--) {

                    if (videos[i].classList.contains('screnShare')) {
                        if (videos[i].parentElement.classList.contains('teacherScreenShare')) {
                            videos[i].parentElement.classList.remove('teacherScreenShare')

                            videos[i].remove()
                        }

                    }

                }
            }
            //videoBox.innerHTML = getPoTranslate('VIDEO_DISABLED')
        } else if (track.kind === "audio") {


            //audioBox.innerHTML = getPoTranslate('AUDIO_MUTED')
        }

        if (track.kind == "video") {

            if (track.trackName === 'screnShare') {

                let videos = document.getElementById('privateTalkStudentHelder').getElementsByTagName('video')
                for (let i = videos.length - 1; i >= 0; i--) {



                    if (videos[i].classList.contains('screnShare')) {

                        videos[i].parentElement.classList.remove('screnShared')

                        videos[i].remove()
                    }

                }
            } else {
                turnOnVideo.style.cssText = 'display: none; opacity: 1; transform: scale(1);'
                turnOfVideo.style.cssText = 'display: flex; opacity: 1; transform: scale(1);'
            }

            //turnOnVideo.innerHTML = ""



            // hide video on div and display his picture div
            /* turnOnVideo.style.cssText = 'display: none; opacity: 1; transform: scale(1);'
            turnOfVideo.style.cssText = 'display: flex; opacity: 1; transform: scale(1);'
            turnOnVideo.innerHTML = "" */
        } else if (track.kind == "audio") {
            // remove the audio elements from div

        }

    })


    teacherBox.appendChild(audioBox)
    teacherBox.appendChild(videoBox)

    addParticipantToParticipantsList(participant, professorName, dataObj.active_users, 2)
}

/**
 * deals with student entering room - shows it to right corner
 * @param participant - participant object
 */

function studentEnteringRoom(participant, call, others, studentUsername, userObj) {

    const username = participant.identity
    let entering = username

    if (participant.identity == call.user_id) {
        entering = studentUsername.name_of_user
    } else {
        entering = others.filter(user => user.user_id == participant.identity)[0].name_of_user
    }

    let notificationStringEnter = getPoTranslate('NOTIFICATION_ENTER', {
        username: studentUsername.name_of_user
    })
    let videoBoxCreated
    let callType = call.call_type

    if (callType === 1) {

        //document.getElementsByClassName('videoBoxProfesorCont')[0].className = 'videoBoxProfesorCont'
        //document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-12')



        videoBoxCreated = createVideoBox(username, 'private', participant, entering, studentUsername)

        document.getElementById('privateTalkStudentHelder').insertBefore(videoBoxCreated, privateTalkStudentHelder.firstChild)

        showParticipant(videoBoxCreated)




    } else if (callType === 2) {

        document.getElementById('viewUsTab').style.left = '0'


        document.getElementsByClassName('chating-wrap-right')[0].style.cssText = 'opacity:1'
        /*    if (window.innerWidth < 768) {
               document.getElementsByClassName('video-cta')[0].style.bottom = '0px'
               //document.getElementsByClassName('videoBoxProfesor')[0].getElementsByClassName('innerVideoBox')[0].style.height = 'calc(100vh - 77px)'
           } */


        videoBoxCreated = createVideoBox(username, 'group', participant, entering, studentUsername)

        document.getElementsByClassName('videoBoxProfesorCont')[0].className = 'videoBoxProfesorCont'
        document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-8')

        let noPinnedStudentsFrame = document.getElementsByClassName('noPinnedStudentsFrame')[0].getElementsByClassName('videoBox')

        let calculateHeightHelper = document.getElementById('rowOne').getElementsByClassName('videoBox')

        if (noPinnedStudentsFrame.length < 2) {

            if (username == call.user_id) {
                document.getElementById('rowOne').insertBefore(videoBoxCreated, document.getElementById('rowOne').firstChild)

            } else {
                document.getElementById('rowOne').insertBefore(videoBoxCreated, document.getElementById('rowOne').lastChild)
            }
            calculateHeightOfVideoBoxes(noPinnedStudentsFrame, 2)

        } else if (noPinnedStudentsFrame.length > 1 && noPinnedStudentsFrame.length < 3) {
            if (username == call.user_id) {
                document.getElementById('rowOne').insertBefore(videoBoxCreated, document.getElementById('rowOne').firstChild)
            } else {
                document.getElementById('rowOne').insertBefore(videoBoxCreated, document.getElementById('rowOne').lastChild)
            }



            calculateHeightOfVideoBoxes(noPinnedStudentsFrame, 3)


        } else if (noPinnedStudentsFrame.length > 2 && noPinnedStudentsFrame.length < 7) {

            document.getElementsByClassName('large6')[0].classList.remove('large-6')
            document.getElementsByClassName('large6')[0].classList.remove('large-6')

            document.getElementById('rowOne').className = 'large-6'
            document.getElementById('rowTwo').style.display = 'block'
            setTimeout(function () {
                document.getElementById('rowTwo').style.opacity = '1'

                document.getElementById('rowTwo').insertBefore(videoBoxCreated, document.getElementById('rowTwo').lastChild)
            })

            calculateHeightOfVideoBoxes(noPinnedStudentsFrame, 4)
        } else if (noPinnedStudentsFrame.length > 6) {

            document.getElementsByClassName('large6')[0].classList.add('large-6')
            document.getElementsByClassName('large6')[1].classList.add('large-6')



            if (noPinnedStudentsFrame.length > 10) {
                document.getElementById('rowTwoA').insertBefore(videoBoxCreated, document.getElementById('rowTwoA').lastChild)
                //videoBoxCreated.style.height = 'calc((100vh - 80px) / 8)'
            } else {
                document.getElementById('rowOneA').insertBefore(videoBoxCreated, document.getElementById('rowOneA').lastChild)
                //videoBoxCreated.style.height = 'calc((100vh - 80px) / 8)'
            }

            calculateHeightOfVideoBoxes(noPinnedStudentsFrame, 8)
        }

        let name_of_user

        if (call.user_id != username) {
            name_of_user = others.filter(user => user.user_id == username)[0].name_of_user
        } else {
            name_of_user = 'You'
        }

        let user_picture = others.filter(user => user.user_id == username)[0].user_image

        Toastify({
            text: '<div class="fr"><h5 class="fl cw p0m0 w-100">' + entering + '</h5><p class="fl cw p0m0">' + notificationStringEnter + '</p></div>',
            className: "notification",
            gravity: "bottom",
            position: "left",
            close: true,
            duration: 3000,
            stopOnFocus: true,
            avatar: user_picture,
            escapeMarkup: false

        }).showToast();

        showParticipant(videoBoxCreated)

        addParticipantToParticipantsList(participant, entering, dataObj.active_users, 1)

        let timingBoxRight = document.getElementById('timingBoxRight' + participant.identity)

        // on participants network quality changed
        participant.on("networkQualityLevelChanged", function () {
            // update the network quality text here
            //ovde treba updatovati tabelu za promenu networka
            const network = document.getElementById('participant-network-' + participant.identity)
            network.innerHTML = NetworkQuality[participant.networkQualityLevel]
        })

    }


}

/**
 * deals with students video frame elements. Function firtst create HTML for new user who is joing room. Than function append all JS events on video box options.
 * @param participant - participant object
 */


/**
 * student exiting room function.
 * @param participant - participant object
 * @param call - participant object
 * @param others - participant object
 */

function studentExitingRoom(username, call, others) {

    let notificationStringLeft = getPoTranslate('NOTIFICATION_LEFT', {
        username: userObj1.name
    })
    let videoBoxes = document.getElementsByClassName('videoBox')

    if (call.call_type === CallTypes.ONE_TO_ONE) {

    } else {
        for (let i = 0; i < videoBoxes.length; i++) {
            if (videoBoxes[i].dataset.username === username) {
                videoBoxes[i].style.opacity = '0'
                videoBoxes[i].style.transform = 'scale(0)'
                setTimeout(function () {
                    videoBoxes[i].parentNode.removeChild(videoBoxes[i])
                    if (document.getElementsByClassName('noPinnedStudentsFrame')[0].getElementsByClassName('videoBox').length === 0) {
                        document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-8')
                        document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-12')

                    }
                }, 10)
                showHideStudents(call.call_type)
            }
        }
    }

    let name_of_user

    if (call.user_id != username) {
        name_of_user = others.filter(user => user.user_id == username)[0].name_of_user
    } else {
        name_of_user = 'You'
    }

    let user_picture = others.filter(user => user.user_id == username)[0].user_image

    Toastify({
        text: '<div class="fr"><h5 class="fl cw p0m0 w-100">' + name_of_user + '</h5><p class="fl cw p0m0">' + notificationStringLeft + '</p></div>',
        className: "notification",
        gravity: "bottom",
        position: "left",
        close: true,
        duration: 3000,
        stopOnFocus: true,
        avatar: user_picture,
        escapeMarkup: false
    }).showToast()

}


/**
 * deals with students video frame elements. Function firtst create HTML for new user who is joing room. Than function append all JS events on video box options.
 * @param participant - participant object
 */
function createVideoBox(username, pointer, participant, name, studentUsername) {
    let videoBox
    const audioBox = document.createElement('div')
    audioBox.id = 'audio-track-' + participant.identity

    if (pointer === 'private') {
        let elements = document.getElementsByClassName('videoBox');
        if (elements.length > 0) {
            videoBox = elements[0];
            videoBox.innerHTML = "";
        } else {
            videoBox = document.createElement('div')
        }
    } else {
        videoBox = document.createElement('div')
    }

    videoBox.className = 'videoBox'
    videoBox.setAttribute('data-username', username)
    videoBox.dataset.id = participant.identity
    videoBox.style.cssText = 'opacity:0; transition:0.2s; transform:scale(0);'

    let position_span = document.createElement('div')
    position_span.className = 'position-span'

    let optionButton = document.createElement('div')
    optionButton.className = 'optionButton oButtonVideoCall'
    optionButton.dataset.id = participant.identity
    optionButton.setAttribute('data-opened', '0')
    optionButton.innerHTML = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.1" x="31.5" y="0.5" width="31" height="31" rx="3.5" transform="rotate(90 31.5 0.5)" stroke=""></rect><circle cx="16" cy="16" r="2" transform="rotate(90 16 16)" fill="#172B4D"></circle><circle cx="16" cy="10" r="2" transform="rotate(90 16 10)" fill="#172B4D"></circle><circle cx="16" cy="22" r="2" transform="rotate(90 16 22)" fill="#172B4D"></circle></svg>'

    optionButton.addEventListener('click', window.clickOnOptionButton)

    let dropdown_menu_field = document.createElement('ul')
    dropdown_menu_field.className = 'dropdown-menu-field'
    dropdown_menu_field.dataset.id = participant.identity

    let muteCall = document.createElement('li')
    muteCall.innerHTML = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.66667 5.49181L0.754181 1.57933L1.57914 0.75437L13.2458 12.421L12.4208 13.246L9.86161 10.6868C9.21614 11.1885 8.43541 11.5245 7.58333 11.6307V12.2502H9.33333V13.4168H4.66667V12.2502H6.41667V11.6307C4.11465 11.3437 2.33333 9.37994 2.33333 7.00016V5.8335H3.5V7.00016C3.5 8.93316 5.067 10.5002 7 10.5002C7.75589 10.5002 8.45582 10.2605 9.02796 9.85311L8.1853 9.01044C7.83792 9.21571 7.43272 9.3335 7 9.3335C5.71134 9.3335 4.66667 8.28883 4.66667 7.00016V5.49181ZM7.30217 8.12732C7.20579 8.15309 7.1045 8.16683 7 8.16683C6.35567 8.16683 5.83333 7.64449 5.83333 7.00016V6.65848L7.30217 8.12732ZM8.16667 2.91683V5.70853L9.33333 6.8752V2.91683C9.33333 1.62817 8.28866 0.583496 7 0.583496C5.92743 0.583496 5.0239 1.30717 4.75102 2.29289L5.83333 3.3752V2.91683C5.83333 2.2725 6.35567 1.75016 7 1.75016C7.64433 1.75016 8.16667 2.2725 8.16667 2.91683ZM11.2924 8.83429L10.3779 7.9198C10.4575 7.62675 10.5 7.31841 10.5 7.00016V5.8335H11.6667V7.00016C11.6667 7.65129 11.5333 8.27128 11.2924 8.83429Z" fill="#172B4D"></path></svg></span> <span> Mute User</span>'
    muteCall.setAttribute('data-muted', '0')
    muteCall.className = 'optionButtonMuted'


    // deals with mute funcitonality directly inside videoBox, not in participatns list
    muteCall.addEventListener('click', function (e) {

        let audioHolder = document.getElementById('audio-track-' + participant.identity)
        let parent = e.target.parentElement
        //window.eTar

        if (call.call_type === 1) {
            window.eTar = document.getElementsByClassName('videoBox')[0]
        }
        if (window.eTar) {
            window.eTar.dataset.opened = '0'
            window.eTar.getElementsByClassName('position-span')[0].append(document.getElementsByClassName('oButtonVideoCall')[0])
        }
        if (muteCall.dataset.muted == '0') {

            findParticipantToMute(this.parentElement.dataset.id, 1, 1)

            muteCall.setAttribute('data-muted', '1')
            muteCall.innerHTML = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.66667 5.49181L0.754181 1.57933L1.57914 0.75437L13.2458 12.421L12.4208 13.246L9.86161 10.6868C9.21614 11.1885 8.43541 11.5245 7.58333 11.6307V12.2502H9.33333V13.4168H4.66667V12.2502H6.41667V11.6307C4.11465 11.3437 2.33333 9.37994 2.33333 7.00016V5.8335H3.5V7.00016C3.5 8.93316 5.067 10.5002 7 10.5002C7.75589 10.5002 8.45582 10.2605 9.02796 9.85311L8.1853 9.01044C7.83792 9.21571 7.43272 9.3335 7 9.3335C5.71134 9.3335 4.66667 8.28883 4.66667 7.00016V5.49181ZM7.30217 8.12732C7.20579 8.15309 7.1045 8.16683 7 8.16683C6.35567 8.16683 5.83333 7.64449 5.83333 7.00016V6.65848L7.30217 8.12732ZM8.16667 2.91683V5.70853L9.33333 6.8752V2.91683C9.33333 1.62817 8.28866 0.583496 7 0.583496C5.92743 0.583496 5.0239 1.30717 4.75102 2.29289L5.83333 3.3752V2.91683C5.83333 2.2725 6.35567 1.75016 7 1.75016C7.64433 1.75016 8.16667 2.2725 8.16667 2.91683ZM11.2924 8.83429L10.3779 7.9198C10.4575 7.62675 10.5 7.31841 10.5 7.00016V5.8335H11.6667V7.00016C11.6667 7.65129 11.5333 8.27128 11.2924 8.83429Z" fill="#172B4D"></path></svg> </span> <span> Unmute User</span>'
            /*           if (call.call_type === 1) {
                          document.getElementsByClassName('videoBox')[0].getElementsByTagName('audio')[0].style = 'opacity: 0; display: none; transform: scale(0);'
                      } else {
                          audioHolder.style = 'opacity: 0; display: none; transform: scale(0);'
                      } */

            // if provider send event to mute this client for all CallTypes.ONE_TO_ONE
            if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.GROUP) {
                window.isProffessor = 1
                //here we send SUPPLIER_SET_CLIENT_AUDIO_OFF event to backend
                SUPPLIER_SET_CLIENT_AUDIO_OFF_Send_Event_Function(call, participant.identity)
            } else if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.ONE_TO_ONE) {
                window.isProffessor = 1

                SUPPLIER_SET_CLIENT_AUDIO_OFF_Send_Event_Function(call, parent.dataset.id)
                //document.getElementById('audio-track-' + participant.identity).getElementsByTagName('audio')[0].pause()

            } else {
                let videoBoxOptionButtonSpans = dropDownMenu.getElementsByClassName('optionButtonMuted')[0].getElementsByTagName('span')

                videoBoxOptionButtonSpans[1].textContent = 'Muted by student'
                // if  client mute this client for me
                window.isProffessor = 0
                //document.getElementById('audio-track-' + participant.identity).getElementsByTagName('audio')[0].pause()
            }
        } else {

            muteCall.setAttribute('data-muted', '0')

            muteCall.innerHTML = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.66667 5.49181L0.754181 1.57933L1.57914 0.75437L13.2458 12.421L12.4208 13.246L9.86161 10.6868C9.21614 11.1885 8.43541 11.5245 7.58333 11.6307V12.2502H9.33333V13.4168H4.66667V12.2502H6.41667V11.6307C4.11465 11.3437 2.33333 9.37994 2.33333 7.00016V5.8335H3.5V7.00016C3.5 8.93316 5.067 10.5002 7 10.5002C7.75589 10.5002 8.45582 10.2605 9.02796 9.85311L8.1853 9.01044C7.83792 9.21571 7.43272 9.3335 7 9.3335C5.71134 9.3335 4.66667 8.28883 4.66667 7.00016V5.49181ZM7.30217 8.12732C7.20579 8.15309 7.1045 8.16683 7 8.16683C6.35567 8.16683 5.83333 7.64449 5.83333 7.00016V6.65848L7.30217 8.12732ZM8.16667 2.91683V5.70853L9.33333 6.8752V2.91683C9.33333 1.62817 8.28866 0.583496 7 0.583496C5.92743 0.583496 5.0239 1.30717 4.75102 2.29289L5.83333 3.3752V2.91683C5.83333 2.2725 6.35567 1.75016 7 1.75016C7.64433 1.75016 8.16667 2.2725 8.16667 2.91683ZM11.2924 8.83429L10.3779 7.9198C10.4575 7.62675 10.5 7.31841 10.5 7.00016V5.8335H11.6667V7.00016C11.6667 7.65129 11.5333 8.27128 11.2924 8.83429Z" fill="#172B4D"></path></svg></span> <span> Mute User</span>'
            audioHolder.style = 'opacity: 1; display: block; transform: scale(1);'
            // if  provider send event to unmute the client for all
            if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.GROUP) {
                //here we send SUPPLIER_SET_CLIENT_TO_AUDIO_ON event to backend
                SUPPLIER_SET_CLIENT_TO_AUDIO_ON_Send_Event_Function(call, participant.identity)
            } else if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.ONE_TO_ONE) {
                document.getElementById('audio-track-' + participant.identity).getElementsByTagName('audio')[0].play()
                SUPPLIER_SET_CLIENT_TO_AUDIO_ON_Send_Event_Function(call, parent.dataset.id)
            } else {
                // if  client unmute the client for me
                document.getElementById('audio-track-' + participant.identity).getElementsByTagName('audio')[0].play()
            }
        }
    })

    let turnOffVideo = document.createElement('li')
    turnOffVideo.innerHTML = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.995811 0.170898L0.170853 0.995856L2.09169 2.91669H1.75C1.10567 2.91669 0.583338 3.43903 0.583338 4.08336V9.91669C0.583338 10.561 1.10567 11.0834 1.75 11.0834H8.75C9.15958 11.0834 9.51986 10.8723 9.72802 10.553L13.0042 13.8292L13.8291 13.0042L0.995811 0.170898ZM8.75 9.57501L3.25835 4.08336H1.75V9.91669H8.75V9.57501ZM9.91667 4.8895L13.4167 3.1395V10.7159L12.25 9.54925V5.02721L9.91667 6.19388V7.58382L8.75001 6.41715V4.08336H6.41622L5.24955 2.91669H8.75001C9.39434 2.91669 9.91667 3.43903 9.91667 4.08336V4.8895Z" fill="#172B4D"></path></svg></span> <span>Turn off Video</span>'
    turnOffVideo.setAttribute('data-video', '1')
    turnOffVideo.className = 'optionButtonVideoMuted'

    turnOffVideo.addEventListener('click', function () {
        if (turnOffVideo.dataset.video === "1") {
            findParticipantToMute(this.parentElement.dataset.id, 1, 0)
            if (call.call_type === 1) {
                window.eTar = document.getElementsByClassName('videoBox')[0]
            }
            if (window.eTar) {

                window.eTar.dataset.opened = '0'
                window.eTar.getElementsByClassName('position-span')[0].append(document.getElementsByClassName('oButtonVideoCall')[0])
            }
            //window.eTar.insertBefore(document.body.getElementsByClassName('dropdown-menu-field')[0], window.eTar.lastChild)
            turnOffVideo.getElementsByTagName('span')[1].textContent = getPoTranslate('TURN_ON_VIDEO')
            turnOnVideo.style.opacity = '0'

            setTimeout(function () {
                if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.GROUP) {
                    // if  provider send event to disable video of this client for all
                    SUPPLIER_SET_CLIENT_VIDEO_OFF_Send_Event_Function(call, participant.identity)
                }
                // else just hide his video for me
                turnOnVideo.style.display = 'none'
                turnOfVideo.style.display = 'flex'
                setTimeout(function () {
                    turnOnVideo.style.transform = 'scale(0)'
                    turnOfVideo.style.opacity = '1'
                    turnOfVideo.style.transform = 'scale(1)'
                }, 310)
            }, 310)

            turnOffVideo.dataset.video = 0
        } else {

            turnOffVideo.getElementsByTagName('span')[1].textContent = getPoTranslate('TURN_OFF_VIDEO')

            turnOfVideo.style.opacity = '0'
            if (window.eTar) {
                window.eTar.dataset.opened = '0'
                window.eTar.getElementsByClassName('position-span')[0].append(document.getElementsByClassName('oButtonVideoCall')[0])
            }




            setTimeout(function () {
                // if am provider send event to enable his video for all
                if (call.user_type == UserTypes.PROVIDER) {
                    SUPPLIER_SET_CLIENT_VIDEO_ON_Send_Event_Function(call, participant.identity)
                }

                // else just show his video to me again
                turnOfVideo.style.display = 'none'
                turnOnVideo.style.display = 'flex'
                setTimeout(function () {
                    turnOfVideo.style.transform = 'scale(0)'
                    turnOnVideo.style.opacity = '1'
                    turnOnVideo.style.transform = 'scale(1)'
                }, 310)
            }, 310)

            turnOffVideo.dataset.video = 1
        }
    })

    if (pointer === "private") {

    } else if (pointer === "group") {
        let pinStudent = document.createElement('li')
        pinStudent.innerHTML = ' <span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.00883 0.485054C4.19755 0.2964 4.42905 0.156121 4.68363 0.0761506C4.93821 -0.00381949 5.20834 -0.0211147 5.47104 0.0257364C5.73374 0.0725874 5.98124 0.182198 6.19248 0.345245C6.40372 0.508291 6.57245 0.719949 6.68432 0.962212L7.26467 2.21854C7.44968 2.61975 7.72341 2.97369 8.06519 3.25364C8.40698 3.5336 8.8079 3.73226 9.23768 3.83463L11.561 4.38752C12.822 4.68764 13.2651 6.2545 12.3487 7.17094L10.2611 9.25756L13.783 12.7794C13.8508 12.845 13.9048 12.9234 13.942 13.01C13.9792 13.0966 13.9987 13.1898 13.9995 13.2841C14.0003 13.3784 13.9823 13.4719 13.9465 13.5591C13.9108 13.6464 13.858 13.7256 13.7913 13.7923C13.7246 13.8589 13.6453 13.9116 13.558 13.9473C13.4707 13.9829 13.3772 14.0008 13.283 14C13.1887 13.9991 13.0955 13.9795 13.0089 13.9422C12.9223 13.905 12.844 13.8508 12.7785 13.783L9.25756 10.2611L7.17094 12.3487C6.2545 13.2651 4.68764 12.822 4.38752 11.561L3.83463 9.23768C3.73226 8.8079 3.5336 8.40698 3.25364 8.06519C2.97369 7.72341 2.61975 7.44968 2.21854 7.26467L0.962212 6.68432C0.719948 6.57245 0.508291 6.40372 0.345245 6.19248C0.182198 5.98124 0.0725874 5.73374 0.0257364 5.47104C-0.0211147 5.20834 -0.00381949 4.93821 0.0761506 4.68363C0.156121 4.42905 0.2964 4.19755 0.485054 4.00883L4.00883 0.485054ZM5.39486 1.55677C5.37889 1.52211 5.35478 1.49182 5.32458 1.4685C5.29438 1.44517 5.25899 1.42949 5.22142 1.42279C5.18385 1.4161 5.14522 1.41859 5.10882 1.43004C5.07242 1.4415 5.03933 1.46159 5.01237 1.4886L1.4886 5.01237C1.46159 5.03933 1.4415 5.07242 1.43004 5.10882C1.41859 5.14522 1.4161 5.18385 1.42279 5.22142C1.42949 5.25899 1.44517 5.29438 1.4685 5.32458C1.49182 5.35478 1.52211 5.37889 1.55677 5.39486L2.81404 5.97521C3.41 6.25043 3.93573 6.65731 4.35162 7.16519C4.76751 7.67308 5.06271 8.26873 5.21498 8.90727L5.76787 11.2306C5.77748 11.2716 5.79788 11.3094 5.82697 11.3399C5.85605 11.3704 5.89277 11.3926 5.93331 11.4042C5.97385 11.4158 6.01675 11.4163 6.05757 11.4058C6.09839 11.3952 6.13566 11.374 6.1655 11.3442L11.3442 6.1655C11.374 6.13566 11.3952 6.09839 11.4058 6.05757C11.4163 6.01675 11.4158 5.97385 11.4042 5.93331C11.3926 5.89277 11.3704 5.85605 11.3399 5.82697C11.3094 5.79788 11.2716 5.77748 11.2306 5.76787L8.90727 5.21498C8.26844 5.0628 7.67251 4.76754 7.16444 4.35147C6.65636 3.9354 6.2494 3.40938 5.97426 2.81309L5.39486 1.55677Z" fill="#172B4D"></path></svg>  </span><span> Pin User </span>'
        pinStudent.setAttribute('data-pinned', '0')
        pinStudent.dataset.id = participant.identity
        pinStudent.addEventListener('click', pinStudentEvent2)
        dropdown_menu_field.insertBefore(pinStudent, dropdown_menu_field.firstChild)
    }

    // only add kick if its a group call and  a provider
    if (call.user_type == UserTypes.PROVIDER && call.call_type == CallTypes.GROUP) {


        let kickUser = document.createElement('li')
        kickUser.innerHTML = ' <span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.00883 0.485054C4.19755 0.2964 4.42905 0.156121 4.68363 0.0761506C4.93821 -0.00381949 5.20834 -0.0211147 5.47104 0.0257364C5.73374 0.0725874 5.98124 0.182198 6.19248 0.345245C6.40372 0.508291 6.57245 0.719949 6.68432 0.962212L7.26467 2.21854C7.44968 2.61975 7.72341 2.97369 8.06519 3.25364C8.40698 3.5336 8.8079 3.73226 9.23768 3.83463L11.561 4.38752C12.822 4.68764 13.2651 6.2545 12.3487 7.17094L10.2611 9.25756L13.783 12.7794C13.8508 12.845 13.9048 12.9234 13.942 13.01C13.9792 13.0966 13.9987 13.1898 13.9995 13.2841C14.0003 13.3784 13.9823 13.4719 13.9465 13.5591C13.9108 13.6464 13.858 13.7256 13.7913 13.7923C13.7246 13.8589 13.6453 13.9116 13.558 13.9473C13.4707 13.9829 13.3772 14.0008 13.283 14C13.1887 13.9991 13.0955 13.9795 13.0089 13.9422C12.9223 13.905 12.844 13.8508 12.7785 13.783L9.25756 10.2611L7.17094 12.3487C6.2545 13.2651 4.68764 12.822 4.38752 11.561L3.83463 9.23768C3.73226 8.8079 3.5336 8.40698 3.25364 8.06519C2.97369 7.72341 2.61975 7.44968 2.21854 7.26467L0.962212 6.68432C0.719948 6.57245 0.508291 6.40372 0.345245 6.19248C0.182198 5.98124 0.0725874 5.73374 0.0257364 5.47104C-0.0211147 5.20834 -0.00381949 4.93821 0.0761506 4.68363C0.156121 4.42905 0.2964 4.19755 0.485054 4.00883L4.00883 0.485054ZM5.39486 1.55677C5.37889 1.52211 5.35478 1.49182 5.32458 1.4685C5.29438 1.44517 5.25899 1.42949 5.22142 1.42279C5.18385 1.4161 5.14522 1.41859 5.10882 1.43004C5.07242 1.4415 5.03933 1.46159 5.01237 1.4886L1.4886 5.01237C1.46159 5.03933 1.4415 5.07242 1.43004 5.10882C1.41859 5.14522 1.4161 5.18385 1.42279 5.22142C1.42949 5.25899 1.44517 5.29438 1.4685 5.32458C1.49182 5.35478 1.52211 5.37889 1.55677 5.39486L2.81404 5.97521C3.41 6.25043 3.93573 6.65731 4.35162 7.16519C4.76751 7.67308 5.06271 8.26873 5.21498 8.90727L5.76787 11.2306C5.77748 11.2716 5.79788 11.3094 5.82697 11.3399C5.85605 11.3704 5.89277 11.3926 5.93331 11.4042C5.97385 11.4158 6.01675 11.4163 6.05757 11.4058C6.09839 11.3952 6.13566 11.374 6.1655 11.3442L11.3442 6.1655C11.374 6.13566 11.3952 6.09839 11.4058 6.05757C11.4163 6.01675 11.4158 5.97385 11.4042 5.93331C11.3926 5.89277 11.3704 5.85605 11.3399 5.82697C11.3094 5.79788 11.2716 5.77748 11.2306 5.76787L8.90727 5.21498C8.26844 5.0628 7.67251 4.76754 7.16444 4.35147C6.65636 3.9354 6.2494 3.40938 5.97426 2.81309L5.39486 1.55677Z" fill="#172B4D"></path> </svg></span> <span> Kick User </span>'
        kickUser.addEventListener('click', function () {

            KICK_PARTICIPANT_Send_Event_Function(call, participant.identity)
            if (window.eTar) {
                window.eTar.dataset.opened = '0'
                window.eTar.insertBefore(document.body.getElementsByClassName('dropdown-menu-field')[0], window.eTar.lastChild)
            }

        })
        dropdown_menu_field.insertBefore(kickUser, dropdown_menu_field.firstChild)
    }

    let isClientAnnon
    for (let i = 0; i < dataObj.active_users.length; i++) {
        if (dataObj.active_users[i].user_id !== userObj1.id) {
            isClientAnnon = dataObj.active_users[i].is_anonym
        }

    }

    if (!isAudio) {
        if (isClientAnnon !== 1) {
            dropdown_menu_field.insertBefore(turnOffVideo, dropdown_menu_field.firstChild)
        }

    }

    dropdown_menu_field.insertBefore(muteCall, dropdown_menu_field.firstChild)

    optionButton.insertBefore(dropdown_menu_field, optionButton.lastChild)

    position_span.insertBefore(optionButton, position_span.firstChild)


    //adding turned of video box

    let turnOfVideo = document.createElement('div')
    turnOfVideo.className = 'turnOfVideo'


    let isItUserAnonym

    if (call.provider_id == userObj1.id) {
        for (let i = 0; i < dataObj.active_users.length; i++) {
            if (dataObj.active_users[i].user_id !== userObj1.id) {
                isItUserAnonym = dataObj.active_users[i].is_anonym
            }

        }
    } else {
        isItUserAnonym = call.is_anonym
    }



    if (isAudio) {

        turnOfVideo.style.cssText = 'opacity: 1;transform: scale(1);display: flex;padding: 1rem;'
        //turnOfVideo.getElementsByClassName('svgCrossCameraIcon')[0].remove()

    } else {
        if (isItUserAnonym === 1) {
            turnOfVideo.style.cssText = 'opacity: 1; display:flex; transform: scale(1);'
        } else {
            turnOfVideo.style.cssText = 'opacity: 0; transform: scale(0);'
        }

    }



    let pictureAndNamecontainer = document.createElement('div')

    let imageStudent = document.createElement('img')
    imageStudent.src = studentUsername.user_image

    let studentName = document.createElement('p')
    studentName.textContent = studentUsername.name_of_user

    let divForStudentImage = document.createElement('div')
    divForStudentImage.className = 'divForStudentImage'
    divForStudentImage.appendChild(imageStudent)

    let svgCrossCameraIcon = document.createElement('div')
    svgCrossCameraIcon.className = 'svgCrossCameraIcon svgCrossCameraIcon1'
    svgCrossCameraIcon.innerHTML = '<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.77762 0.305115L0.304688 1.77825L3.73428 5.20833H3.12421C1.97378 5.20833 1.04117 6.14107 1.04117 7.29167V17.7083C1.04117 18.8589 1.97378 19.7917 3.12421 19.7917H15.6225C16.3537 19.7917 16.997 19.4148 17.3687 18.8446L23.2181 24.6949L24.6911 23.2218L1.77762 0.305115ZM15.6225 17.0982L5.81733 7.29167H3.12421V17.7083H15.6225V17.0982ZM17.7054 8.73121L23.9545 5.60621V19.1355L21.8715 17.0522V8.97712L17.7054 11.0605V13.5425L15.6224 11.4592V7.29167H11.4555L9.37244 5.20833H15.6224C16.7728 5.20833 17.7054 6.14107 17.7054 7.29167V8.73121Z" fill="white"></path></svg>'
    if (!isAudio) {
        divForStudentImage.appendChild(svgCrossCameraIcon)
    }


    pictureAndNamecontainer.appendChild(divForStudentImage)
    pictureAndNamecontainer.append(studentName)

    turnOfVideo.append(pictureAndNamecontainer)

    //adding video turned off container
    videoBox.append(turnOfVideo)

    if (call.user_id != participant.identity) {
        //adding option button only if the user is not me
        videoBox.insertBefore(position_span, videoBox.firstChild)
    }

    let turnOnVideo = document.createElement('div')



    turnOnVideo.className = 'innerVideoBox turnOnVideo'


    if (isItUserAnonym === 1) {
        turnOnVideo.style.cssText = 'opacity: 0; display: none; transform: scale(0);'
    } else {
        turnOnVideo.style.cssText = 'opacity: 1; display: flex; transform: scale(1);'
    }


    //adding video frame container
    videoBox.insertBefore(turnOnVideo, videoBox.firstChild)


    // track this participants published tracks
    participant.tracks.forEach(function (publication) {

        if (publication.isSubscribed) {
            if (publication.track.kind == "video") {

                trackSubscribed(videoBox.getElementsByClassName('turnOnVideo')[0], publication.track, true)

            } else if (publication.track.kind == "audio") {

                trackSubscribed(audioBox, publication.track)
            }
        }
    })

    // on new track subscribed
    participant.on("trackSubscribed", function (track) {

        if (track.kind == "video") {

            turnOfVideo.style.cssText = 'display: none; opacity: 1; transform: scale(1);'
            turnOnVideo.style.cssText = 'display: flex; opacity: 1; transform: scale(1); width: 100%;'

            if (track.name === 'screnShare') {

                trackSubscribed(turnOnVideo, track, 'screnShare')
            } else {
                trackSubscribed(turnOnVideo, track)
            }
        } else if (track.kind == "audio") {

            // add it to audio div
            let audioHolder = null

            if (document.getElementById('audio-track-' + participant.identity)) {

                audioHolder = document.getElementById('audio-track-' + participant.identity)
                audioHolder.innerHTML = ""
            } else {

                audioHolder = document.createElement('div')
                audioHolder.id = 'audio-track-' + participant.identity
            }

            trackSubscribed(audioHolder, track)
        }




    });

    // on track unpublished from a participant
    participant.on("trackUnpublished", function (track) {

        if (track.kind == "video") {

            if (track.trackName === 'screnShare') {

                let videos = document.getElementById('privateTalkStudentHelder').getElementsByTagName('video')

                for (let i = videos.length - 1; i >= 0; i--) {

                    if (videos[i].classList.contains('screnShare')) {
                        if (!videos[i].parentElement.classList.contains('screnShared')) {
                            videos[i].parentElement.classList.remove('screnShared')

                            videos[i].remove()
                        }

                    }

                }

            } else {
                turnOnVideo.style.cssText = 'display: none; opacity: 1; transform: scale(1);'
                turnOfVideo.style.cssText = 'display: flex; opacity: 1; transform: scale(1);'
            }


        } else if (track.kind == "audio") {
            // remove the audio elements from div

        }
    });

    return videoBox
}

/**
 * this function calculate height of video boxes
 * @param calculateHeightHelper - participant object
 * @param devider - devider is used
 */

function calculateHeightOfVideoBoxes(calculateHeightHelper, devider) {
    for (let i = 0; i < calculateHeightHelper.length; i++) {
        calculateHeightHelper[i].className = 'videoBox videoBoxH' + devider
    }
}


/**
 * Disconnect from room on button click
 */

function disConnectFromRoom() {
    closePopup('cancelAppointment')
    // check for selected reason
    let reason = ""

    document.getElementsByName("pockets").forEach(function (element) {
        if (element.checked) {
            reason = element.value
        }
    })

    HANGUP_Send_Event_Function(call, reason)

    if (call.user_type == UserTypes.CLIENT) {
        clearInterval(checkForExtendionInterval)
    }

    twilioRoom.disconnect()

    let popupers = document.getElementsByClassName('popuper')
    for (let i = 0; i < popupers.length; i++) {
        if (popupers[i].parentElement.id !== 'reviewPopUp') {
            closePopup(popupers[i].parentElement.id)
        }

    }

    openPopup('reviewPopUp')
    document.getElementById('reviewPopUp').style.opacity = '0'

    hideStuffOnEndCall()


    setReviewPopupups().then(() => {
        hideLoading()
    }).then(() => {
        calculatePopUpHeight(document.getElementById('reviewPopUp'))
    }).then(() => {
        setTimeout(function () {
            calculatePopUpHeight(document.getElementById('reviewPopUp'))
            document.getElementById('reviewPopUp').style.opacity = '1'
        }, 1000)

    })
}

/**
 * Get the list of available media devices of the given kind.
 * @param {Array<MediaDeviceInfo>} deviceInfos
 * @param {string} kind - One of 'audioinput', 'audiooutput', 'videoinput'
 * @returns {Array<MediaDeviceInfo>} - Only those media devices of the given kind
 */

function getDevicesOfKind(deviceInfos, kind) {

    return deviceInfos.filter(function (deviceInfo) {
        return deviceInfo.kind === kind;
    });
}

/**
 * Apply the selected audio output device.
 * @param {string} deviceId
 * @param {HTMLAudioElement} audio
 * @returns {Promise<void>}
 */

function applyAudioOutputDeviceSelection(deviceId, audio) {
    return typeof audio.setSinkId === 'function' ?
        audio.setSinkId(deviceId) :
        Promise.reject(getPoTranslate('BROWSER_NOT_SUPPORT'))
}

/**
 * Apply the selected input device.
 * @param {string} deviceId
 * @param {?LocalTrack} localTrack - LocalAudioTrack or LocalVideoTrack; if null, a new LocalTrack will be created.
 * @param {'audio' | 'video'} kind
 * @returns {Promise<LocalTrack>} - The created or restarted LocalTrack
 */

function applyInputDeviceSelection(deviceId, localTrack, kind) {

    // debugging

    var constraints = {
        deviceId: {
            exact: deviceId
        }
    }

    if (localTrack) {
        return localTrack.restart(constraints).then(function () {
            return localTrack
        })
    }

    return kind === 'audio' ? createLocalAudioTrack(constraints) : createLocalVideoTrack(constraints);
}

/**
 * Ensure that media permissions are obtained.
 * @returns {Promise<void>}
 */

function ensureMediaPermissions(options) {
    return navigator.mediaDevices.enumerateDevices().then(function (devices) {
        return devices.every(function (device) {
            return !(device.deviceId && device.label)
        })
    }).then(function (shouldAskForMediaPermissions) {
        if (shouldAskForMediaPermissions) {
            return navigator.mediaDevices.getUserMedia({
                audio: options.audio,
                video: options.video
            }).then(function (mediaStream) {
                mediaStream.getTracks().forEach(function (track) {
                    track.stop()
                })
            }).catch(function (error) {
                console.log(error)
            })
        }
    })
}

async function checkPermissionsAndPublishTracks() {
    console.log('desnuo sam se');
    let bothAllowed = false

    if (call.user_type == UserTypes.CLIENT && call.interactive_mode === CallInteractionTypes.WATCH) {
        bothAllowed = true
    } else {
        let permissions = []
        let permissionTypes = ["microphone"]

        if (!isAudio) {
            permissionTypes.push("camera")
        } else {
            document.getElementById("allowCamMainCont").style.display = 'none'
            document.getElementById("videopreviewparent").style.display = 'none'
        }
        await Promise.all(
            permissionTypes.map(async permissionName => {
                try {
                    permission = await navigator.permissions.query({
                        name: permissionName
                    })
                    permissions.push({
                        permissionName,
                        state: permission.state
                    })
                    console.log('desnuo sam se 22: ', permissionName);
                } catch (e) {
                    permissions.push({
                        permissionName,
                        state: 'error',
                        errorMessage: e.toString()
                    })
                }
            })
        )

        if (isAudio) {
            bothAllowed = permissions[0].state == "granted"
        } else {
            bothAllowed = permissions[0].state == "granted" && permissions[1].state == "granted"
        }

        permissions.forEach(function (permission) {
            if (permission.state == "prompt") {
                console.log('ovde 00');
                if (permission.permissionName == "camera") {
                    console.log('ovde 00 camera');
                    document.getElementById('accessCamera').addEventListener('click', function () {
                        navigator.mediaDevices.getUserMedia({
                            video: true
                        }).then(function (mediaStream) {
                            document.getElementById('webCamAllowed').textContent = '1'

                            setAccesCameraMic(true)

                            updateDeviceSelectionOptions({
                                video: true,
                                audio: false
                            })

                            mediaStream.getTracks().forEach(function (track) {
                                track.stop()
                            })

                        }).catch(function (error) {

                            console.log(error, '_________You do not have booked room.________777999999999999997777')
                            document.getElementById('errorMsgtitle').textContent = userObj1.name
                            document.getElementById('errorMsgText').textContent = error.message
                            document.getElementById('errorMsgAdvice').textContent = getPoTranslate('YOU_HAVE_WEBCAM')
                            openPopup('errorPopup')
                        });
                    })
                }
                if (permission.permissionName == "microphone") {
                    console.log('ovde 00 mic');
                    document.getElementById('allowMic').addEventListener('click', function () {
                        navigator.mediaDevices.getUserMedia({
                            audio: true
                        }).then(function (mediaStream) {
                            document.getElementById('microphoneAllowed').textContent = '1'
                            setAccesCameraMic(true)
                            updateDeviceSelectionOptions({
                                video: false,
                                audio: true
                            })
                            mediaStream.getTracks().forEach(function (track) {
                                track.stop()
                            })
                        }).catch(function (error) {
                            console.log(error, '_________________2323232323232323')
                            document.getElementById('errorMsgtitle').textContent = userObj1.name
                            document.getElementById('errorMsgText').textContent = error.message
                            document.getElementById('errorMsgAdvice').textContent = getPoTranslate('YOU_HAVE_MIC')
                            openPopup('errorPopup')
                        });
                    })
                }
            } else if (permission.state == "denied") {
                console.log('ovde 00 ipak denied');
                if (permission.permissionName == "camera") {
                    document.getElementById('webCamAllowed').textContent = '2'
                    console.log('ovde 00 ipak denied cam');
                }
                if (permission.permissionName == "microphone") {
                    console.log('ovde 00 ipak denied mic');
                    document.getElementById('microphoneAllowed').textContent = '2'
                }
                setAccesCameraMic()
            } else {
                console.log('ovde 00 ipak ko zna ?!');
                if (permission.permissionName == "camera") {
                    console.log('ovde 00 ipak ko zna ?! cam');
                    document.getElementById('webCamAllowed').textContent = '1'
                    setAccesCameraMic()
                    updateDeviceSelectionOptions({
                        video: true,
                        audio: false
                    })
                }
                if (permission.permissionName == "microphone") {
                    console.log('ovde 00 ipak ko zna ?! mic');
                    document.getElementById('microphoneAllowed').textContent = '1'
                    setAccesCameraMic()

                    updateDeviceSelectionOptions({
                        video: false,
                        audio: true
                    })
                }
            }
        })
    }

    if (bothAllowed) {
        let audio = true
        let video = true

        if (call.user_type == UserTypes.CLIENT && call.interactive_mode === CallInteractionTypes.WATCH) {
            console.log('44');
            audio = true
            video = true
        } else {
            console.log('55');
            if (!isAudio) {
                if (document.getElementById('webCamAllowed')) {
                    document.getElementById('webCamAllowed').textContent = '1'
                }

            }

            document.getElementById('microphoneAllowed').textContent = '1'

            let audioPointer = false
            if (call.is_anonym === 1 && call.talk_type === 2 && call.user_type == UserTypes.CLIENT) {
                audioPointer = true
            }

            setAccesCameraMic(audioPointer)

            audio = true
            video = !isAudio

        }

        createLocalTracks({
            audio: audio,
            video: video
        }).then(function (tracks) {
            console.log(audio, video);
            tracks.forEach(function (track) {

                if (track.kind == "video") {
                    localVideoTrack = track
                } else {
                    localAudioTrack = track
                }

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

                        let active_users = response.data.active_users

                        for (let i = 0; i < active_users.length; i++) {
                            if (userObj1.id == active_users[i].user_id) {
                                if (localVideoTrack.kind == "video") {

                                    if (active_users[i].video_status == Events.VIDEO_OFF) {
                                        localVideoTrack.disable()

                                        call.videoMuted = true
                                        if (document.getElementById("video-mute-unmute")) {
                                            document.getElementById('video-mute-unmute').innerHTML = Icons.cameraMuted
                                        }
                                    } else if (active_users[i].video_status == Events.VIDEO_ON) {
                                        localVideoTrack.enable()

                                        call.videoMuted = false
                                        if (document.getElementById("video-mute-unmute")) {
                                            document.getElementById('video-mute-unmute').innerHTML = Icons.camera
                                        }
                                    }
                                } else if (localAudioTrack.kind == "audio") {

                                    if (active_users[i].voice_status == Events.AUDIO_OFF) {

                                        localAudioTrack.disable()
                                        if (document.getElementById('audio-mute-unmute')) {
                                            document.getElementById('audio-mute-unmute').innerHTML = Icons.microphoneMuted
                                        }
                                        call.muted = true
                                    } else if (active_users[i].voice_status == Events.AUDIO_ON) {
                                        call.muted = false

                                        localAudioTrack.enable()
                                        if (document.getElementById('audio-mute-unmute')) {
                                            document.getElementById('audio-mute-unmute').innerHTML = Icons.microphone
                                        }
                                    }
                                }
                            }
                        }

                    })

            })

            if (window.appliedTrackclicked === 1) {
                applyTracksSelection(tracks)
                window.appliedTrackclicked = 0
            }


        }).then(function () {
            //closePopup('callSetting')
        }).catch(function (error) {

            console.log(error, '_________You do not have booked room.________777778888888888888877')
            document.getElementById('errorMsgtitle').textContent = userObj1.name
            document.getElementById('errorMsgText').textContent = error.message
            document.getElementById('errorMsgAdvice').textContent = getPoTranslate('YOU_HAVE_WEBCAM_MIC')
            openPopup('errorPopup')
        })


        updateDeviceSelectionOptions({
            video: !isAudio,
            audio: true
        })

        return
    }



    closePopup('loadingPopup')

    maybeEnableConnectButton()
}

/**
 * Get the list of available media devices.
 * @returns {Promise<DeviceSelectionOptions>}
 * @typedef {object} DeviceSelectionOptions
 * @property {Array<MediaDeviceInfo>} audioinput
 * @property {Array<MediaDeviceInfo>} audiooutput
 * @property {Array<MediaDeviceInfo>} videoinput
 */

function getDeviceSelectionOptions(options) {
    // before calling enumerateDevices, get media permissions (.getUserMedia)
    // w/o media permissions, browsers do not return device Ids and/or labels.
    return ensureMediaPermissions(options).then(function () {
        return navigator.mediaDevices.enumerateDevices().then(function (deviceInfos) {

            var kinds = ['audioinput', 'videoinput']

            return kinds.reduce(function (deviceSelectionOptions, kind) {
                deviceSelectionOptions[kind] = getDevicesOfKind(deviceInfos, kind)

                return deviceSelectionOptions
            }, {})
        });
    });
}


function maybeEnableConnectButton() {
    if (document.getElementById("room-connect-button")) {
        document.getElementById("room-connect-button").disabled = !(localAudioTrack && localVideoTrack);
    }
}

window.applyTracksSelectionInteractiveOne = function () {

    if (isAudio) {
        applyTracksSelection([localAudioTrack], true)
        showNoAccessLabel(true, call)
    } else {

        applyTracksSelection([localAudioTrack, localVideoTrack], true)
    }

}

function applyTracksSelection(tracks, pointerForInteractiveOne = false) {

    tracks.forEach(function (track) {

        twilioRoom.localParticipant.publishTrack(track).then(function (publication) {
            if (pointerForInteractiveOne) {
                console.log('ovde nismo svakako');
                let participantVideoFrame = getParticipantVideoFrame(userObj1.id)

                trackSubscribed(
                    participantVideoFrame.getElementsByClassName("turnOnVideo")[0],
                    publication.track,
                    true
                )

                if (publication.track.kind == "video") {

                    track.enable()
                    call.videoMuted = false

                } else if (publication.track.kind == "audio") {

                    track.enable()
                    call.muted = false

                }
            } else {
                console.log('mi smo ovde4344')
                if (call.user_type == UserTypes.PROVIDER) {
                    console.log('mi smo ovde4344 a ovde pogotovo')
                    trackSubscribed(
                        document.getElementsByClassName("videoBoxProfesor")[0].getElementsByClassName("videoBoxTeacher")[0],
                        publication.track,
                        true
                    )

                    if (publication.track.kind == "video") {
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

                                let active_users = response.data.active_users

                                for (let i = 0; i < active_users.length; i++) {
                                    if (userObj1.id == active_users[i].user_id) {

                                        if (active_users[i].video_status == Events.VIDEO_OFF) {
                                            track.disable()

                                            call.videoMuted = true
                                            if (document.getElementById("video-mute-unmute")) {
                                                document.getElementById('video-mute-unmute').innerHTML = Icons.cameraMuted
                                            }
                                        } else if (active_users[i].video_status == Events.VIDEO_ON) {
                                            track.enable()

                                            call.videoMuted = false
                                            if (document.getElementById("video-mute-unmute")) {
                                                document.getElementById('video-mute-unmute').innerHTML = Icons.camera
                                            }
                                        }

                                    }
                                }




                            })
                    } else if (publication.track.kind == "audio") {
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
                                let active_users = response.data.active_users

                                for (let i = 0; i < active_users.length; i++) {
                                    if (userObj1.id == active_users[i].user_id) {


                                        if (active_users[i].voice_status == Events.AUDIO_OFF) {

                                            track.disable()
                                            if (document.getElementById('audio-mute-unmute')) {
                                                document.getElementById('audio-mute-unmute').innerHTML = Icons.microphoneMuted
                                            }
                                            call.muted = true
                                        } else if (active_users[i].voice_status == Events.AUDIO_ON) {
                                            call.muted = false

                                            track.enable()
                                            if (document.getElementById('audio-mute-unmute')) {
                                                document.getElementById('audio-mute-unmute').innerHTML = Icons.microphone
                                            }
                                        }

                                    }
                                }




                            })
                    }

                } else if (call.user_type == UserTypes.CLIENT) {
                    console.log('mi ovde nismo 4344411111');
                    if (publication.track.kind == "video") {
                        let participantVideoFrame = getParticipantVideoFrame(userObj1.id)

                        trackSubscribed(
                            participantVideoFrame.getElementsByClassName("turnOnVideo")[0],
                            publication.track,
                            true
                        )



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

                                let active_users = response.data.active_users
                                if (call.interactive_mode === CallInteractionTypes.INTERACTIVE_ONE && call.user_type == UserTypes.CLIENT) {
                                    track.disable()

                                    call.videoMuted = true
                                } else {
                                    for (let i = 0; i < active_users.length; i++) {
                                        if (userObj1.id == active_users[i].user_id) {


                                            if (active_users[i].video_status == Events.VIDEO_OFF) {
                                                track.disable()

                                                call.videoMuted = true
                                                if (document.getElementById("video-mute-unmute")) {
                                                    document.getElementById('video-mute-unmute').innerHTML = Icons.cameraMuted
                                                }
                                            } else if (active_users[i].video_status == Events.VIDEO_ON) {
                                                track.enable()

                                                call.videoMuted = false
                                                if (document.getElementById("video-mute-unmute")) {
                                                    document.getElementById('video-mute-unmute').innerHTML = Icons.camera
                                                }
                                            }

                                        }
                                    }
                                }


                            })
                    } else if (publication.track.kind == "audio") {

                        let participantVideoFrame = getParticipantVideoFrame(userObj1.id)


                        trackSubscribed(
                            participantVideoFrame.getElementsByClassName('turnOnVideo')[0],
                            publication.track,
                            true
                        )

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

                                let active_users = response.data.active_users
                                if (call.interactive_mode === CallInteractionTypes.INTERACTIVE_ONE && call.user_type == UserTypes.CLIENT) {
                                    track.disable()
                                    call.muted = true
                                } else {
                                    for (let i = 0; i < active_users.length; i++) {
                                        if (userObj1.id == active_users[i].user_id) {

                                            if (active_users[i].voice_status == Events.AUDIO_OFF) {

                                                track.disable()
                                                if (document.getElementById('audio-mute-unmute')) {
                                                    document.getElementById('audio-mute-unmute').innerHTML = Icons.microphoneMuted
                                                }
                                                call.muted = true
                                            } else if (active_users[i].voice_status == Events.AUDIO_ON) {
                                                call.muted = false

                                                track.enable()
                                                if (document.getElementById('audio-mute-unmute')) {
                                                    document.getElementById('audio-mute-unmute').innerHTML = Icons.microphone
                                                }
                                                showNoAccessLabel(true, call)
                                            }

                                        }
                                    }
                                }


                            })

                    }
                }
            }

        }).catch(function (error) {
            console.log(error, '_________________55555555555555555555555555555552323')
            document.getElementById('errorMsgtitle').textContent = userObj1.name
            document.getElementById('errorMsgText').textContent = error
            document.getElementById('errorMsgAdvice').textContent = 'Please make sure your webcam and microphone are accessable'
            openPopup('errorPopup')
        })

    })
}
/**
 * Build the list of available media devices.
 */

function updateDeviceSelectionOptions(options) {
    return getDeviceSelectionOptions(options)
        .then(function (deviceSelectionOptions) {
            ['audioinput', 'videoinput'].forEach(function (kind) {
                var kindDeviceInfos = deviceSelectionOptions[kind];
                var select = deviceSelections[kind];

                [].slice.call(select.children).forEach(function (option) {
                    option.remove();
                });

                kindDeviceInfos.forEach(function (kindDeviceInfo) {
                    var deviceId = kindDeviceInfo.deviceId;
                    var label = 'Default'
                    if (kindDeviceInfo.label && kindDeviceInfo.label.length > 0) {
                        label = kindDeviceInfo.label
                    }

                    var option = document.createElement('option');
                    option.value = deviceId;

                    option.appendChild(document.createTextNode(label));
                    select.appendChild(option);

                    select.addEventListener('change', function () {
                        if (kind == "audioinput") {
                            applyAudioInputDeviceChange()
                        } else {
                            // sync the preview with connected tracks.
                            applyVideoInputDeviceChange()
                        }
                    })
                });
            });
            // sync the preview with connected tracks.
            if (options.audio) {
                applyAudioInputDeviceChange()
            }
            if (options.video) {
                applyVideoInputDeviceChange()
            }
        })
}

// reads selected audio input, and updates preview and room to use the device.
async function applyAudioInputDeviceChange(event) {
    if (event) {
        event.preventDefault()
        event.stopPropagation()
    }

    if (call.user_type == UserTypes.CLIENT && call.interactive_mode === CallInteractionTypes.WATCH) {

    } else {
        localAudioTrack = await applyInputDeviceSelection(deviceSelections.audioinput.value, localAudioTrack, 'audio')
        maybeEnableConnectButton()
        return localAudioTrack
    }
}

// reads selected video input, and updates preview and room to use the device.

async function applyVideoInputDeviceChange(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    if (document.getElementById('video-not-available')) {
        const videoNotAvailable = document.getElementById('video-not-available');
        videoNotAvailable.style.display = 'none'
    }
    if (call.user_type == UserTypes.CLIENT && call.interactive_mode === CallInteractionTypes.WATCH) {

    } else {
        const video = document.querySelector('video#videoinputpreview');
        localVideoTrack = await applyInputDeviceSelection(deviceSelections.videoinput.value, localVideoTrack, 'video');
        localVideoTrack.attach(video);
        maybeEnableConnectButton();
        return localVideoTrack;
    }

}

function getRoomStatusBeforeConnect() {
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
            //store response inside dataObj so it can be used later in other placesRc

            dataObj = response.data

            if (call.user_type == UserTypes.CLIENT) {
                if (call.is_anonym === 1) {

                    isAudio = true
                    showNoAccessLabel(true, call)
                }
            }

            //useing query parameters for displaying message after succesiful 3Ds payment extend
            const queryString = window.location.search
            const urlParams = new URLSearchParams(queryString)
            const message = urlParams.get('message')
            const success = urlParams.get('success')


            if (success === 'true') {

                window.extendTalkParameters = [
                    getCookie('extension_minutes').trim(),
                    getCookie('extension_price').trim()
                ]

                let thatsMe
                for (let i = 0; i < dataObj.active_users.length; i++) {
                    if (dataObj.active_users[i].user_id === userObj1.id) {
                        thatsMe = {
                            name: dataObj.active_users[i].name_of_user,
                            profile_picture: dataObj.active_users[i].user_image
                        }
                    }

                }

                EXTEND_CALL_SUCCESSFUL_Send_Event_Function(call, thatsMe, window.extendTalkParameters)

                openPopup('paymentCompletedPopUp')

                setTimeout(function () {
                    closePopup('paymentCompletedPopUp')
                }, 5000)

                history.pushState({}, document.title, location.origin + location.pathname)

            } else if (success === 'false') {
                toastify(message)
                toastify(getPoTranslate('SOMETHING_WENT_WRONG'))
                history.pushState({}, document.title, location.origin + location.pathname)
            }


            if (response.data.active_users) {

                call.booking_id = response.data.active_users[0].booking_id

                if (response.data.state == RoomStates.ROOM_IN_PROGRESS) {



                    //inputing  room name
                    document.getElementsByClassName('heading-group')[0].getElementsByTagName('p')[0].textContent = call.room_name

                    let callStartTime = isSafari ? response.data.talk_start_time.replaceAll('-', '/') : response.data.talk_start_time

                    let startTime = new Date(callStartTime)


                    startTime = new Date(startTime); // Date object

                    let callEndTime = isSafari ? response.data.talk_end_time.replaceAll('-', '/') : response.data.talk_end_time

                    let endTime = new Date(callEndTime);

                    endTime = new Date(endTime);

                    document.getElementById('startCalltime').textContent = addZero(startTime.getHours()) + ':' + addZero(startTime.getMinutes())
                    document.getElementById('endCallTime').textContent = addZero(endTime.getHours()) + ':' + addZero(endTime.getMinutes())

                    //storing active_users to helper variable, maybe not needed
                    others = response.data.active_users

                    //inputing room time left to the end to page
                    document.getElementById('timeLeft').textContent = response.data.duration


                    RECONNECT_TO_ROOM_Send_Event_Function(call)

                    ReconnectToRoom_Socket_Listen_Function(call)

                    //start of connecting to twilio room
                    connectToRoom(response.data)

                } else {

                    // show room invalid / ended popup

                    console.log(error, '_________ROOM_NOT_IN_PROGRESS________99999999')
                    document.getElementById('errorMsgtitle').textContent = userObj1.name
                    document.getElementById('errorMsgText').textContent = getPoTranslate('ROOM_FINISHED')
                    document.getElementById('errorMsgAdvice').textContent = getPoTranslate('BOOK_NEW_TALK')

                    openPopup('errorPopup')

                    setTimeout(function () {
                        closePopup('loadingPopup')
                    }, 2000)

                }

            } else {

                em = getPoTranslate('NOT_HAVE_BOOKED_ROOM')
                closePopup('loadingPopup')
                console.log(error, '_________ROOM_NOT_IN_PROGRESS________11111111111111111111111')
                document.getElementById('errorMsgtitle').textContent = userObj1.name
                document.getElementById('errorMsgText').textContent = em ? em.length > 0 ? em : error.message : error.message
                document.getElementById('errorMsgAdvice').textContent = ''
                openPopup('errorPopup')
                toastify(em)
            }
        }).catch(function (error) {

            connectToSocketCatchError(error)
        })
}

function preCallConfiguration() {

    if (call.user_type == UserTypes.CLIENT) {
        if (call.is_anonym === 1) {
            showNoAccessLabel(true, call)
            isAudio = true
        }
    }

    call.videoMuted = false

    document.getElementById('time-left-wrapper').style.display = 'none'
    call.muted = false

    openPopup('loadingPopup')

    //set class on main element for professor and remove extend button from professors side

    if (call.user_type == UserTypes.PROVIDER) {
        document.getElementsByTagName('main')[0].classList.add('professorVideoTalkMain')
        if (document.getElementsByClassName('extendMobileLi')[0]) {
            document.getElementsByClassName('extendMobileLi')[0].remove()
        }
    }
}
