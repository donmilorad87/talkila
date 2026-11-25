let emailStatus = {}

function initForgotValidation() {
    if (document.getElementById("forgot-form")) {

        let emailInput = document.getElementsByClassName("email-input")[0]
        let token = document.getElementById('forgot-form').elements['_token']
        let submitButton = document.getElementById("submit-button")

        let emailWarn = document.getElementsByClassName("email-warn")[0]

        let emailSvg = document.getElementsByClassName("verified-email-svg")[0]

        emailInput.addEventListener("keyup", emailHandler)
        submitButton.addEventListener("click", handleSubmit)

        function emailHandler(strict) {
            let check = emailCheck(emailInput.value)
            emailStatus = check
            if (check.isOk) {
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                emailInput.classList.remove("error")
                emailInput.classList.add("ok")
                emailSvg.classList.add("active")
                emailWarn.classList.remove("active")
                emailInput.parentElement.getElementsByClassName('clear-button')[0].style.right = '42px'
                emailInput.parentElement.getElementsByClassName('verified-email-svg')[0].style.right = '8px'
            } else {
                emailInput.parentElement.getElementsByClassName('clear-button')[0].style.right = '16px'
                emailInput.parentElement.getElementsByClassName('verified-email-svg')[0].style.right = '-52px'
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                emailInput.classList.add("error")
                emailInput.classList.remove("ok")
                emailSvg.classList.remove("active")
                emailWarn.classList.add("active")
            }
        }

        function handleSubmit(e) {
            e.preventDefault()
            emailHandler(true)

            let postData = {
                email: emailInput.value,
                token: token.value
            }

            if (emailStatus.isOk) {

                jQuery.ajax({
                    type: 'POST',
                    headers: {
                        "Accept": 'application/json',
                        "X-CSRF-TOKEN": postData.token,
                        "Time-Zone-Offset-UTC": getCookie('timezone')
                    },
                    url: '/forgot-password',
                    data: {
                        'email': postData.email,
                    },
                    beforeSend: function () {
                        showLoading()
                    },
                    complete: function () {
                        hideLoading()
                    },
                    success: function (response) {
                        if (response.success) {
                            showLoading()
                            toastify(response.message)
                          /*   toastify('You will be redirected to the login page in 5 secconds')
                            setTimeout(function(){
                                location.assign(response.path)
                            },5000) */
                        } else {
                            toastify(response.message)
                        }
                    },
                    error: function (error) {
                        Sentry.captureException(new ForgotPasswordSubmitError(error))
                    }
                })

            } else {

                console.log("Forgot Password data", postData)
                console.log("Forgot Password fail", emailStatus)

            }
        }
    }
}

class ForgotPasswordSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "LoginSubmitError"
    }
}

(function () {
    initForgotValidation()
})();
