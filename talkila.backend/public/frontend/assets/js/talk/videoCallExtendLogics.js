let extendThisCallLi = document.getElementById("extendThisCallLi")
let videoCta = document.getElementsByClassName('video-cta')[0]

function startTimer2(){

    const countDownClock = (number = 100, format = 'seconds') => {

        const d = document;

        const minutesElement = d.querySelector('#minutess')
        const secondsElement = d.querySelector('#secondss')
        let countdown
        convertFormat(format)


        function convertFormat(format) {
          switch(format) {
            case 'seconds':
              return timer(number);
            case 'minutes':
              return timer(number * 60);
          }
        }

        function timer(seconds) {
          const now = Date.now();
          const then = now + seconds * 1000;

          countdown = setInterval(() => {
            const secondsLeft = Math.round((then - Date.now()) / 1000);

            if(secondsLeft <= 0) {
              clearInterval(countdown)
              closePopup('extendCall')
              return
            }

            displayTimeLeft(secondsLeft)

          },1000)
        }

        function displayTimeLeft(seconds) {
          minutesElement.textContent = Math.floor((seconds % 86400) % 3600 / 60)
          secondsElement.textContent = seconds % 60 < 10 ? `0${seconds % 60}` : seconds % 60
        }
      }


      countDownClock(3, 'minutes');
}

function startTimer(){

    let d = new Date()

    function addMinutes(date, minutes) {
        return new Date(date.getTime() + minutes*60000);
    }

    let dd = addMinutes(d,3)

    const finaleDate = dd.getTime();

    const timer = () =>{
        const now = new Date().getTime()
        let diff = finaleDate - now;
        // Showing the alert when the counter time finishes.
        if(diff < 0){
            document.querySelector('.alert').style.display = 'block'
            document.querySelector('.container').style.display = 'none'
        }

        let minutes = Math.floor(diff % (1000*60*60)/ (1000*60))
        let seconds = Math.floor(diff % (1000*60) / 1000)
    // Adding the zeros.

        minutes <= 9 ? minutes = `0${minutes}` : minutes
        seconds <= 9 ? seconds = `0${seconds}` : seconds;

        document.querySelector('#minutess').textContent = minutes
        document.querySelector('#secondss').textContent = seconds

    }
    timer()
    // Calling the function every 1000 milliseconds.
    setInterval(timer,1000)
}

function extendCallLogicsStudent(call) {
    extendThisCallLi.classList.remove('dn')
    document.getElementById('extendMobile').parentElement.classList.remove('dn')
/*     extendCallHelper(timeLeft, extendThisCallLi, videoCta) */

    // Extension request starts here
  /*   document.getElementById('extendLesson').addEventListener('click', function () {
        closePopup('extendCall')

        let extend_price = parseFloat(document.getElementById('priceHours').value)
        let extend_call_time = parseFloat(document.getElementById('extendLessonTime').value)
        let extend_call_price = document.getElementsByClassName('extend_call_price')

        for (let i = 0; i < extend_call_price.length; i++) {
            extend_call_price[i].textContent = extend_price
        }
        let extend_call_array = document.getElementsByClassName('extend_call_time')
        for (let i = 0; i < extend_call_array.length; i++) {
            extend_call_array[i].textContent = extend_call_time
        }

        // this event is emited by client
        EXTEND_CALL_REQUEST_Send_Event_Function(call, userObj1)
    }) */

    // extension rejection here
    ExtensionRejected_Socket_Listen_Function(call)

    // extension accepted here needs payment now
    ExtensionAccepted_Socket_Listen_Function(call)
}

function extendCallLogicsProfesor(call) {

    // removing extendCall button from the proffesor side od video talk
    extendThisCallLi.parentElement.removeChild(extendThisCallLi)

    // deals with extension request for provider
    ExtensionRequest_Socket_Listen_Function(call)
}

function addTeacherAcceptAndRejectEvents() {
    if (document.getElementsByClassName('extendAnswerTrue')[0] && document.getElementsByClassName('extendAnswerFalse')[0]) {
        //adding event functions to the accept button on private talk popup
        document.getElementsByClassName('extendAnswerTrue')[0].addEventListener('click', acceptTalkExtensionTeacher)
        document.getElementsByClassName('extendAnswerTrue')[0].addEventListener('click', sendAccept)

        function sendAccept() {
            document.getElementsByClassName('extendAnswerTrue')[0].removeEventListener('click', sendAccept)

            EXTEND_CALL_ACCEPT_Send_Event_Function(call)
        }
        //adding event functions to the reject button on private talk popup
        document.getElementsByClassName('extendAnswerFalse')[0].addEventListener('click', rejectTalkExtensionTeacher)
        document.getElementsByClassName('extendAnswerFalse')[0].addEventListener('click', sendReject)

        function sendReject() {
            document.getElementsByClassName('extendAnswerFalse')[0].removeEventListener('click', sendReject)
            EXTEND_CALL_REJECT_Send_Event_Function(call)
        }
    }
}
