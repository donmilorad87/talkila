let assetsImageUrl = window.location.protocol + '//' + window.location.hostname + '/frontend/assets/img'


let pp2 = 0
const callType = document.getElementById('callType').textContent.trim()

let userObj2 = JSON.parse(document.getElementById('userObject').textContent.trim())







function cancelQuitVideoCall() {
    if( document.getElementById('cancelQuit')){
        document.getElementById('cancelQuit').addEventListener('click', function () {
            let mainPopup = document.getElementById('closingVideoQuestion')
            mainPopup.style.opacity = '0'
            mainPopup.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
            setTimeout(function () {
                mainPopup.style.display = 'none'
            }, 310)

        })
    }

}


function pinStudent() {
    //class="pinStudent" data-pinned="0"
    let pinStudent = document.getElementsByClassName('pinStudent')

    for (let i = 0; i < pinStudent.length; i++) {
        pinStudent[i].addEventListener('click', pinStudentEvent2)
    }
}

function pinStudentEvent2(e) {

    function calculateHeightOfVideoBoxes2(calculateHeightHelper, len) {
        let devider

        if (len < 3) {
            devider = 2
        } else if (len > 2 && len < 4) {
            devider = 3
        } else if (len > 3 && len < 8) {
            devider = 4
        } else {
            devider = 8
        }

        for (let i = 0; i < calculateHeightHelper.length; i++) {

            calculateHeightHelper[i].className = 'videoBox videoBoxH' + devider
        }

    }

    let optionButtons = document.getElementsByClassName('optionButton')

    for (let i = 0; i < optionButtons.length; i++) {
        if (optionButtons[i].dataset.id === e.target.dataset.id) {

            optionButtons[i].dataset.opened = 0

        }
    }


    let pinnedStudentsFrame = document.getElementsByClassName('pinnedStudentsFrame')[0]
    let noPinnedStudentsFrame = document.getElementsByClassName('noPinnedStudentsFrame')[0]
    let videoBoxProfesor = document.getElementsByClassName('videoBoxProfesor')[0]


    if (e.target.dataset.pinned === "0") {

        if (pinnedStudentsFrame.getElementsByClassName('videoBox').length < 5) {

            let videoBoxes = document.getElementsByClassName('videoBox')

            for (let i = 0; i < videoBoxes.length; i++) {
                if (videoBoxes[i].dataset.id === e.target.dataset.id) {
                    window.eTar = videoBoxes[i].getElementsByClassName('optionButton')[0]
                }
            }


            if(window.eTar){
                window.eTar.parentNode.parentNode.style.transform = 'scale(0)'
            }
            if (pinnedStudentsFrame.getElementsByClassName('videoBox').length === 0) {
                pinnedStudentsFrame.style.height = 'calc((100vh / 3) - (80px / 3 ))'
                videoBoxProfesor.style.height = 'calc(((100vh / 3) - (80px / 3 )) * 2)'
                if (videoBoxProfesor.getElementsByTagName('video')[0]) {
                    videoBoxProfesor.getElementsByTagName('video')[0].style.height = 'calc(((100vh / 3) - (80px / 3 )) * 2)'
                }

                //e.target.parentNode.parentNode.style.height = 'calc((100vh / 3) - (80px /3 ))'
            }
            let that
            if(window.eTar){
                that = window.eTar
            }

            let that2 = e.target

            setTimeout(function () {

                if (document.body.getElementsByClassName('dropdown-menu-field')[0]) {
                    that.insertBefore(document.body.getElementsByClassName('dropdown-menu-field')[0], that.lastChild)
                }

                pinnedStudentsFrame.insertBefore(that.parentNode.parentNode, pinnedStudentsFrame.lastChild)

                let noPinnedStudentsFrame2 = document.getElementsByClassName('noPinnedStudentsFrame')[0].getElementsByClassName('videoBox')
                calculateHeightOfVideoBoxes2(noPinnedStudentsFrame2, noPinnedStudentsFrame2.length)

                if (noPinnedStudentsFrame.getElementsByClassName('videoBox').length === 0) {

                    document.getElementsByClassName('viewStudents')[0].classList.remove('is-active')
                    document.getElementsByClassName('viewProfesor')[0].classList.add('is-active')

                    //noPinnedStudentsFrame.style.width = '0'
                    document.getElementById('mainVideoBigFrame').classList.remove('small-8')
                    document.getElementById('mainVideoBigFrame').classList.add('small-12')
                    document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-8')
                    document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-12')
                }

                //odredjivanje sirine za pinned frames
                that.parentNode.parentNode.style.width = '20%'

                that.dataset.opened = 0
                that2.dataset.pinned = 1

                that2.getElementsByTagName('span')[1].textContent = 'Unpin User'

                setTimeout(function () {
                    that.parentNode.parentNode.style.transform = 'scale(1)'
                }, 210)

            }, 310)
        } else {
            console.log('max 5 pinned students')
        }
    } else {

        //vracanje na desnu stranu

        let videoBoxes = document.getElementsByClassName('videoBox')

        for (let i = 0; i < videoBoxes.length; i++) {
            if (videoBoxes[i].dataset.id === e.target.dataset.id) {
                window.eTar = videoBoxes[i].getElementsByClassName('optionButton')[0]
            }
        }

        if(window.eTar){
            window.eTar.parentNode.parentNode.style.transform = 'scale(0)'
            window.eTar.parentNode.parentNode.style.width = '0'

        }


        if (noPinnedStudentsFrame.getElementsByClassName('videoBox').length === 0) {

            document.getElementsByClassName('viewStudents')[0].classList.add('is-active')
            document.getElementsByClassName('viewProfesor')[0].classList.remove('is-active')
            noPinnedStudentsFrame.style.width = '100%'
            document.getElementById('mainVideoBigFrame').classList.remove('small-12')
            document.getElementById('mainVideoBigFrame').classList.add('small-8')
            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-12')
            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-8')
        }
        let that
        if(window.eTar){
            that = window.eTar
        }
        let that2 = e.target

        setTimeout(function () {

            setTimeout(function () {

                if (document.body.getElementsByClassName('dropdown-menu-field')[0]) {
                    that.insertBefore(document.body.getElementsByClassName('dropdown-menu-field')[0], that.lastChild)
                }


                //ovde je potrebna funkcija za rearange videoboxeva na desnoj strani

                document.getElementById('rowOne').insertBefore(
                    that.parentNode.parentNode,
                    document.getElementById('rowOne').lastChild)


                let noPinnedStudentsFrame2 = document.getElementsByClassName('noPinnedStudentsFrame')[0].getElementsByClassName('videoBox')
                calculateHeightOfVideoBoxes2(noPinnedStudentsFrame2, noPinnedStudentsFrame2.length)

                if (pinnedStudentsFrame.getElementsByClassName('videoBox').length === 0) {
                    pinnedStudentsFrame.style.height = '0px'
                    videoBoxProfesor.style.height = 'calc(100vh - 80px)'
                    if (videoBoxProfesor.getElementsByTagName('video')[0]) {
                        videoBoxProfesor.getElementsByTagName('video')[0].style.height = 'calc(100vh - 80px)'
                    }

                    e.target.parentNode.parentNode.style.height = '32px'
                }

                setTimeout(function () {
                    if (pinnedStudentsFrame.getElementsByClassName('videoBox').length > 0) {
                        videoBoxProfesor.style.height = 'calc(((100vh / 3) - (80px /3 )) * 2)'
                        pinnedStudentsFrame.style.height = '100%'
                    } else {
                        videoBoxProfesor.style.height = 'calc(100vh - 80px)'
                        pinnedStudentsFrame.style.height = '0%'
                    }
                    that.parentNode.parentNode.style.transform = 'scale(1)'
                    that.parentNode.parentNode.style.width = '100%'
                    if(window.eTar){
                        window.eTar.parentNode.parentNode.style.transform = 'scale(1)'
                        window.eTar.parentNode.parentNode.style.width = '100%'
                    }

                })

            }, 110)
        })


        /*
        this.parentNode.parentNode.parentNode.parentNode.style.height = 'calc((100vh / 3) - (80px /3 ))'
        this.parentNode.parentNode.parentNode.parentNode.style.width = '100%'
        */
        that.dataset.opened = 0
        that2.dataset.pinned = 0

        that2.getElementsByTagName('span')[1].textContent = 'Pin User'
    }


}

