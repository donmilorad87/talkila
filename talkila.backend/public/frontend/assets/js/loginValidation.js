let emailStatus = {}
let passwordStatus = {}

function initLoginValidation() {
    if (document.getElementById("login-form")) {

        let emailInput = document.getElementsByClassName("email-input")[0]
        let passwordInput = document.getElementsByClassName("password-input")[0]
        let submitButton = document.getElementById("loginSubmit")
        let token = document.getElementById('login-form').elements['_token']

        let emailWarn = document.getElementsByClassName("email-warn")[0]
        let passwordWarn = document.getElementsByClassName("password-warn")[0]


        let emailSvg = document.getElementsByClassName("verified-email-svg")[0]
        let passwordSvg = document.getElementsByClassName("verified-password-svg")[0]

        let passwordValidationFields = document.getElementsByClassName('validationFields')[0]

        emailInput.addEventListener("input", emailHandler)
        passwordInput.addEventListener("input", passwordHandler)
        submitButton.addEventListener("click", handleSubmit)

        function emailHandler() {
            let check = emailCheck(emailInput.value)
            emailStatus = check
            if (check.isOk) {
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                emailInput.classList.remove("error")
                emailInput.classList.add("ok")
                emailSvg.classList.add("active")
                emailInput.parentElement.getElementsByClassName('verified-email-svg')[0].style.right= '8px'
                emailInput.parentElement.getElementsByClassName('clear-button')[0].style.right='42px'
        
                emailWarn.classList.remove("active")

            } else {
                emailInput.parentElement.getElementsByClassName('verified-email-svg')[0].style.right= '-58px'
                emailInput.parentElement.getElementsByClassName('clear-button')[0].style.right='16px'
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                emailInput.classList.add("error")
                emailInput.classList.remove("ok")
                emailSvg.classList.remove("active")
                emailWarn.classList.add("active")
            }
        }

        function passwordHandler() {

            countLabelDriver({ el: passwordInput, min: 8, max: 50 })
            let check = passwordCheck(passwordInput.value)


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



            passwordWarn.textContent = removeCommaFromValidationWarning(passwordWarn.textContent)

        }

        function handleSubmit(e) {

            e.preventDefault()

            emailHandler(true)
            passwordHandler(true)

            let postData = {
                email: emailInput.value,
                password: passwordInput.value,
                token: token.value,
                timezone_offset: document.querySelector('#timezoneOffset')?.value
            }

            let postStatus = {
                email: emailStatus,
                password: passwordStatus
            }

            if (emailStatus.isOk && passwordStatus.isOk) {


                jQuery.ajax({
                    type: 'POST',
                    headers: {
                        "Accept": 'application/json',
                        "X-CSRF-TOKEN": postData.token,
                        "Time-Zone-Offset-UTC": getCookie('timezone')
                    },
                    url: '/account/login',
                    data: {
                        'email': postData.email,
                        'password': postData.password,
                        '_token': postData.token,
                        'timezone_offset': postData.timezone_offset
                    },
                    beforeSend: function () {
                        showLoading()
                    },
                    complete: function () {
                        hideLoading()
                    },
                    success: function (response) {

                       if (response.success === true) {

                            toastify(response.message)
                            location.assign(response.path)

                        } else {

                            toastify(response.message)

                        }
                    },
                    error: function (error) {
                        Sentry.captureException(new LoginSubmitError(error))
                    }
                })

            } else {
                console.log("login post data", postData)
                console.log("login post erorrs", postStatus)
                toastify(getPoTranslate('FAILED_LOGIN_VALIDATION'))
            }

        }
    }
}

class LoginSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "LoginSubmitError"
    }
}

(function () {
    initLoginValidation()
})();
