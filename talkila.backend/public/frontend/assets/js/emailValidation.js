let emailStatus = {}

function initEmailValidation() {
    if (document.getElementById("edit_email_form")) {

        let emailInput = document.getElementById("edit_email_form").elements['email']
        let submitButton = document.getElementById("emailSubmit")


        let emailWarn = document.getElementById("edit_email_form").getElementsByClassName("email-warn")[0]
        let emailSvg = document.getElementById("edit_email_form").getElementsByClassName("verified-email-svg")[0]



        emailInput.addEventListener("keyup", emailHandler)

        submitButton.addEventListener("click", handleSubmit)


        function emailHandler() {
            let check = emailCheck(emailInput.value)
            emailStatus = check
            if (check.isOk) {
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                emailInput.classList.remove("error")
                emailInput.classList.add("ok")
                emailSvg.classList.add("active")
                emailWarn.classList.remove("active")

            } else {
                emailInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                emailInput.classList.add("error")
                emailInput.classList.remove("ok")
                emailSvg.classList.remove("active")
                emailWarn.classList.add("active")
            }
            emailWarn.textContent = removeCommaFromValidationWarning(emailWarn.textContent)
        }


        function handleSubmit(e) {
            e.preventDefault()
            emailHandler(true)

            let postData = {
                email: emailInput.value,
            }

            let postStatus = {
                email: emailStatus,
            }

            if (emailStatus.isOk) {
                submitValidationForm(postData)
            } else {
                console.log("login post data", postData)
                console.log("login post erorrs", postStatus)
                toastify('Something went wrong')
            }

        }

        function submitValidationForm(formData)
        {
            let token = document.querySelector('meta[name="csrf-token"]').content

            jQuery.ajax({
                type:'POST',
                url: '/frontend/api/edit-profile-email',
                data: {
                    'email'  :formData.email,
                    '_token' :token
                },
                beforeSend: function() {
                    // Handle the beforeSend event
                    showLoading()
                },
                complete: function() {
                    hideLoading()
                },
                success:function(response) {

                    if(response.success) {
                        window.location.reload(false);

                    } else {
                        toastify(response.message)
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new EmailValidationSubmitError(errorMessage + ' url: ' + location.href ));
                }
            });
        }
    }
}

class GetTokenEmail extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenEmail"
    }
}
class EmailValidationSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "EmailValidationSubmitError"
    }
}

(function () {
    initEmailValidation()
})();