function gruopCallClick() {
    if (document.getElementById('gropupCall')) {
        document.getElementById('gropupCall').addEventListener('click', function () {
            let chatWrap = document.getElementsByClassName('chating-wrap-right')[0]

            chatWrap.style.opacity = '1'
            chatWrap.style.bottom = '-77px'

        })
    }

}

function oneToOneCall() {
    if (document.getElementById('oneToOneCall')) {
        document.getElementById('oneToOneCall').addEventListener('click', function () {
            let chatWrap = document.getElementsByClassName('chating-wrap-right')[0]

            chatWrap.style.opacity = '0'
            chatWrap.style.bottom = '-200px'

        })
    }

}


function showParticipant(videoBoxCreated) {
    setTimeout(function () {
        videoBoxCreated.style.opacity = '1'
        videoBoxCreated.style.transform = 'scale(1)'
    }, 350)
}

function changeOrderOfCams() {
    if (call.call_type === CallTypes.ONE_TO_ONE) {

        //click on student frame
        document.getElementsByClassName('talk-top')[0].addEventListener('click', talkTopEvent)

        //click on teachers frame
        document.getElementsByClassName('videoBoxProfesorCont')[0].addEventListener('click', videoBoxProfesorContEvent)

        //prevent camera swiping if social-wrap element is clicked - social-wrap is main call buttons container
        document.getElementsByClassName('social-wrap')[0].addEventListener('click', function (e) {
            e.preventDefault()
            e.stopImmediatePropagation()
            e.stopPropagation
        })

    }
}

