let nameStatus = {}

window.usernameStatus = {
    isOk: true
}

let partnerId = document.querySelector("meta[name='partner_id']")


let nameValue
let usernameValue
let arrere

let formData = {}
let formStatus = {}



function initJtc2Step1Validators() {
    if (document.getElementById("jtc2Step1Form")) {

        let nameInput = document.getElementsByClassName("name-input")
        let usernameInput = document.getElementById('desktopUsername')

        let countLabel = document.getElementsByClassName("count-label")

        let nameWarn = document.getElementsByClassName("name-warn")
        let usernameWarn = document.getElementsByClassName("username-warn")

        let nameSvg = document.getElementsByClassName("verified-name-svg")
        let usernameSvg = document.getElementsByClassName("verified-username-svg")

        let usernamePreview = document.getElementsByClassName("username-preview")

        let step1name = document.getElementsByClassName("step1name")
        let step1username = document.getElementsByClassName("step1username")

        let submitButton = document.getElementsByClassName("submit-button")
        let debounceTimer



        function inputSuggested(e) {

            usernameInput.value = this.textContent.trim()
            document.getElementById('spanUsername').textContent = this.textContent.trim()

            inputSuggestedHelper(true, e.currentTarget)


        }
        window.inputSuggestedHelper = function (pointer, element = false) {

            if (document.getElementById('suggestedUsernames')) {
                document.getElementById('suggestedUsernames').getElementsByClassName('dn')[0]?.classList.remove('dn')
            }
            if (pointer) {
                usernameInput.classList.add('ok')
                usernameInput.classList.remove('error')
                usernameInput.parentElement.getElementsByClassName('clear-button')[0].style.right = "42px"
                usernameInput.parentElement.getElementsByClassName('input-label')[0].style.color = 'rgb(29, 41, 63)'
                usernameInput.parentElement.getElementsByClassName('verified-username-svg')[0].classList.add('active')
                usernameInput.parentElement.getElementsByClassName('username-warn')[0].classList.remove('active')
                if (element) {
                    element.classList.add('dn')

                }
                if (document.getElementById('suggestedUsernamesMesage')?.parentElement) {
                    document.getElementById('suggestedUsernamesMesage').parentElement.classList.add('dn')
                }

                usernameInput.style.color = 'rgb(29, 41, 63)'


            } else {
                usernameInput.classList.remove('ok')
                usernameInput.classList.add('error')
                usernameInput.parentElement.getElementsByClassName('clear-button')[0].style.right = "16px"
                usernameInput.parentElement.getElementsByClassName('input-label')[0].style.color = 'rgb(253, 42, 24)'
                usernameInput.parentElement.getElementsByClassName('verified-username-svg')[0].classList.remove('active')
                usernameInput.parentElement.getElementsByClassName('username-warn')[0].classList.add('active')

                if (element) {
                    element.classList.add('dn')
                }

                if (document.getElementById('suggestedUsernamesMesage')?.parentElement) {
                    document.getElementById('suggestedUsernamesMesage').parentElement.classList.remove('dn')
                }
                usernameInput.style.color = 'rgb(253, 42, 24)'
            }

        }

        if (document.getElementsByClassName('suggestedUsernameInput')[0]) {
            let elements = document.getElementsByClassName('suggestedUsernameInput')
            for (let i = 0; i < elements.length; i++) {
                elements[i].addEventListener('click', inputSuggested)

            }
        }


        const updateDebounceValue = (array) => {

            usernameCheck(arrere[0], arrere[1])

        }

        const debounce = (callback, time) => {

            clearTimeout(debounceTimer)

            debounceTimer = setTimeout(callback, time)
        }


        if (loggedIn) {
            try {
                let name = document.getElementById('fullNameS')
                name.addEventListener("input", nameHandler)


            } catch (error) {

            }
        }


        function nameHandler() {

            let name = document.getElementById('fullNameS')

            nameValue = name.value


            let check = nameCheck(nameValue)
            nameStatus = check

            if (check.isOk) {
                name.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'


                countLabelDriver({
                    el: name,
                    min: 2,
                    max: 100
                })


                for (let i = 0; i < nameInput.length; i++) {
                    nameInput[i].classList.remove("error")
                    nameInput[i].classList.add("ok")
                }

                for (let i = 0; i < nameSvg.length; i++) {
                    nameSvg[i].classList.add("active")
                }

                for (let i = 0; i < nameWarn.length; i++) {
                    nameWarn[i].classList.remove("active")
                }




            } else {
                name.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'


                countLabelDriver({
                    el: name,
                    min: 2,
                    max: 100
                })


                for (let i = 0; i < nameInput.length; i++) {
                    nameInput[i].classList.add("error")
                    nameInput[i].classList.remove("ok")
                }

                for (let i = 0; i < nameSvg.length; i++) {
                    nameSvg[i].classList.remove("active")
                }


                for (let i = 0; i < nameWarn.length; i++) {

                    nameWarn[i].classList.add("active")

                    nameWarn[i].innerHTML = "&nbsp"


                    nameWarn[i].innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {
                        'minimum_characters': '2',
                        'maximum_characters': '100'
                    }) + "," : ""

                    nameWarn[i].textContent = removeCommaFromValidationWarning(nameWarn[i].textContent)

                }
            }
        }


        document.getElementById('desktopUsername').addEventListener("input", usernameHandler)

        function usernameHandler() {


            if (usernameInput.value.indexOf(" ") >= 0) {
                usernameInput.value = usernameInput.value.trim()
            }
            if (usernameInput.value.indexOf("_") === 0) {
                usernameInput.value = ""
            }
            usernameValue = usernameInput.value

            arrere = [usernameValue, document.getElementById('desktopUsername')]

            document.getElementById('desktopUsername').textContent = usernameValue + ', '
            debounce(updateDebounceValue, 500)


        }

        let jtc2Step1Form = document.getElementById("jtc2Step1Form").elements

        document.getElementById("submitCreateProfileJtc2").addEventListener("click", handleSubmit)


        if (!loggedIn) {

            let emailInput = jtc2Step1Form["emails"]

            emailInput.addEventListener("input", emailHandler)

            function emailHandler() {
                let check = emailCheck(emailInput.value)
                let emailWarn = emailInput.parentElement.getElementsByClassName('email-warn')[0]
                let emailSvg = emailInput.parentElement.getElementsByClassName('verified-email-svg')[0]
                let inputLabel = emailInput.parentElement.getElementsByClassName('input-label')[0]
                emailStatus = check
                if (check.isOk) {
                    window.emailer = true
                    emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                    emailInput.classList.remove("error")
                    emailInput.classList.add("ok")
                    emailSvg.classList.add("active")
                    emailWarn.classList.remove("active")
                    inputLabel.style.color = 'rgb(29, 41, 63)'


                } else {
                    window.emailer = false
                    emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                    emailInput.classList.add("error")
                    emailInput.classList.remove("ok")
                    emailSvg.classList.remove("active")
                    emailWarn.classList.add("active")
                    inputLabel.style.color = 'rgb(253, 42, 24)'
                }
            }
        }





        if (!loggedIn) {

            let passwordInput = jtc2Step1Form["password"]
            passwordInput.addEventListener("input", passwordHandler)

            function passwordHandler() {

                let passwordValidationFields = passwordInput.parentElement.getElementsByClassName('validationFields')[0]

                let passwordSvg = passwordInput.parentElement.getElementsByClassName("verified-password-svg")[0]
                let passwordWarn = passwordInput.parentElement.getElementsByClassName("password-warn")[0]


                countLabelDriver({
                    el: passwordInput,
                    min: 8,
                    max: 50
                })
                let check = passwordCheck(passwordInput.value)


                passwordStatus = check

                if (check.isOk) {
                    passwordInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                    passwordInput.classList.remove("error")
                    passwordInput.classList.add("ok")
                    passwordSvg.classList.add("active")
                    passwordWarn.classList.remove("active")
                    passwordValidationFields.style.maxHeight = '0px'
                    window.passer = true
                } else {
                    window.passer = false
                    passwordValidationFields.innerHTML = ''
                    passwordValidationFields.style.maxHeight = '100px'
                    passwordInput.parentElement.getElementsByClassName('input-label')[0].style.color = 'rgb(253, 42, 24)'
                    passwordInput.classList.add("error")
                    passwordInput.classList.remove("ok")
                    passwordSvg.classList.remove("active")
                    passwordWarn.classList.add("active")

                    for (let i = 0; i < Object.keys(check).length; i++) {
                        if (Object.keys(check)[i] === 'isOk') {

                        } else {
                            if (Object.values(check)[i].isOk) {

                                createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'green', check, i)

                            } else {

                                createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'red', check, i)

                            }
                        }

                    }

                }



                passwordWarn.textContent = removeCommaFromValidationWarning(passwordWarn.textContent)

            }


        }




        let addBio = jtc2Step1Form["addBio"]

        addBio.addEventListener("input", descriptionPHandler)


        function descriptionPHandler() {

            let params = {
                el: addBio,
                type: "input",
                min: 1,
                max: 1000,
                svg: true,
                warn: true,
                msg: false
            }
            formStatus["addBio"] = inputDriver(params)
            formData["addBio"] = addBio.value.trim()
            countLabelDriver({
                el: addBio,
                min: 1,
                max: 1000
            })

        }



        function handleSubmit() {

            if (!document.getElementById('desktopUsername').classList.contains('ok') && !document.getElementById('desktopUsername').classList.contains('error')) {
                usernameHandler()
            }

            descriptionPHandler()



            if (loggedIn) {

                nameHandler()
            } else {

                emailHandler()
                passwordHandler()
            }







            if (loggedIn) {

                if (
                    document.getElementById('desktopUsername').classList.contains('ok') &&
                    document.getElementById('fullNameS').classList.contains('ok') &&
                    document.getElementById('descriptionjtc2').classList.contains('ok')
                ) {

                    submitAccountDetails('create')

                    return
                }
                console.log("Private Post Failed", formData)
                console.log("Errors", formStatus)
            } else {

                if (window.passer && window.emailer && document.getElementById('desktopUsername').classList.contains('ok') &&
                    document.getElementById('descriptionjtc2').classList.contains('ok')) {



                    submitAccountDetails('create')

                }
            }






        }

    }

    /*  if (document.getElementById("jtc2Step2Form")) {

         let first = document.getElementById('first')
         let seccond = document.getElementById('seccond')
         let third = document.getElementById('third')
         let fourth = document.getElementById('fourth')
         let fifth = document.getElementById('fifth')
         let sixth = document.getElementById('sixth')
         let submitButton = document.getElementById('submitVerifyEmail')

         first.focus()



         function handlePaste(e) {
             var clipboardData, pastedData;

             // Stop data actually being pasted into div

             e.preventDefault()

             // Get pasted data via clipboard API
             clipboardData = e.clipboardData || window.clipboardData;
             pastedData = clipboardData.getData('Text');

             // Do whatever with pasteddata
             if (pastedData.length >= 6) {

                 pasteCode(pastedData)

             } else {

                 toastify(getPoTranslate('YOU_PASTED_STRING_IN_WRONG_FORMAT') + '|' + pastedData.length)

             }
         }

         first.addEventListener('paste', handlePaste)
         first.addEventListener('input', function (e) {



             if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                 if (e.data == 'e') {

                     first.value = ''
                 }

                 first.focus()

             } else if (
                 e.data == 0 ||
                 e.data == 1 ||
                 e.data == 2 ||
                 e.data == 3 ||
                 e.data == 4 ||
                 e.data == 5 ||
                 e.data == 6 ||
                 e.data == 7 ||
                 e.data == 8 ||
                 e.data == 9
             ) {

                 first.style.border = "1px solid transparent"

                 setTimeout(function () {
                     seccond.focus()
                 }, 10)


             }




         })
         seccond.addEventListener('keydown', function (e) {
             if (seccond.value.length === 0) {
                 if (e.key === "Backspace") {

                     first.focus()
                 }
             }

         })
         seccond.addEventListener('paste', handlePaste)
         seccond.addEventListener('input', function (e) {


             if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                 if (e.data == 'e') {

                     first.value = ''
                 }

                 seccond.focus()

                 if (seccond.value === '') {

                     first.focus()
                 }

             } else if (
                 e.data == 0 ||
                 e.data == 1 ||
                 e.data == 2 ||
                 e.data == 3 ||
                 e.data == 4 ||
                 e.data == 5 ||
                 e.data == 6 ||
                 e.data == 7 ||
                 e.data == 8 ||
                 e.data == 9
             ) {

                 seccond.style.border = "1px solid transparent"

                 setTimeout(function () {
                     third.focus()
                 }, 10)


             }

         })
         third.addEventListener('paste', handlePaste)
         third.addEventListener('keydown', function (e) {
             if (third.value.length === 0) {
                 if (e.key === "Backspace") {

                     seccond.focus()
                 }
             }

         })

         third.addEventListener('input', function (e) {



             if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                 if (e.data == 'e') {

                     third.value = ''
                 }

                 third.focus()
                 if (third.value === '') {
                     seccond.focus()
                 }

             } else if (
                 e.data == 0 ||
                 e.data == 1 ||
                 e.data == 2 ||
                 e.data == 3 ||
                 e.data == 4 ||
                 e.data == 5 ||
                 e.data == 6 ||
                 e.data == 7 ||
                 e.data == 8 ||
                 e.data == 9
             ) {

                 third.style.border = "1px solid transparent"

                 setTimeout(function () {
                     fourth.focus()
                 }, 10)


             }
         })


         fourth.addEventListener('paste', handlePaste)
         fourth.addEventListener('input', function (e) {



             if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                 if (e.data == 'e') {

                     fourth.value = ''
                 }

                 fourth.focus()
                 if (fourth.value === '') {
                     third.focus()
                 }

             } else if (
                 e.data == 0 ||
                 e.data == 1 ||
                 e.data == 2 ||
                 e.data == 3 ||
                 e.data == 4 ||
                 e.data == 5 ||
                 e.data == 6 ||
                 e.data == 7 ||
                 e.data == 8 ||
                 e.data == 9
             ) {

                 fourth.style.border = "1px solid transparent"

                 setTimeout(function () {
                     fifth.focus()
                 }, 10)


             }
         })


         fifth.addEventListener('paste', handlePaste)

         fifth.addEventListener('input', function (e) {


             if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                 if (e.data == 'e') {

                     fifth.value = ''
                 }

                 fifth.focus()
                 if (fifth.value === '') {
                     fourth.focus()
                 }

             } else if (
                 e.data == 0 ||
                 e.data == 1 ||
                 e.data == 2 ||
                 e.data == 3 ||
                 e.data == 4 ||
                 e.data == 5 ||
                 e.data == 6 ||
                 e.data == 7 ||
                 e.data == 8 ||
                 e.data == 9
             ) {

                 fifth.style.border = "1px solid transparent"

                 setTimeout(function () {
                     sixth.focus()
                 }, 10)
             }
         })

         sixth.addEventListener('paste', handlePaste)

         sixth.addEventListener('input', function (e) {
             pasteCode(e)

             if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                 if (e.data == 'e') {

                     sixth.value = ''
                 }

                 sixth.focus()
                 if (sixth.value === '') {
                     fifth.focus()
                 }

             } else if (
                 e.data == 0 ||
                 e.data == 1 ||
                 e.data == 2 ||
                 e.data == 3 ||
                 e.data == 4 ||
                 e.data == 5 ||
                 e.data == 6 ||
                 e.data == 7 ||
                 e.data == 8 ||
                 e.data == 9
             ) {

                 sixth.style.border = "1px solid transparent"

                 setTimeout(function () {
                     submitButton.focus()
                 }, 10)
             }
         })

         submitButton.addEventListener('click', submitVerifyEmail)

         function submitVerifyEmail(e) {

             e.preventDefault()

             let verifyInputsContainer = document.getElementById('verifyInputsContainer').getElementsByTagName('input')
             let counter = 0
             for (let i = 0; i < verifyInputsContainer.length; i++) {
                 if (verifyInputsContainer[i].value === '' || verifyInputsContainer[i].value.length > 1) {
                     verifyInputsContainer[i].style.cssText = "border:1px solid red; border-bottom:2px solid red!important"

                     counter++
                 }

             }

             if (counter > 0) {
                 document.getElementById('verifyInputsContainer').style.border = " 1px solid red"
                 document.getElementById('verifyInputsContainerMessage').textContent = getPoTranslate('PLEASE_FILL_ALL_FIELDS')
                 setTimeout(function () {
                     document.getElementById('verifyInputsContainer').style.border = " 1px solid rgba(6,4,3,.1)"
                     document.getElementById('verifyInputsContainerMessage').textContent = ''
                 }, 5000)
             } else {
                 //ajax here
                 console.log(formData, formStatus);

             }

         }

     } */
}



