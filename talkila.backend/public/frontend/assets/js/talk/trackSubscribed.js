/**
 * append the track to div - on video sets width 100 - can be removed once fixed via css
 */
function trackSubscribed(div, track, trackName) {

    const element = track.attach()

    if(track.name === 'screnShare'){
        if (call.user_type == UserTypes.PROVIDER) {
            div.classList.add('screnShared')
            element.classList.add('screnShare')
            element.style.transform = 'scaleX(1,1)'
        } else if (call.user_type == UserTypes.CLIENT) {
            div.classList.add('teacherScreenShare')
            element.classList.add('screnShare')
            element.style.transform = 'scaleX(1,1)'

        }

    }else{
        element.style.transform = 'scaleX(-1)'
    }

    div.appendChild(element)

    track.on('enabled', () => {

    })

    track.on('disabled', () => {
        /* Hide the avatar image and show the associated <video> element. */

    })

}

function trackSubscribed2(div, track, pointer) {

    const element = track.attach()

    if (pointer) {

        element.style.transform = 'scaleX(1)'
        element.style.width = '100%'

        if (call.user_type == UserTypes.PROVIDER) {


            if (track.name === 'screnShare') {
                div.classList.add('teacherScreenShare')
            }


            if (track.name === 'screnShare') {
                element.className = 'screnShare'
                div.appendChild(element)
            }


        } else if (call.user_type == UserTypes.CLIENT) {
            //ovde trenutno nismo, ovo ce se desavati kada teacher screen sharuje
            let participantVideoFrame = getParticipantVideoFrame(userObj1.id)

            let screenShareFrame = document.createElement('div')
            screenShareFrame.className = 't03s'


            if (track.name === 'screnShare') {
                screenShareFrame.classList.add('studentScreenShare')
            }

            /* let arrayOfelements = [participantVideoFrame.getElementsByClassName('turnOnVideo')[0], participantVideoFrame.getElementsByClassName('turnOfVideo')[0]]

            for (let i = 0; i < arrayOfelements.length; i++) {
                arrayOfelements[i].classList.add('screenSharingHelperVideoStudent')
            } */

            //ovde socket event

            participantVideoFrame.appendChild(screenShareFrame)

            div = screenShareFrame

            if (track.name === 'screnShare') {
                element.className = 'screnShare'
                div.appendChild(element)
            }
        }

    }


}