function talkTopEvent() {
    let studentMainHelder = document.getElementsByClassName('talk-top')[0]
    let profesorMainCont = document.getElementsByClassName('videoBoxProfesorCont')[0]

    if (studentMainHelder.dataset.swiped === "0") {

        profesorMainCont.classList.add('swipeD')

        studentMainHelder.classList.remove('swipeD')

        studentMainHelder.dataset.swiped = 1
        profesorMainCont.dataset.swiped = 0

    } else if (studentMainHelder.dataset.swiped === "1") {

        profesorMainCont.classList.remove('swipeD')

        studentMainHelder.classList.add('swipeD')

        studentMainHelder.dataset.swiped = 0
        profesorMainCont.dataset.swiped = 1

    }
}

function videoBoxProfesorContEvent() {

    let studentMainHelder = document.getElementsByClassName('talk-top')[0]
    let profesorMainCont = document.getElementsByClassName('videoBoxProfesorCont')[0]

    if (profesorMainCont.dataset.swiped === "0") {

        profesorMainCont.classList.remove('swipeD')
        studentMainHelder.classList.add('swipeD')

        studentMainHelder.dataset.swiped = 0
        profesorMainCont.dataset.swiped = 1

    } else if (profesorMainCont.dataset.swiped === "1") {


        profesorMainCont.classList.add('swipeD')
        studentMainHelder.classList.remove('swipeD')

        studentMainHelder.dataset.swiped = 1
        profesorMainCont.dataset.swiped = 0
    }

}

window.extendCallButtonEvent = function () {

    if (document.getElementsByClassName('extCal')[0]) {
        let extCal = document.getElementsByClassName('extCal')
        for (let i = 0; i < extCal.length; i++) {
            extCal[i].addEventListener('click', function () {
                for (let i = 0; i < extCal.length; i++) {
                    if (extCal[i].classList.contains('hollow')) {
                        extCal[i].classList.toggle('hollow')
                    }

                }

                this.classList.add('hollow')

                window.extendTalkParameters = [
                    this.getElementsByClassName('minutes')[0].textContent.trim(),
                    this.getElementsByClassName('prices')[0].textContent.trim()
                ]


                setCookie("extension_minutes", this.getElementsByClassName('minutes')[0].textContent.trim(), 1 * 60 * 60 * 24 * 30, "/talk/incall")
                setCookie("extension_price", this.getElementsByClassName('prices')[0].textContent.trim(), 1 * 60 * 60 * 24 * 30, "/talk/incall")

                document.getElementById('extendLessonTime').value = this.getElementsByClassName('minutes')[0].textContent.trim()
                document.getElementById('priceHours').value = this.getElementsByClassName('prices')[0].textContent.trim()

                showLoading()

                setTimeout(function () {
                    closePopup('extendCall')
                    //document.getElementById('extendCall').style.display = 'none'
                    let extend_price = parseFloat(document.getElementById('priceHours').value.replace(',', '.'))
                    let extend_call_time = parseFloat(document.getElementById('extendLessonTime').value)
                    let extend_call_price = document.getElementsByClassName('extend_call_price')

                    for (let i = 0; i < extend_call_price.length; i++) {
                        extend_call_price[i].textContent = extend_price
                    }
                    let extend_call_array = document.getElementsByClassName('extend_call_time')
                    for (let i = 0; i < extend_call_array.length; i++) {
                        extend_call_array[i].textContent = extend_call_time
                    }

                    let thatsMe

                    for (let i = 0; i < others.length; i++) {
                        if (others[i].user_id === userObj1.id) {
                            thatsMe = {
                                name: others[i].name_of_user,
                                profile_picture: others[i].user_image
                            }
                        }

                    }

                    // this event is emited by client

                    EXTEND_CALL_REQUEST_Send_Event_Function(call, thatsMe)

                    openPopup('extendAnswerAwait')
                    hideLoading()
                }, 500)


            })
        }
    }
}

