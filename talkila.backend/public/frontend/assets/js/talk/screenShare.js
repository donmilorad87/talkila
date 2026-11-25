if (document.getElementsByClassName('share_screen')[0]) {
    let shareScreen = document.getElementsByClassName('share_screen')
    let screenTrack

    for (let i = 0; i < shareScreen.length; i++) {
        shareScreen[i].addEventListener('click', shareScreenHandler)

        function shareScreenHandler(event) {
            event.preventDefault()

            if (!screenTrack) {
                //screen share on
                sendEvents(Events.SCREEN_SHARE_ON, {
                    user_id: parseInt(userObj1.id)
                }, call)



                navigator.mediaDevices.getDisplayMedia(/* {video: { width: 640 }} */).then(stream => {

                    screenTrack = new LocalVideoTrack(stream.getTracks()[0], {
                        name: 'screnShare'
                    })

                    twilioRoom.localParticipant.publishTrack(screenTrack).then(function (publication) {

                        //set button text to stop sharing
                        for (let i = 0; i < shareScreen.length; i++) {
                            shareScreen[i].innerHTML = '<div><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect xmlns="http://www.w3.org/2000/svg" x="9" y="9" width="22" height="22" rx="8" fill="#fff" stroke="#172B4D" stroke-width="1"></rect><rect xmlns="http://www.w3.org/2000/svg" x="12" y="12" width="16" height="16" rx="5" fill="#FFB805" stroke="#172B4D" stroke-width="2"></rect> <g filter="url(#filter0_i)"> <path d="M0.5 6C0.5 2.96243 2.96243 0.5 6 0.5H34C37.0376 0.5 39.5 2.96243 39.5 6V34C39.5 37.0376 37.0376 39.5 34 39.5H6C2.96243 39.5 0.5 37.0376 0.5 34V6Z" stroke="#E5E5F1"></path> </g> </svg></div>'
                        }

                        screenTrack.mediaStreamTrack.onended = () => {
                            closeScreenShare()
                        }

                        if (call.user_type == UserTypes.PROVIDER) {

                            let participantVideoFrame = document.getElementsByClassName('videoBoxTeacher')[0]


                            trackSubscribed2(
                                participantVideoFrame,
                                publication.track,
                                true,
                                true
                            )

                        } else if (call.user_type == UserTypes.CLIENT) {
                            if (publication.track.kind == "video") {

                                let participantVideoFrame = getParticipantVideoFrame(userObj1.id)

                                trackSubscribed2(
                                    participantVideoFrame,
                                    publication.track,
                                    true,
                                    true
                                )
                            }
                        }
                    })


                }).catch((error) => {
                    console.log(error)
                    alert('Could not share the screen.')
                })

            } else {
                //screnn share off
                closeScreenShare()

            }

            function closeScreenShare() {

                sendEvents(Events.SCREEN_SHARE_OFF, {
                    user_id: parseInt(userObj1.id)
                }, call)


                twilioRoom.localParticipant.videoTracks.forEach((publication) => {
                    if (publication.track.name === 'screnShare') {


                        publication.track.disable()
                        twilioRoom.localParticipant.unpublishTrack(publication.track);
                        publication.track.detach().forEach((element) => {

                            if (call.user_type == UserTypes.PROVIDER) {

                                if(element.parentElement.classList.contains('teacherScreenShare')){
                                    element.parentElement.classList.remove('teacherScreenShare')
                                }
                                element.remove()
                            }
                            else if (call.user_type == UserTypes.CLIENT) {
                                element.remove()
                            }

                        })
                    }
                })

                //twilioRoom.localParticipant.unpublishTrack(screenTrack)
                screenTrack.stop()
                screenTrack = null


                for (let i = 0; i < shareScreen.length; i++) {
                    shareScreen[i].innerHTML = '<div><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M16.1576 17.4866H15.3801C13.6843 17.4866 12.3093 18.8616 12.3093 20.5574V24.6199C12.3093 26.3149 13.6843 27.6899 15.3801 27.6899H24.6551C26.3509 27.6899 27.7259 26.3149 27.7259 24.6199V20.5491C27.7259 18.8583 26.3551 17.4866 24.6643 17.4866H23.8784" stroke="#172B4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M20.0175 11.8255V21.8596" stroke="#172B4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.5881 14.2656L20.0172 11.8256L22.4472 14.2656" stroke="#172B4D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <g filter="url(#filter0_i)"> <path d="M0.5 6C0.5 2.96243 2.96243 0.5 6 0.5H34C37.0376 0.5 39.5 2.96243 39.5 6V34C39.5 37.0376 37.0376 39.5 34 39.5H6C2.96243 39.5 0.5 37.0376 0.5 34V6Z" stroke="#E5E5F1"></path> </g> <defs> <filter id="filter0_i" x="0" y="0" width="40" height="41" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood> <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix> <feOffset dy="1"></feOffset> <feGaussianBlur stdDeviation="1"></feGaussianBlur> <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"></feComposite> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"></feColorMatrix> <feBlend mode="normal" in2="shape" result="effect1_innerShadow"></feBlend> </filter> </defs></svg></div>'

                }
            }
        };
    }
}



function ScreenShareOn_Socket_Listen_Function(call, userObj) {
    window.Echo.channel("room." + call.socket_room_id).listen("ScreenShareOn", function (data) {



        if (data.user_id == userObj.id) {



        } else {



            if (localStorage.getItem('arrayForScreenShare') !== null) {

                let stringOfScreenShares = localStorage.getItem('arrayForScreenShare')

                if (!stringOfScreenShares.includes(" " + data.user_id + ',')) {
                    stringOfScreenShares += ' ' + data.user_id + ','

                    localStorage.setItem('arrayForScreenShare', stringOfScreenShares)
                }

            } else {

                let idOfScreenSharedUser = ' ' + data.user_id + ','
                localStorage.setItem('arrayForScreenShare', idOfScreenSharedUser)

            }

        }

    })
}

function ScreenShareOff_Socket_Listen_Function(call, userObj) {
    window.Echo.channel("room." + call.socket_room_id).listen("ScreenShareOff", function (data) {

        if (data.user_id == userObj.id) {

        } else {

            if (localStorage.getItem('arrayForScreenShare') !== null) {

                let screenShareArray = localStorage.getItem('arrayForScreenShare')



                if (screenShareArray.includes(" " + data.user_id + ',')) {

                    let splitedString = screenShareArray.replace(" " + data.user_id + ",", "");


                    localStorage.setItem('arrayForScreenShare', splitedString)

                }
            }

        }
    })
}


function removeItemOnce(arr, value) {
    var index = arr.indexOf(value);
    if (index > -1) {
        arr.splice(index, 1);
    }
    return arr;
}
