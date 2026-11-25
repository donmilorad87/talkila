function optionButton() {
    let optionButtons = document.getElementsByClassName('optionButton')
    for (let i = 0; i < optionButtons.length; i++) {
        optionButtons[i].addEventListener('click', window.clickOnOptionButton)
        if (optionButtons[i].getElementsByClassName('showCancelAppointment')[0]) {
            optionButtons[i].getElementsByClassName('showCancelAppointment')[0].addEventListener('click', function (e) {
                e.preventDefault()

                let clasNameDetails = this.parentElement.parentElement.parentElement.parentElement.parentElement.dataset.popup.replace(/\D/g, '');

                let popup = this.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('cancelAppointment-' + clasNameDetails)[0]


            })
        }

    }
}

function optionButton2() {
    let optionButtons = document.getElementsByClassName('optionButton')
    for (let i = 0; i < optionButtons.length; i++) {
        optionButtons[i].addEventListener('click', window.clickOnOptionButton)
        if (optionButtons[i].getElementsByClassName('showCancelAppointment')[0]) {
            optionButtons[i].getElementsByClassName('showCancelAppointment')[0].addEventListener('click', function (e) {
                e.preventDefault()

                let clasNameDetails = this.parentElement.parentElement.parentElement.parentElement.parentElement.dataset.popup.replace(/\D/g, '');

                let popup = this.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('cancelAppointment-' + clasNameDetails)[0]


            })
        }

    }
}


window.clickOnOptionButton = function (e) {

    e.stopPropagation()
    if(e.currentTarget.parentElement.parentElement.id === 'participants-box'){

    }else{
        if (document.body.className === 'profile') {

            if (e.currentTarget.dataset.opened === "0") {
                e.currentTarget.getElementsByTagName('ul')[0].style.cssText = 'opacity: 1;height: 100px;display: block;top: 44px;'
                 that =e.currentTarget



                document.addEventListener('keydown', escapeQuit, false)
                e.currentTarget.getElementsByTagName('ul')[0].addEventListener('click', showPopup, false)
                e.currentTarget.dataset.opened = 1

            } else {
                e.currentTarget.getElementsByTagName('ul')[0].style.cssText = 'opacity: 0;height: 0px;display:block;'
                e.currentTarget.dataset.opened = 0
            }

            document.addEventListener('click', checkIfIsInOptionButton2, false)
        } else {
            e.stopPropagation()

            if (e.currentTarget.dataset.opened === "0") {

                closeAllOptions()

                e.currentTarget.getElementsByTagName('ul')[0].style.display = 'block'
                e.currentTarget.dataset.opened = 1

                let that = e.currentTarget
                setTimeout(function () {

                    that.getElementsByTagName('ul')[0].style.top = '40px'
                    that.getElementsByTagName('ul')[0].style.height = 'auto'
                    that.getElementsByTagName('ul')[0].style.opacity = '1'
                })

                window.optionClicked = e.currentTarget.getElementsByTagName('ul')[0]

                document.addEventListener('click', checkIfIsInOptionButton, false)
                document.addEventListener('keydown', escapeQuit, false)
                e.currentTarget.getElementsByTagName('ul')[0].addEventListener('click', showPopup, false)


            } else {
                closeOptionButtons(window.optionClicked)
            }
        }

    }


}

function showPopup(e) {
    e.stopPropagation()
    closeOptionButtons(window.optionClicked)
}

function escapeQuit(e) {
    if (e.key === "Escape") {
        closeOptionButtons(window.optionClicked)
    }
}

function checkIfIsInOptionButton2(event) {
    try {
        let isClickInside = window.optionClicked.contains(event.currentTarget)
        if (!isClickInside && window.optionClicked.parentNode !== event.currentTarget) {
            window.closeOptionButtons(window.optionClicked)
        }
    } catch (error) {

    }

}


function checkIfIsInOptionButton(event) {
    try {
        let isClickInside = window.optionClicked.contains(event.currentTarget)
        if (!isClickInside && window.optionClicked.parentNode !== event.currentTarget) {
            window.closeOptionButtons(window.optionClicked)
        }
    } catch (error) {

    }

}


function checkIfIsInOptionButton2(e){

    let that = document.getElementsByClassName('optionButton')[0]
    if(
        e.currentTarget !== that &&
        e.currentTarget !== that.getElementsByTagName('ul')[0] &&
        e.currentTarget.parentElement !== that.getElementsByTagName('ul')[0]
    ){

        window.closeOptionButtons(that.getElementsByTagName('ul')[0])
        if(document.getElementsByClassName('optionButton')[1]){
            window.closeOptionButtons(document.getElementsByClassName('optionButton')[1].getElementsByTagName('ul')[0])
        }

    }

}
window.closeOptionButtons = function (x = document.getElementsByClassName('optionButton')[0].getElementsByTagName('ul')[0]) {
    if (typeof call !== 'undefined') {
        if (call.call_type === 1) {
            document.getElementsByClassName('oButtonVideoCall')[0].dataset.opened = '0'
        }
    }

    x.style.top = '32px'
    x.style.opacity = '0'
    x.style.height = '0px'
    x.parentNode.dataset.opened = 0

    setTimeout(function () {
        x.style.display = 'none'
    }, 310)

    document.removeEventListener('click', checkIfIsInOptionButton2, false)
    document.removeEventListener('click', checkIfIsInOptionButton, false)
    document.removeEventListener('keydown', escapeQuit, false)

    x.removeEventListener('keydown', showPopup, false)
}

function closeAllOptions() {
    let optionButtons = document.getElementsByClassName('optionButton')
    for (let i = 0; i < optionButtons.length; i++) {
        if (optionButtons[i].dataset.opened === "1") {
            closeOptionButtons(optionButtons[i].getElementsByTagName('ul')[0])
        }
    }
}

function removeEventsFromOptionButtons() {
    let optionButtons = document.getElementsByClassName('optionButton')

    for (let i = 0; i < optionButtons; i++) {
        optionButtons[i].removeEventListener('click', window.clickOnOptionButton)
    }

}