function showAnswerPopup(approveText, approveButonsContId) {
    //first we closing "awaiting teacher aproval" popup
    document.getElementById('extendAnswerAwait').getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
    document.getElementById('extendAnswerAwait').style.opacity = '0'

    setTimeout(function () {
        //after 310 mili secconds "awaiting teacher aproval" popup is set on display:none, and closed
        document.getElementById('extendAnswerAwait').style.display = 'none'
        document.getElementById('extendAnswerAwait').dataset.opened = "0"

        // this should be shown to the student only
        // this is answering popup where student will see is the extendion accepted or rejected
        document.getElementById('extendAnswer').style.display = 'block'
        document.getElementById('extendAnswer').dataset.opened = "1"
        document.getElementById('approvedStatus').textContent = approveText

        let answerButtonConts = document.getElementById('answerButtonCont').getElementsByTagName('div')
        for (let i = 0; i < answerButtonConts.length; i++) {
            answerButtonConts[i].classList.remove('dn')
        }

        document.getElementById(approveButonsContId).classList.add('dn')
        document.getElementById('acceptContainerMesage').classList.add('dn')
        setTimeout(function () {
            document.getElementById('extendAnswer').style.opacity = '1'
            document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].style.transform = 'scale(1)'

        })

        setTimeout(function () {

            let elHight = document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].getElementsByTagName('div')[0].offsetHeight + 5

            document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].style.height = elHight + 'px'

            if (document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].getElementsByTagName('div')[0].offsetHeight > (window.innerHeight * 0.85)) {
                document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].style.maxHeight = '90vh'
                document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].style.marginTop = '5vh'
            } else {
                document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].style.maxHeight = '100%'
                document.getElementById('extendAnswer').getElementsByClassName('popuper')[0].style.marginTop = 'calc((100vh - ' + elHight + 'px) / 2)'
            }


        }, 100)

    }, 310)
}

//check zzz
function acceptTalkExtension(e) {
    if (e) {
        //this line is trigering click on the close icon, so close functionalities of the toast notifications are trigered also
        eventFire(e.target.parentNode.parentNode.parentNode.getElementsByClassName('toast-close')[0], 'click');
    }
}

//check zzz
function rejectTalkExtension(e) {
    if (e) {
        //this line is trigering click on the close icon, so close functionalities of the toast notifications are trigered also
        eventFire(e.target.parentNode.parentNode.parentNode.getElementsByClassName('toast-close')[0], 'click');
    }
}

//this is function for simulating events on html elements
//we using this function to trigger click on close icon on toastify notifications.
//i didnt find in toastify documentation where is triggering of close event function, so i added this eventFire function to triger click on close icon


let stringNumber = 0
let stringNumberHelper = ''
let stringNumberHelper2 = ''

function groupTalkExtendRequest(data) {

    //helpers for unique css selectors

    stringNumber++
    stringNumberHelper2 = 'actButton' + (stringNumber + 1)
    stringNumberHelper = 'actButton' + stringNumber

    //notification first thing that teacher see if it is group talk

    Toastify({
        text: '<div class="fr toastContMain"><div class="lefter"><img src="'+data.client_profile_picture+'" class="toastify-avatar"><p class="fl cw p0m0 cc1"> '+ data.client_name +' wants to extend <b>Talk</b> </p><h5 class="fl cw p0m0"> ' + data.message + 'm - ' + data.extension_price + '€ </h5></div><div class="righter"><button class="green cw but1 ' + stringNumberHelper + '" > '+ getPoTranslate('ACCEPT') +' </button><button class="button red cw but2 ' + stringNumberHelper2 + '"> '+ getPoTranslate('REJECT') +' </button></div></div>',
        className: "notification",
        gravity: "top",
        selector: "toastifyContForGroupTalk",
        position: "right",
        close: true,
        duration: -1,
        stopOnFocus: true,
        escapeMarkup: false,
        //avatar: "/frontend/assets/img/user-img.png",
        offset: {
            x: 15,
            y: 102
        }

    }).showToast();

    //after noticiation is added unique css selectors to the buttons

    setTimeout(function () {
        //adding event functions to the accept button
        document.getElementsByClassName(stringNumberHelper)[0].addEventListener('click', acceptTalkExtension)
        document.getElementsByClassName(stringNumberHelper)[0].addEventListener('click', sendAccept)

        function sendAccept() {
            document.getElementsByClassName(stringNumberHelper)[0].removeEventListener('click', sendAccept)

            EXTEND_CALL_ACCEPT_Send_Event_Function(call,data)
        }
        //adding event functions to the reject button
        document.getElementsByClassName(stringNumberHelper2)[0].addEventListener('click', rejectTalkExtension)
        document.getElementsByClassName(stringNumberHelper2)[0].addEventListener('click', sendReject)

        function sendReject() {
            document.getElementsByClassName(stringNumberHelper2)[0].removeEventListener('click', sendReject)
            EXTEND_CALL_REJECT_Send_Event_Function(call,data)
        }
    })

}



//this function is for private talk
//on private talk teacher will recieve popupnpm
//after teacher click accept or reject than:
// 1. teachers popup will be hidden from teachers screen
// 2. on users screen we need first to hide "awaiting answer popup"
// 3. after hiding "awaiting answer popup" we will show answer to user



function acceptTalkExtensionTeacher() {
    closePopup('extendTeacherAnswer')
    //this function is hiding users "awaiting answer" popup and showing accept "answer from teacher" popup
    setTimeout(function () {
        acceptTalkExtension()
    }, 310)

}

