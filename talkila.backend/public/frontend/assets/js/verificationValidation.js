

function initVerification() {

    let nameStatus = {}

    if (document.getElementById("verification-form")) {
        let nameInput
        let submitButton
        if(document.body.className === "jtc_account_verification" || document.body.className === "jtc2_verify_account"){
            nameInput = document.getElementById("verification-form").elements['name']
            submitButton = document.getElementsByClassName("checkImageBeforeUpload")[0]
        }else{
            nameInput = document.getElementById("verificationFullName")
            submitButton = document.getElementById("checkImageBeforeUploadVerification")
        }



        let nameWarn = nameInput.parentElement.getElementsByClassName("name-warn")[0]
        let nameSvg = nameInput.parentElement.getElementsByClassName("verified-name-svg")[0]


        nameInput.addEventListener("keyup", nameHandler)
        submitButton.addEventListener('click', handleSubmit)



        function nameHandler() {
            countLabelDriver({ el: nameInput, min: 4, max: 50 })
            let check = nameCheck(nameInput.value)

            nameStatus = check

            if (check.isOk) {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                nameInput.classList.remove("error")
                nameInput.classList.add("ok")
                nameSvg.classList.add("active")
                nameWarn.classList.remove("active")

            } else {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                nameInput.classList.add("error")
                nameInput.classList.remove("ok")
                nameSvg.classList.remove("active")
                nameWarn.classList.add("active")

                nameWarn.innerHTML = "&nbsp"
                nameWarn.innerHTML += check.hasName ? "" : " " + translate.hasName + ","
                nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.hasSurname + ","
                nameWarn.innerHTML += check.hasNumber ? " " + translate.hasNumber + "," : ""
                nameWarn.innerHTML += check.hasSymbol ? " " + translate.hasSymbol + "," : ""
                nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {'minimum_characters':'4', 'maximum_characters':'50'}) + "," : ""
                nameWarn.textContent = removeCommaFromValidationWarning(nameWarn.textContent)
            }
        }

        function isUploadFilePresent() {
            let uploadedFIle = document.getElementsByClassName("drop-area")
            for (let i = 0; i <uploadedFIle.length; i++){
                if (window.fileUpl) {
                    uploadedFIle[i].classList.remove("error")
                } else {
                    uploadedFIle[i].classList.add("error")
                }
            }

        }

        function handleSubmit(e) {
            e.preventDefault()
            nameHandler()
            isUploadFilePresent()

            let postData = {
                name: nameInput.value,
                file: window.fileUpl
            }
            let postStatus = {
                name: nameStatus,
                attacment: window.fileUpl
            }

            if (nameStatus.isOk && window.fileUpl) {
                //submitVerification()

                if(window.verificationSuccess != 2){
                    window.verificationSuccess = 1
                }

            } else {

                if(typeof postStatus.attacment === 'undefined'){
                    toastify(getPoTranslate('ID_IMG_UPLOADED'))
                }else{
                    toastify(getPoTranslate('FULL_NAME_FOR_VERIFICATION'))
                    console.log("verification data", postData)
                    console.log("verification error", postStatus)
                }
            }
        }
    }
}


(function () {
    initVerification()
})();
