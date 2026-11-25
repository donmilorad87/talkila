let nameStatus = {}
let emailStatus = {}
let passwordStatus = {}

function initSignUpValidation() {

    if (document.getElementById("signup-form")) {
        let nameInput = document.getElementsByClassName("name-input")[0]
        let emailInput = document.getElementsByClassName("email-input")[0]
        let passwordInput = document.getElementsByClassName("password-input")[0]
        let submitButton = document.getElementById("submit-button")
        let token = document.getElementById('signup-form').elements['_token']

        let nameWarn = document.getElementsByClassName("name-warn")[0]
        let emailWarn = document.getElementsByClassName("email-warn")[0]
        let passwordWarn = document.getElementsByClassName("password-warn")[0]

        let nameSvg = document.getElementsByClassName("verified-name-svg")[0]
        let emailSvg = document.getElementsByClassName("verified-email-svg")[0]
        let passwordSvg = document.getElementsByClassName("verified-password-svg")[0]

        let passwordValidationFields = document.getElementsByClassName('validationFields')[0]

        nameInput.addEventListener("input", nameHandler)
        emailInput.addEventListener("input", emailHandler)
        passwordInput.addEventListener("input", passwordHandler)
        if(!document.getElementById('reCapatchaInputero')){
            submitButton.addEventListener("click", handleSubmit)
        }else{
            submitButton.addEventListener("click", window.handleSubmitto)
        }


        function nameHandler() {
            let check = nameCheck(nameInput.value)
            countLabelDriver({ el: nameInput, min: 4, max: 50 })
            nameStatus = check
            if (check.isOk) {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                nameInput.classList.remove("error")
                nameInput.classList.add("ok")
                nameSvg.classList.add("active")
                nameWarn.classList.remove("active")
                nameInput.parentElement.getElementsByClassName('clear-button')[0].style.right = '42px'
            } else {
                nameInput.parentElement.getElementsByClassName('clear-button')[0].style.right='16px'
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                nameInput.classList.add("error")
                nameInput.classList.remove("ok")
                nameSvg.classList.remove("active")
                nameWarn.classList.add("active")

                nameWarn.innerHTML = "&nbsp"
                nameWarn.innerHTML += check.hasName ? "" : translate.missingName + ","
                nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.missingSurname + ","
                nameWarn.innerHTML += check.hasNumber ? " " + translate.noNumbers + "," : ""
                nameWarn.innerHTML += check.hasSymbol ? " " + translate.noSpecialCharacters + "," : ""
                nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {'minimum_characters':'4', 'maximum_characters':'50'}) + "," : ""

                nameWarn.textContent = removeCommaFromValidationWarning(nameWarn.textContent)

            }
        }

        function emailHandler() {
            let check = emailCheck(emailInput.value)
            emailStatus = check
            if (check.isOk) {
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                emailInput.classList.remove("error")
                emailInput.classList.add("ok")
                emailSvg.classList.add("active")
                emailWarn.classList.remove("active")

                emailInput.parentElement.getElementsByClassName('clear-button')[0].style.right = '42px'
            } else {
                emailInput.parentElement.getElementsByClassName('clear-button')[0].style.right='16px'
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                emailInput.classList.add("error")
                emailInput.classList.remove("ok")
                emailSvg.classList.remove("active")
                emailWarn.classList.add("active")
            }
        }

        function passwordHandler() {
            let check = passwordCheck(passwordInput.value)
            countLabelDriver({ el: passwordInput, min: 8, max: 50 })
            passwordStatus = check
            if (check.isOk) {

                passwordInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                passwordInput.classList.remove("error")
                passwordInput.classList.add("ok")
                passwordSvg.classList.add("active")
                passwordWarn.classList.remove("active")
                passwordValidationFields.style.maxHeight = '0px'
                passwordInput.parentElement.getElementsByClassName('clear-button')[0].style.right = '42px'

            } else {

                passwordValidationFields.innerHTML = ''
                passwordValidationFields.style.maxHeight = '100px'
                passwordInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                passwordInput.classList.add("error")
                passwordInput.classList.remove("ok")
                passwordSvg.classList.remove("active")
                passwordWarn.classList.add("active")

                for (let i = 0; i < Object.keys(check).length; i++) {
                    if(Object.keys(check)[i] === 'isOk'){

                    }else{
                        if(Object.values(check)[i].isOk){

                            createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'green', check, i)

                        }else{

                            createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'red', check, i)

                        }
                    }

                }

            }
        }

        window.handleSubmitto = function(e) {
            helperRecapatcha(e)


        }

        function handleSubmit(e) {
            helperRecapatcha(e)


        }

        function helperRecapatcha(e){
            if(e){
                e.preventDefault()
            }

            nameHandler()
            emailHandler()
            passwordHandler()

            let postData = {
                name: nameInput.value,
                email: emailInput.value,
                password: passwordInput.value,
                token: token.value
            }
            if (document.getElementById('checkbox1')) {
                if (document.getElementById('checkbox1').checked) {
                    if (nameStatus.isOk && emailStatus.isOk && passwordStatus.isOk) {


                        let affiliateRefereeHash
                        if(getCookie('affiliateRefereeHash') !== ''){
                            affiliateRefereeHash = getCookie('affiliateRefereeHash')
                        }else{
                            affiliateRefereeHash = false
                        }

                        jQuery.ajax({
                            type: 'POST',
                            headers: {
                                "Accept": 'application/json',
                                "X-CSRF-TOKEN": postData.token,
                                "Time-Zone-Offset-UTC": getCookie('timezone')
                            },
                            url: '/user-register',
                            data: {
                                'name': postData.name,
                                'email': postData.email,
                                'password': postData.password,
                                'affiliateRefereeHash': affiliateRefereeHash
                            },
                            beforeSend: function () {
                                showLoading()
                            },
                            complete: function () {
                                hideLoading()
                            },
                            success: function (response) {
                                if (response.success) {
                                    deleteCookie('affiliateRefereeHash', '/account/signup')
                                    deleteCookie('affiliateRefereeHash', '/lp')
                                    showLoading()
                                    //toastify(response.message)

                                    //toastify(getPoTranslate('REDIRECTED_TO_LOGIN'))
                                    //setTimeout(function(){
                                        location.assign(response.path)
                                    //},5000)
                                } else {
                                    toastify(response.message)
                                }
                            },
                            error: function (error) {
                                Sentry.captureException(new SigunUpSubmitError(error))
                            }
                        })


                    } else {

                        console.log("signup failed", postData)
                        console.log("signup errors", { nameStatus, emailStatus, passwordStatus })

                    }
                } else {
                    toastify(getPoTranslate('YOU_MUST_AGREE_TERMS'))
                    document.getElementsByClassName('check-filed-wrap')[0].style.cssText = "border:1px solid #ea4335; border-radius:4px;"
                    setTimeout(function () {
                        document.getElementsByClassName('check-filed-wrap')[0].style.border = "1px solid white"
                    }, 4000)
                }
            }
        }
    }
}

class SigunUpSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "LoginSubmitError"
    }
}

(function () {
    initSignUpValidation()
})();