function submitAccountDetails() {
    showLoading()




    let xhr = new XMLHttpRequest()


    let url


    if (loggedIn) {
        url = '/frontend/api/edit-profile-name-and-username'
    } else {
        let slug = document.getElementsByClassName('partnerLogo')[0].getElementsByTagName('img')[0].dataset.partnerSlug
        if(!slug){
            toastify(getPoTranslate('SOMETHING_WENT_WRONG'))
            return
        }
        url = envAppBackendUrl + '/' + slug  + '/account/create'
    }

    let form = document.getElementById('jtc2Step1Form').elements

    let formings = {
        name:               form['fullNameS'] ? form['fullNameS'].value : (form['step1username'].value ?? ''),
        username:           form['step1username'].value ?? '',
        password:           typeof form['password'] !== 'undefined' ? form['password'].value : '',
        email:              typeof form['emails'] !== 'undefined' ? form['emails'].value : '',
        description:        form['addBio'].value !== '' ? form['addBio'].value : null,
        language:           getCookie('activeLang') !== '' ? getCookie('activeLang') : 'de',
        country:            getCookie('activeLang') !== '' ? getCookie('activeLang') : 'de',
        image:              document.getElementsByClassName('imagePointerForCropper')[0].getElementsByTagName('img')[0].src ?? '',
        timezone_offset:    getCookie('timezone') !== '' ? getCookie('timezone') : 0,
        partner_email:      typeof form['emails'] !== 'undefined' ? form['emails'].value : ''
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            let response = JSON.parse(this.response)


            if (response.success === true) {

                toastify(response.message)

                if (!loggedIn) {


                    location.assign('/account/login?email=' + form['emails'].value + '&message=' + getPoTranslate('VERIFICATION_LINK_SEND'))
                } else {

                    location.assign('/jtc/create-your-first-talk')
                }





                if (response.hasOwnProperty('data')) {


                    if (response.data.hasOwnProperty('errors')) {

                        let errors = response.data.errors

                        for (const property in errors) {
                            toastify(`${errors[property]}`);
                        }
                    }


                }


            } else {

            }



            hideLoading()
        } else if (this.readyState == 4 && this.status != 200) {


            let response = JSON.parse(this.response)

            if (response.hasOwnProperty('data')) {

                if (response.data.hasOwnProperty('errors')) {

                    let errors = response.data.errors


                    for (const property in errors) {
                        toastify(`${errors[property]}`)
                    }



                }
            }

            if (response.hasOwnProperty('errors')) {

                let errors = response.errors



                for (const property in errors) {
                    toastify(`${errors[property]}`);
                }



            }



        }
    }

    xhr.onloadend = function () {

        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', document.querySelector('meta[name="access_token"]').content)
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content)

    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(formings))
}

function pasteCode(pastedData) {

    let pastedString = pastedData

    if (pastedString[0]) {
        first.value = pastedString[0]
    }

    if (pastedString[1]) {
        seccond.value = pastedString[1]
    }

    if (pastedString[2]) {
        third.value = pastedString[2]
    }

    if (pastedString[3]) {
        fourth.value = pastedString[3]
    }

    if (pastedString[4]) {
        fifth.value = pastedString[4]
    }

    if (pastedString[5]) {
        sixth.value = pastedString[5]
    }

}

class GetTokenErrorJTCStep1 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenErrorJTCStep1"
    }
}
class JTCStep1SubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "JTCStep1SubmitError"
    }
}

(function () {
    initJtc2Step1Validators()
})()