function rejectTalkExtensionTeacher() {
    // next function should only happend on the teachers screen
    // first we close popup from teacher screen
    closePopup('extendTeacherAnswer')
    // next function should only happend on the student screen
    // this function is hiding users "awaiting answer" popup and showing reject "answer from teacher" popup
    setTimeout(function () {
        rejectTalkExtension()
    }, 310)
}

function showNoAccessLabel(anonTalkPointer = false, call = false) {

    call === false ? JSON.parse(window.localStorage.getItem('call')) : call
    let webCamAllowed = document.getElementById('webCamAllowed').textContent
    let microphoneAllowed = document.getElementById('microphoneAllowed').textContent

    if(call.talk_type === 1 || call.talk_type === 2 && anonTalkPointer === true){
        if (microphoneAllowed !== '1') {

            if (microphoneAllowed !== '1') {
                document.getElementById('microphoneNotAllowed').textContent = 'microphone'
            }

            document.getElementsByClassName('noCamAndMicAccess')[0].classList.remove('dn')

        } else if (microphoneAllowed == '1') {
            document.getElementsByClassName('noCamAndMicAccess')[0].classList.add('dn')
        }
    }else if(call.talk_type === 2){


        if (webCamAllowed !== '1' || microphoneAllowed !== '1') {
            if (webCamAllowed !== '1') {
                document.getElementById('cammeraNotAllowed').textContent = 'camera'

            }
            if (microphoneAllowed !== '1') {
                if (webCamAllowed !== '1') {
                    document.getElementById('cammeraNotAllowed').textContent = 'camera'
                    document.getElementById('microphoneNotAllowed').textContent = '& microphone'
                } else {
                    document.getElementById('microphoneNotAllowed').textContent = 'microphone'
                }
            }

            document.getElementsByClassName('noCamAndMicAccess')[0].classList.remove('dn')

        } else if (webCamAllowed == '1' && microphoneAllowed == '1') {
            document.getElementsByClassName('noCamAndMicAccess')[0].classList.add('dn')
        }
    }


}


function setAccesCameraMic(audioPointer) {
    let webCamAllowed = document.getElementById('webCamAllowed').textContent
    let microphoneAllowed = document.getElementById('microphoneAllowed').textContent
    if (webCamAllowed === "1") {
        document.getElementById('allowCamMainCont').getElementsByClassName('csic')[0].classList.add('dn')
        document.getElementById('allowCamMainCont').getElementsByClassName('csic')[1].classList.remove('dn')
    }
    if (microphoneAllowed === "1") {
        document.getElementById('allowMicMainCont').getElementsByClassName('csic')[0].classList.add('dn')
        document.getElementById('allowMicMainCont').getElementsByClassName('csic')[1].classList.remove('dn')
    }
    if (webCamAllowed === "2") {
        document.getElementById('webcammsg').textContent = 'Enable web cam from browser settings and refresh to allow access'
        if (document.getElementById('accessCamera')) {
            document.getElementById('accessCamera').remove()
        }
    }
    if (microphoneAllowed === "2") {
        document.getElementById('micmsg').textContent = 'Enable microphone from browser settings and refresh to allow access'
        if (document.getElementById('allowMic')) {
            document.getElementById('allowMic').remove()
        }
    }
    showNoAccessLabel(audioPointer, call)
}

