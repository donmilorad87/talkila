


function initFullNameValidation() {

    let nameStatus = {}

    let nameValue

    if (document.getElementById("edit_full_name_form")) {

        let nameInput = document.getElementById('editFullName').getElementsByClassName("name-input")[0]



        let nameWarn = nameInput.parentElement.getElementsByClassName("name-warn")[0]

        let nameSvg = nameInput.parentElement.getElementsByClassName("verified-name-svg")[0]



        nameInput.addEventListener("input", nameHandler)
        nameInput.addEventListener("cange", nameHandler)


        document.getElementById("editFullNameButton").addEventListener("click", handleSubmit)


        function nameHandler() {
            nameValue = document.getElementById('editFullName').getElementsByClassName("name-input")[0].value

            let check = nameCheck(nameValue)
                nameStatus = check

            if (check.isOk) {

                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                countLabelDriver({ el: nameInput, min: 2, max: 100 })
                    nameInput.classList.remove("error")
                    nameInput.classList.add("ok")

                    nameSvg.classList.add("active")
                    nameWarn.classList.remove("active")

            } else {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'

                countLabelDriver({ el: nameInput, min: 2, max: 100 })


                    nameInput.classList.add("error")
                    nameInput.classList.remove("ok")

                    nameSvg.classList.remove("active")

                    nameWarn.classList.add("active")

                    nameWarn.innerHTML = "&nbsp"
                    nameWarn.innerHTML += check.hasName ? "" : translate.missingName + ","
                    nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.missingSurname + ","
                    nameWarn.innerHTML += check.hasNumber ? " " + translate.noNumbers + "," : ""
                    nameWarn.innerHTML += check.hasSymbol ? " " + translate.noSpecialCharacters + "," : ""
                    nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {'minimum_characters':'2', 'maximum_characters':'100'}) + "," : ""



            }
            nameWarn.textContent = removeCommaFromValidationWarning(nameWarn.textContent)
        }

        function handleSubmit(e) {
            e.preventDefault()
            nameHandler()

            let postData = {
                name: nameValue
            }

            let postStatus = {
                name: nameStatus
            }

            var token  = '';

            if (nameStatus.isOk) {
                //this is where ajax call should be made


                submitValidationForm(postData)



            } else {
                console.log("fullName validation failed", postData)
                console.log("fullName validation errors", postStatus)
            }

        }

         function submitValidationForm(formData)
        {
            let token = document.getElementById('edit_full_name_form').elements['_token'].value

            jQuery.ajax({
                type:'POST',
                headers: {
                    "Accept": 'application/json'
                },
                url: '/frontend/api/edit-profile-name',
                data: {
                    'name': formData.name,
                    '_token': token
                },
                beforeSend: function(){
                    // Handle the beforeSend event
                    showLoading()
                },
                complete: function() {
                    hideLoading()
                },
                success:function(response) {

                    if(response.success) {

                        if(document.getElementsByClassName('mobName')[0]){
                            document.getElementsByClassName('mobName')[0].textContent = formData.name
                        }
                        if(document.body.className === "settings_profile"){
                          document.getElementById('fullNameHolder').value = formData.name
                        }

                        closePopup('editFullName')
                        toastify(response.message)

                        return response.message

                    } else {
                        toastify(response.message)
                        return response.message
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new FullNameSubmitError(errorMessage + ' url: ' + location.href ));
                }
            });
        }
    }
}

class GetTokenFullNameError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenFullNameError"
    }
}
class FullNameSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "FullNameSubmitError"
    }
}


(function () {
    initFullNameValidation()
})();
