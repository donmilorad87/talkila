export function cookieButtons() {



    document.getElementById('cookieAllowAll').addEventListener('click', function () {

        document.getElementById('cookieMainCont').classList.add('accepted')
        document.getElementsByClassName('acceptedCookieContainer')[0].classList.add('accepted')


        createHelpCookieObject()

        setCookie("allow_cookies", getCookie('helpCookieObject'), 1 * 60 * 60 * 24 * 365, "/")

    })



    if (document.getElementById('acceptedCookieClosed')) {
        document.getElementById('acceptedCookieClosed').addEventListener('click', function () {
            if (document.getElementById('acceptedCookieClosed').classList.contains('accepted')) {
                document.getElementById('acceptedCookieClosed').classList.remove('accepted')

            }
            if (document.getElementById('cookieMainCont').classList.contains('accepted')) {
                document.getElementById('cookieMainCont').classList.remove('accepted')
            }
        })

    }

    //sett states by default
    if (getCookie('helpCookieObject') !== '') {

        let cookieObject = JSON.parse(getCookie('helpCookieObject'))

        let cookieInputs = document.getElementById('cookieOptions').getElementsByClassName('switch-input')
        for (let i = 0; i < cookieInputs.length; i++) {
            if (cookieObject.hasOwnProperty(cookieInputs[i].name)) {
                cookieInputs[i].checked = cookieObject[cookieInputs[i].name]

                let innerCookieInputs = cookieInputs[i].parentElement.parentElement.getElementsByClassName('switch-input')
                let counterForInnerCookieInputs = 0

                for (let j = 0; j < innerCookieInputs.length; j++) {
                    if (innerCookieInputs[j].checked) {
                        counterForInnerCookieInputs++
                    }

                }

                if (counterForInnerCookieInputs === 0) {

                    let mainCookieInputs = document.getElementsByClassName('mainCookieInput')
                    for (let k = 0; k < mainCookieInputs.length; k++) {

                        if (mainCookieInputs[k].dataset.property === cookieInputs[i].dataset.property) {

                            mainCookieInputs[k].checked = false
                        }
                    }
                }
            }


        }
    }

    function createHelpCookieObject() {
        let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
        let obj = {}
        for (let i = 0; i < cookieSubOptions.length; i++) {
            let cookeCheckedValues = cookieSubOptions[i].getElementsByClassName('switch-input')
            for (let j = 0; j < cookeCheckedValues.length; j++) {

                obj[cookeCheckedValues[j].id] = cookeCheckedValues[j].checked



            }
        }
        setCookie("helpCookieObject", JSON.stringify(obj), 1 * 60 * 2 * 24 * 30, "/")
    }


    if (document.getElementsByClassName('closeAllSuboptions')[0]) {
        let closeAllSuboptions = document.getElementsByClassName('closeAllSuboptions')
        for (let i = 0; i < closeAllSuboptions.length; i++) {
            closeAllSuboptions[i].addEventListener('click', function () {
                let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
                for (let i = 0; i < cookieSubOptions.length; i++) {
                    cookieSubOptions[i].style.left = '-1000px'

                }

                if (this.dataset.button === 'saveButton') {
                    createHelpCookieObject()
                    closePopup('cookieOptions')






                }

                if (document.getElementsByClassName('closeCookie')[0].dataset.opened === '1') {
                    document.getElementsByClassName('closeCookie')[0].dataset.opened = '0'
                } else {
                    closePopup('cookieOptions')
                }
            })

        }
    }






    let mainCookieSwitchChange = document.getElementsByClassName('mainCookieSwitchChange')
    for (let i = 0; i < mainCookieSwitchChange.length; i++) {
        mainCookieSwitchChange[i].addEventListener('click', function () {
            let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
            if (this.checked) {

                for (let i = 0; i < cookieSubOptions.length; i++) {
                    if (cookieSubOptions[i].dataset.property === this.dataset.property) {
                        let checkedInputs = cookieSubOptions[i].getElementsByClassName('switch-input')
                        for (let j = 0; j < checkedInputs.length; j++) {
                            checkedInputs[j].checked = true

                        }
                    }

                }

            } else {
                for (let i = 0; i < cookieSubOptions.length; i++) {
                    if (cookieSubOptions[i].dataset.property === this.dataset.property) {
                        let checkedInputs = cookieSubOptions[i].getElementsByClassName('switch-input')
                        for (let j = 0; j < checkedInputs.length; j++) {
                            checkedInputs[j].checked = false

                        }
                    }

                }
            }


        })

    }






    let selectParentCheckbox = document.getElementsByClassName('selectParentCheckbox')
    for (let i = 0; i < selectParentCheckbox.length; i++) {
        selectParentCheckbox[i].addEventListener('click', function () {
            let checkedInputs = this.parentElement.parentElement.getElementsByClassName('switch-input')
            let counter = 0

            for (let i = 0; i < checkedInputs.length; i++) {
                if (checkedInputs[i].checked) {
                    counter++
                }

            }
            let mainCookieInputs = this.parentElement.parentElement.parentElement.getElementsByClassName('mainCookieInput')

            if (counter === 0) {

                for (let i = 0; i < mainCookieInputs.length; i++) {

                    if (this.dataset.property === mainCookieInputs[i].dataset.property) {
                        mainCookieInputs[i].checked = false
                    }
                }

            } else {
                for (let i = 0; i < mainCookieInputs.length; i++) {

                    if (this.dataset.property === mainCookieInputs[i].dataset.property) {
                        mainCookieInputs[i].checked = true
                    }
                }
            }


        })

    }





    if (document.getElementsByClassName('closeCookieSubOptions')[0]) {
        let closeCookieSubOptions = document.getElementsByClassName('closeCookieSubOptions')
        for (let i = 0; i < closeCookieSubOptions.length; i++) {
            closeCookieSubOptions[i].addEventListener('click', function () {
                this.parentElement.style.left = '-1000px'
                document.getElementsByClassName('closeCookie')[0].dataset.opened = '0'
            })

        }
    }

    if (document.getElementsByClassName('clickLabel')[0]) {
        let clickLabel = document.getElementsByClassName('clickLabel')
        for (let i = 0; i < clickLabel.length; i++) {
            clickLabel[i].addEventListener('click', function () {
                this.parentElement.getElementsByTagName('label')[0].click()
            })

        }
    }
    if (document.getElementsByClassName('cookieSubOptionsOpen')[0]) {
        let cookieSubOptionsOpen = document.getElementsByClassName('cookieSubOptionsOpen')
        for (let i = 0; i < cookieSubOptionsOpen.length; i++) {
            cookieSubOptionsOpen[i].addEventListener('click', function (e) {
                e.stopPropagation()
                let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
                for (let j = 0; j < cookieSubOptions.length; j++) {
                    if (cookieSubOptionsOpen[i].dataset.property === cookieSubOptions[j].dataset.property) {
                        cookieSubOptions[j].style.left = '0px'
                        document.getElementsByClassName('closeCookie')[0].dataset.opened = '1'
                    }

                }


            })

        }
    }


}