// helper function for conecting participant videoBox with participant element inside of participants list
function findParticipantToMute(x, y, z) {
    let participants
    y === 1 ? participants = document.getElementsByClassName('chating-wrap-right')[0]?.getElementsByClassName('chating-box-inner') :
        participants = document.getElementsByClassName('noPinnedStudentsFrame')[0].getElementsByClassName('videoBox')
    for (let i = 0; i < participants.length; i++) {
        if (participants[i].dataset.id === x) {
            let participantsLi = participants[i].getElementsByTagName('li')
            for (let i = 0; i < participantsLi.length; i++) {
                if (z === 1) {
                    if (participantsLi[i].dataset.muted) {
                        participantsLi[i].dataset.muted = "1"
                        participantsLi[i].innerHTML = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.66667 5.49181L0.754181 1.57933L1.57914 0.75437L13.2458 12.421L12.4208 13.246L9.86161 10.6868C9.21614 11.1885 8.43541 11.5245 7.58333 11.6307V12.2502H9.33333V13.4168H4.66667V12.2502H6.41667V11.6307C4.11465 11.3437 2.33333 9.37994 2.33333 7.00016V5.8335H3.5V7.00016C3.5 8.93316 5.067 10.5002 7 10.5002C7.75589 10.5002 8.45582 10.2605 9.02796 9.85311L8.1853 9.01044C7.83792 9.21571 7.43272 9.3335 7 9.3335C5.71134 9.3335 4.66667 8.28883 4.66667 7.00016V5.49181ZM7.30217 8.12732C7.20579 8.15309 7.1045 8.16683 7 8.16683C6.35567 8.16683 5.83333 7.64449 5.83333 7.00016V6.65848L7.30217 8.12732ZM8.16667 2.91683V5.70853L9.33333 6.8752V2.91683C9.33333 1.62817 8.28866 0.583496 7 0.583496C5.92743 0.583496 5.0239 1.30717 4.75102 2.29289L5.83333 3.3752V2.91683C5.83333 2.2725 6.35567 1.75016 7 1.75016C7.64433 1.75016 8.16667 2.2725 8.16667 2.91683ZM11.2924 8.83429L10.3779 7.9198C10.4575 7.62675 10.5 7.31841 10.5 7.00016V5.8335H11.6667V7.00016C11.6667 7.65129 11.5333 8.27128 11.2924 8.83429Z" fill="#172B4D"></path></svg></span> <span> Unmute User</span>'
                    }
                } else {
                    if (participantsLi[i].dataset.video) {
                        participantsLi[i].dataset.video = "0"
                        participantsLi[i].innerHTML = '<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.995811 0.170898L0.170853 0.995856L2.09169 2.91669H1.75C1.10567 2.91669 0.583338 3.43903 0.583338 4.08336V9.91669C0.583338 10.561 1.10567 11.0834 1.75 11.0834H8.75C9.15958 11.0834 9.51986 10.8723 9.72802 10.553L13.0042 13.8292L13.8291 13.0042L0.995811 0.170898ZM8.75 9.57501L3.25835 4.08336H1.75V9.91669H8.75V9.57501ZM9.91667 4.8895L13.4167 3.1395V10.7159L12.25 9.54925V5.02721L9.91667 6.19388V7.58382L8.75001 6.41715V4.08336H6.41622L5.24955 2.91669H8.75001C9.39434 2.91669 9.91667 3.43903 9.91667 4.08336V4.8895Z" fill="#172B4D"></path></svg></span> <span>Turn on Video</span>'
                    }
                }
            }
        }
    }
}


function showHideStudents(callType) {

    if (callType === 1) {

    } else {
        if (document.getElementsByClassName('noPinnedStudentsFrame')[0].getElementsByClassName('videoBox').length === 0) {
            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-8')
            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-12')
            document.getElementById('viewUsTab').style.left = '-300px'

        }
        if (document.getElementsByClassName('pinnedStudentsFrame')[0].getElementsByClassName('videoBox').length === 0) {
            document.getElementsByClassName('pinnedStudentsFrame')[0].style.height = '0%'
            document.getElementsByClassName('videoBoxProfesor')[0].style.height = ''
        }
    }
}



function getCancelationReasonsFunction(booking_id) {

    if (document.getElementsByClassName('hangup')[0]) {
        if (typeof document.getElementsByClassName('hangup')[0].dataset.eventadded === 'undefined') {
            document.getElementsByClassName('hangup')[0].dataset.eventadded = 1
            document.getElementsByClassName('hangup')[0].addEventListener('click', function () {

                document.getElementById('cancelAppointment').getElementsByClassName('cancelationReasonsVideoTalk')[0].innerHTML = ''
                showLoading()

                getCancelationReasons()

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

                                let cancelationReasons = document.getElementsByClassName('cancelationReasonsVideoTalk')[0]
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

                                calculatePopUpHeight(document.getElementById('cancelAppointment'))
                                openPopup('cancelAppointment')
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



            })
        }

    }
}




function drawProgress(timeGone, totalLesonTime) {

    let step = (2 * timeGone) / totalLesonTime

    let c = document.getElementById("progresTalkChanvas")
    let ctx = c.getContext("2d")

    ctx.clearRect(0, 0, c.width, c.height)

    ctx.strokeStyle = 'white'
    ctx.beginPath();
    ctx.lineCap = 'round';
    ctx.arc(28.5, 28.5, 18.89, 1.5 * Math.PI, (1.5 + step) * Math.PI)

    ctx.lineWidth = 4;

    ctx.stroke();


}



function hideStuffOnEndCall() {
    if (document.getElementsByClassName("social-wrap")[0]) {
        document.getElementsByClassName("social-wrap")[0].classList.add('dn')
    }

    document.getElementsByClassName("top-bar-right")[0].innerHTML = getPoTranslate('TALK_END')
    document.getElementsByClassName("video-conference-page")[0].classList.add('dn')

    window.Echo.disconnect()

}

function getParticipantVideoFrame(id) {
    let videoBox = document.getElementsByClassName('videoBox')

    for (let i = 0; i < videoBox.length; i++) {

        if (videoBox[i].dataset.id == id) {

            return videoBox[i]
        }

    }
}

function showHideParticipants() {

    if (callType === "2") {
        if (document.getElementsByClassName('viewProfesor')[0]) {
            document.getElementsByClassName('viewProfesor')[0].addEventListener('click', function () {


                if (call.user_type != UserTypes.PROVIDER) {

                    let videoBox = document.getElementById('rowOne').getElementsByClassName('videoBox')[0]
                    let talkTop = document.getElementById('privateTalkStudentHelder')

                    document.getElementsByClassName('talk-top')[0].style.display = 'block'
                    talkTop.insertBefore(videoBox, talkTop.firstChild)

                    document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-8')
                    document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-12')

                    document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.remove('small-8')
                    document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.add('small-12')

                    /* document.getElementsByClassName('small-4')[0].style.right = '-400px'
                    document.getElementsByClassName('small-4')[0].style.position = 'absolute' */
                    document.getElementsByClassName('videoBoxProfesorCont')[0].style.background = 'transparent'
                    //click on student frame
                    document.getElementsByClassName('talk-top')[0].addEventListener('click', talkTopEvent)


                    //click on teachers frame
                    document.getElementsByClassName('videoBoxProfesorCont')[0].addEventListener('click', videoBoxProfesorContEvent)
                    document.getElementsByClassName('talk-top')[0].classList.add('swipeD')

                } else {
                    document.getElementsByClassName('videoBoxProfesorCont')[0].style.background = '#172b4d'
                    document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-8')
                    document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-12')

                    document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.remove('small-8')
                    document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.add('small-12')


                    document.getElementsByClassName('small-4')[0].style.position = 'absolute'
                    document.getElementsByClassName('small-4')[0].style.right = '-400px'
                }

                this.classList.add('is-active')
                document.getElementsByClassName('viewStudents')[0].classList.remove('is-active')
            })
        }

        if (document.getElementsByClassName('viewStudents')[0]) {
            document.getElementsByClassName('viewStudents')[0].addEventListener('click', function (e) {

                if (document.getElementsByClassName('small-4')[0].getElementsByClassName('videoBox').length < 1) {
                    e.preventDefault()

                    if (document.getElementsByClassName('talk-top')[0].getElementsByClassName('videoBox')[0]) {

                        document.getElementsByClassName('viewProfesor')[0].classList.remove('is-active')
                        document.getElementsByClassName('viewStudents')[0].classList.add('is-active')
                        let videoBox = document.getElementById('rowOne')
                        let talkTop = document.getElementsByClassName('talk-top')[0].getElementsByClassName('videoBox')[0]
                        document.getElementsByClassName('talk-top')[0].style.display = 'none'

                        //rearange function
                        videoBox.insertBefore(talkTop, videoBox.firstChild)

                        document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-12')
                        document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-8')

                        document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.remove('small-12')
                        document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.add('small-8')


                        document.getElementsByClassName('small-4')[0].style.position = 'absolute'
                        document.getElementsByClassName('small-4')[0].style.right = '0px'
                        //click on student frame
                        document.getElementsByClassName('talk-top')[0].removeEventListener('click', talkTopEvent)

                        document.getElementsByClassName('videoBoxProfesorCont')[0].style.background = '#172b4d'
                        //click on teachers frame
                        document.getElementsByClassName('videoBoxProfesorCont')[0].removeEventListener('click', videoBoxProfesorContEvent)

                        document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('swipeD')


                    } else {
                        Toastify({
                            text: '<div class="fr toastContMain"><p>Not possible2</p></div>',
                            className: "notification",
                            gravity: "left",
                            selector: "toastifyContForGroupTalk",
                            position: "left",
                            close: true,
                            duration: 3000,
                            escapeMarkup: false
                        }).showToast();
                    }
                } else {


                    if (call.user_type == UserTypes.CLIENT) {
                        if (document.getElementsByClassName('small-4')[0].getElementsByClassName('videoBox')[0]) {
                            let videoBox = document.getElementById('rowOne')
                            let talkTop = document.getElementsByClassName('small-4')[0].getElementsByClassName('videoBox')[0]
                            document.getElementsByClassName('talk-top')[0].style.display = 'none'

                            //rearange function
                            videoBox.insertBefore(talkTop, videoBox.firstChild)

                            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-12')
                            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-8')

                            document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.remove('small-12')
                            document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.add('small-8')


                            document.getElementsByClassName('small-4')[0].style.position = 'absolute'
                            document.getElementsByClassName('small-4')[0].style.right = '0px'

                            //click on student frame
                            document.getElementsByClassName('talk-top')[0].removeEventListener('click', talkTopEvent)

                            document.getElementsByClassName('videoBoxProfesorCont')[0].style.background = '#172b4d'

                            //click on teachers frame
                            document.getElementsByClassName('videoBoxProfesorCont')[0].removeEventListener('click', videoBoxProfesorContEvent)

                            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('swipeD')
                        } else {

                            Toastify({
                                text: '<div class="fr toastContMain"><p>Not possible1</p></div>',
                                className: "notification",
                                gravity: "left",
                                selector: "toastifyContForGroupTalk",
                                position: "left",
                                close: true,
                                duration: 3000,
                                escapeMarkup: false
                            }).showToast();

                        }


                    } else if (call.user_type == UserTypes.PROVIDER) {

                        if (document.getElementsByClassName('small-4')[0].getElementsByClassName('videoBox').length < 1) {

                        } else {
                            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.remove('small-12')
                            document.getElementsByClassName('videoBoxProfesorCont')[0].classList.add('small-8')

                            document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.remove('small-12')
                            document.getElementsByClassName('videoBoxProfesorCont')[0].parentElement.classList.add('small-8')

                            document.getElementsByClassName('videoBoxProfesorCont')[0].style.background = 'transparent'

                            document.getElementsByClassName('small-4')[0].style.position = 'absolute'
                            document.getElementsByClassName('small-4')[0].style.right = '0px'
                        }
                    }

                    this.classList.add('is-active')
                    document.getElementsByClassName('viewProfesor')[0].classList.remove('is-active')
                }

            })
        }
    }
}

(function () {

    if (document.getElementsByClassName('showMobileSettingsPanel')[0]) {
        document.getElementsByClassName('showMobileSettingsPanel')[0].addEventListener('click', function () {
            if (window.innerWidth < 768) {
                if (this.dataset.opened === "0") {
                    if (document.getElementsByClassName('showPartClick')[0].dataset.opened === "1") {
                        document.getElementsByClassName('video-cta')[0].style.bottom = '77px'
                        /* document.getElementsByClassName('chating-wrap-right')[0].style.bottom = '0px' */
                    }
                    document.getElementsByClassName('lMobile')[0].style.left = '8px'
                    this.dataset.opened = 1
                } else {
                    document.getElementsByClassName('video-cta')[0].style.bottom = '0px'
                    document.getElementsByClassName('chating-wrap-right')[0].style.bottom = '-77px'
                    eventFire(document.getElementsByClassName('hideParticipants')[0], 'click')
                    document.getElementsByClassName('lMobile')[0].style.left = '-70px'
                    this.dataset.opened = 0
                }
            } else if (window.innerWidth > 767) {
                if (this.dataset.opened === "0") {
                    /* document.getElementsByClassName('chating-wrap-right')[0].style.bottom = '0px' */
                    this.dataset.opened = 1
                } else {
                    document.getElementsByClassName('chating-wrap-right')[0].style.bottom = '-77px'
                    eventFire(document.getElementsByClassName('hideParticipants')[0], 'click')
                    this.dataset.opened = 0
                }
            }

        })
    }


    if (document.getElementsByClassName('closerIngP')[0]) {
        document.getElementsByClassName('closerIngP')[0].addEventListener('click', function () {
            closePopup('paymentWalletPopUp')
            setTimeout(function () {
                eventFire(document.getElementById('extendLessonDuration'), 'click')
            }, 100)
        })
    }

    showHideParticipants()

    if(document.getElementById('showParticipantsOptions')){
        let showParticipantsOptions = document.getElementById('showParticipantsOptions')
        let hideParticipants = document.getElementsByClassName('hideParticipants')[0]

        hideParticipants.addEventListener('click',function(){
            showHideHelper()
        })

        showParticipantsOptions.addEventListener('click', function(){
            showHideHelper()
        })

        function showHideHelper(){
            if(showParticipantsOptions.dataset.opened === "0"){
                document.getElementById('chat-tabs1').classList.remove('dn')
                showParticipantsOptions.dataset.opened = 1
                hideParticipants.dataset.opened = 1
            }else if(showParticipantsOptions.dataset.opened === "1"){
                document.getElementById('chat-tabs1').classList.add('dn')
                showParticipantsOptions.dataset.opened = 0
                hideParticipants.dataset.opened = 0
            }
        }

    }

    if (document.getElementsByClassName('showPartClick')[0]) {
        document.getElementsByClassName('showPartClick')[0].addEventListener('click', function () {
            if (this.dataset.opened === "0") {
                document.getElementsByClassName('video-cta')[0].style.bottom = '77px'
                document.getElementsByClassName('chating-wrap-right')[0].style.bottom = '0px'

                this.dataset.opened = 1
            } else {
                document.getElementsByClassName('video-cta')[0].style.bottom = '0px'
                document.getElementsByClassName('chating-wrap-right')[0].style.bottom = '-77px'
                eventFire(document.getElementsByClassName('hideParticipants')[0], 'click')
                this.dataset.opened = 0
            }

        })
    }

    showNoAccessLabel(false, typeof call === 'undefined' ? false : call)

    // addTeacherAcceptAndRejectEvents()
    //adding send event to teacher event
    //this function is taking values from first step of "extend this talk"
    extendCallButtonEvent()
    //this function is cancel for the first stepp of "extend this talk"
    //this function canceling last chosing, and setting extend call button to disabled

})()
